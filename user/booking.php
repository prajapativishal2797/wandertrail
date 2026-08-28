<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$profile = db_one($con, 'SELECT user_id FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [current_user_email()]);
$userId = (int)($profile['user_id'] ?? 0);
$type = (string)($_GET['type'] ?? $_POST['type'] ?? '');
$itemId = (int)($_GET['id'] ?? $_POST['item_id'] ?? 0);
$mode = (string)($_GET['mode'] ?? $_POST['mode'] ?? 'standard');
$errors = [];
$item = null;
$hotels = [];
if ($type === 'hotel') {
    $item = db_one($con, 'SELECT h.*,p.place_name FROM tbl_hotel h LEFT JOIN tbl_place p ON p.place_id=h.place_id WHERE h.hotel_id=? AND h.isdeleted=0 AND h.hotel_status="available"', [$itemId]);
} elseif ($type === 'package') {
    $item = db_one($con, 'SELECT pk.*,p.place_name,h.hotel_name FROM tbl_package pk LEFT JOIN tbl_place p ON p.place_id=pk.place_id LEFT JOIN tbl_hotel h ON h.hotel_id=pk.hotel_id WHERE pk.package_id=? AND pk.isdeleted=0', [$itemId]);
    $hotels = db_all($con, 'SELECT hotel_id,hotel_name,hotel_category,hotel_price FROM tbl_hotel WHERE isdeleted=0 AND hotel_status="available" ORDER BY hotel_name');
}
if (is_post() && $item) {
    csrf_require();
    $start = request_string('start_date');
    $end = request_string('end_date');
    $adults = max(1, min(20, request_int('adults', 1, 'post')));
    $children = max(0, min(20, request_int('children', 0, 'post')));
    $rooms = max(1, min(10, request_int('rooms', 1, 'post')));
    if ($start === '' || !strtotime($start) || $start < date('Y-m-d')) $errors[] = 'Choose a valid future travel date.';
    if ($type === 'hotel') {
        if ($end === '' || !strtotime($end) || $end <= $start) $errors[] = 'Check-out must be after check-in.';
        $nights = max(1, (int)((strtotime($end) - strtotime($start)) / 86400));
        $pickup = isset($_POST['airport_pickup']) ? (int)$item['airport_pickup'] : 0;
        $parking = isset($_POST['car_parking']) ? (int)$item['car_parking'] * $nights : 0;
        $breakfast = isset($_POST['extra_breakfast']) ? (int)$item['extra_breakfast'] * $nights * ($adults + $children) : 0;
        $amount = (int)$item['hotel_price'] * $nights * $rooms + $pickup + $parking + $breakfast;
        if (!$errors) {
            db_execute($con, 'INSERT INTO tbl_hotelbooking (hotel_id,amount,depart_date,return_date,adults,childs,no_rooms,user_id,airport_pickup,car_parking,extra_breakfast,hotelbooking_date,isapproved,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,CURDATE(),"pending","not paid")', [$itemId, $amount, $start, $end, $adults, $children, $rooms, $userId, $pickup, $parking, $breakfast]);
            flash_success('Your hotel booking request has been submitted.');
            redirect('hotelbookinglist.php');
        }
    } else {
        $persons = $adults + $children;
        preg_match('/\d+/', (string)$item['package_duration'], $durationMatch);
        $days = max(1, (int)($durationMatch[0] ?? 1));
        $end = date('Y-m-d', strtotime($start . ' +' . $days . ' days'));
        $hotelId = $mode === 'custom' ? request_int('hotel_id', (int)$item['hotel_id'], 'post') : (int)$item['hotel_id'];
        $category = $mode === 'custom' ? request_string('package_category', 'Custom') : 'Standard';
        $amount = (int)$item['package_startprice'] * $persons;
        if (!$errors) {
            db_execute($con, 'INSERT INTO tbl_packagebooking (package_id,amount,start_date,end_date,adults,childs,no_rooms,package_category,hotel_id,user_id,packagebooking_date,isapproved,status) VALUES (?,?,?,?,?,?,?,?,?,?,CURDATE(),"pending","not paid")', [$itemId, $amount, $start, $end, $adults, $children, $rooms, $category, $hotelId, $userId]);
            flash_success('Your package booking request has been submitted.');
            redirect('packagebookinglist.php');
        }
    }
}
$userPageTitle = 'Book ' . ($item['hotel_name'] ?? $item['package_name'] ?? 'travel') . ' | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell"><?php if (!$item): ?>
            <div class="eg-empty-state"><h2>Travel option unavailable</h2>
                <p>This hotel or package cannot currently be booked.</p></div><?php else: ?>
            <div class="eg-account-form-heading">
            <p><?= e($mode === 'custom' ? 'Custom package' : $type . ' booking') ?></p>
            <h1><?= e($item['hotel_name'] ?? $item['package_name']) ?></h1><span><?= e($item['place_name'] ?? '') ?> · prices are confirmed by the agency after review</span>
            </div><?php foreach ($errors as $error): ?>
                <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
            <form method="post" class="eg-account-form"><?= csrf_field() ?><input type="hidden" name="type"
                                                                                  value="<?= e($type) ?>"><input
                    type="hidden" name="item_id" value="<?= $itemId ?>"><input type="hidden" name="mode"
                                                                               value="<?= e($mode) ?>">
            <div class="eg-form-grid"><label>Travel start<input type="date" name="start_date" min="<?= date('Y-m-d') ?>"
                                                                value="<?= e($_POST['start_date'] ?? '') ?>"
                                                                required></label><?php if ($type === 'hotel'): ?><label>
                    Check-out<input type="date" name="end_date" min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                    value="<?= e($_POST['end_date'] ?? '') ?>" required></label><?php endif; ?><label>Adults<input
                            type="number" name="adults" min="1" max="20" value="<?= e($_POST['adults'] ?? '1') ?>"
                            required></label><label>Children<input type="number" name="children" min="0" max="20"
                                                                   value="<?= e($_POST['children'] ?? '0') ?>"></label><label>Rooms<input
                            type="number" name="rooms" min="1" max="10" value="<?= e($_POST['rooms'] ?? '1') ?>"
                            required></label>
                <?php if ($type === 'hotel'): ?><label class="wide eg-check-list">
                    <span>Optional services</span><i><input type="checkbox" name="airport_pickup"> Airport pickup
                        (₹<?= number_format((float)$item['airport_pickup']) ?>)</i><i><input type="checkbox"
                                                                                             name="car_parking"> Car
                        parking (₹<?= number_format((float)$item['car_parking']) ?>/night)</i><i><input type="checkbox"
                                                                                                        name="extra_breakfast">
                        Breakfast (₹<?= number_format((float)$item['extra_breakfast']) ?>/person/night)</i>
                    </label><?php elseif ($mode === 'custom'): ?><label>Preferred hotel<select
                            name="hotel_id"><?php foreach ($hotels as $hotel): ?>
                            <option
                            value="<?= (int)$hotel['hotel_id'] ?>"><?= e($hotel['hotel_name'] . ' · ' . $hotel['hotel_category']) ?></option><?php endforeach; ?>
                    </select></label><label>Travel style<select name="package_category">
                        <option>Budget</option>
                        <option>Comfort</option>
                        <option>Premium</option>
                        <option>Luxury</option>
                    </select></label><?php endif; ?></div>
            <div class="eg-form-actions">
                <button type="submit">Submit booking request</button>
                <a href="<?= $type === 'hotel' ? '../hotels.php' : '../packages.php' ?>">Cancel</a></div>
            </form><?php endif; ?></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
