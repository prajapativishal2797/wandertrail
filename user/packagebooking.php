<?php
$userPageTitle = 'Package booking | WanderTrail';
require __DIR__ . '/header.php';
$bookingId = request_int('packagebooking_id');
$booking = db_one($con, 'SELECT b.*,pk.package_name,pk.package_img,h.hotel_name FROM tbl_packagebooking b INNER JOIN tbl_package pk ON pk.package_id=b.package_id LEFT JOIN tbl_hotel h ON h.hotel_id=b.hotel_id WHERE b.packagebooking_id=? AND b.user_id=? LIMIT 1', [$bookingId, $user_id]);
?>
<section class="eg-account-page">
    <div class="eg-booking-shell"><?php if (!$booking): ?>
            <div class="eg-empty-state"><h2>Booking not found</h2>
                <p>This package booking does not belong to your account.</p><a href="packagebookinglist.php">Back to
                    bookings</a></div><?php else: ?>
            <div class="eg-account-form-heading"><p>Package reservation #<?= $bookingId ?></p>
            <h1><?= e($booking['package_name']) ?></h1>
            <span><?= e($booking['package_category']) ?> · booked <?= e($booking['packagebooking_date']) ?></span></div>
            <div class="eg-booking-detail"><img
                    src="../admin/package/<?= rawurlencode((string)$booking['package_img']) ?>" alt="">
            <dl>
                <div>
                    <dt>Start date</dt>
                    <dd><?= e($booking['start_date']) ?></dd>
                </div>
                <div>
                    <dt>End date</dt>
                    <dd><?= e($booking['end_date']) ?></dd>
                </div>
                <div>
                    <dt>Travellers</dt>
                    <dd><?= (int)$booking['adults'] ?> adults, <?= (int)$booking['childs'] ?> children</dd>
                </div>
                <div>
                    <dt>Hotel</dt>
                    <dd><?= e($booking['hotel_name'] ?: 'To be confirmed') ?></dd>
                </div>
                <div>
                    <dt>Approval</dt>
                    <dd><?= e($booking['isapproved']) ?></dd>
                </div>
                <div>
                    <dt>Payment</dt>
                    <dd><?= e($booking['status']) ?></dd>
                </div>
            </dl>
            <aside><small>Total
                    amount</small><strong>₹<?= number_format((float)$booking['amount']) ?></strong><?php if ($booking['status'] !== 'paid'): ?>
                    <a href="payment-request.php?type=package&booking_id=<?= $bookingId ?>">Arrange
                        payment</a><?php endif; ?></aside></div><?php endif; ?></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
