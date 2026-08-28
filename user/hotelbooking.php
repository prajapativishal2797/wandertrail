<?php
$userPageTitle = 'Hotel booking | WanderTrail';
require __DIR__ . '/header.php';
$bookingId = request_int('hotelbooking_id');
$booking = db_one($con, 'SELECT b.*,h.hotel_name,h.hotel_image,p.place_name FROM tbl_hotelbooking b INNER JOIN tbl_hotel h ON h.hotel_id=b.hotel_id LEFT JOIN tbl_place p ON p.place_id=h.place_id WHERE b.hotelbooking_id=? AND b.user_id=? LIMIT 1', [$bookingId, $user_id]);
?>
<section class="eg-account-page">
    <div class="eg-booking-shell"><?php if (!$booking): ?>
            <div class="eg-empty-state"><h2>Booking not found</h2>
                <p>This hotel booking does not belong to your account.</p><a href="hotelbookinglist.php">Back to
                    bookings</a></div><?php else: ?>
            <div class="eg-account-form-heading"><p>Hotel reservation #<?= $bookingId ?></p>
            <h1><?= e($booking['hotel_name']) ?></h1>
            <span><?= e($booking['place_name']) ?> · booked <?= e($booking['hotelbooking_date']) ?></span></div>
            <div class="eg-booking-detail"><img
                    src="../admin/hotel/<?= rawurlencode((string)$booking['hotel_image']) ?>" alt="">
            <dl>
                <div>
                    <dt>Check-in</dt>
                    <dd><?= e($booking['depart_date']) ?></dd>
                </div>
                <div>
                    <dt>Check-out</dt>
                    <dd><?= e($booking['return_date']) ?></dd>
                </div>
                <div>
                    <dt>Travellers</dt>
                    <dd><?= (int)$booking['adults'] ?> adults, <?= (int)$booking['childs'] ?> children</dd>
                </div>
                <div>
                    <dt>Rooms</dt>
                    <dd><?= (int)$booking['no_rooms'] ?></dd>
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
                    <a href="payment-request.php?type=hotel&booking_id=<?= $bookingId ?>">Arrange
                        payment</a><?php endif; ?></aside></div><?php endif; ?></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
