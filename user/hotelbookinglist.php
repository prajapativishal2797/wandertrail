<?php
$userPageTitle = 'Hotel bookings | WanderTrail';
require __DIR__ . '/header.php';
$bookings = db_all($con, 'SELECT b.*,h.hotel_name,h.hotel_image FROM tbl_hotelbooking b INNER JOIN tbl_hotel h ON h.hotel_id=b.hotel_id WHERE b.user_id=? ORDER BY b.hotelbooking_id DESC', [$user_id]);
?>
<section class="eg-account-page">
    <div class="eg-booking-shell">
        <div class="eg-account-form-heading"><p>Your trips</p>
            <h1>Hotel bookings</h1><span>Review reservation dates, approval and payment status.</span></div>
        <?php if ($bookings): ?>
            <div class="eg-booking-list"><?php foreach ($bookings as $booking): ?>
                <article><img src="../admin/hotel/<?= rawurlencode((string)$booking['hotel_image']) ?>" alt="">
                <div class="eg-booking-info"><small><?= e($booking['isapproved']) ?></small>
                    <h2><?= e($booking['hotel_name']) ?></h2>
                    <p><?= e($booking['depart_date']) ?> to <?= e($booking['return_date']) ?>
                        · <?= (int)$booking['no_rooms'] ?> room(s)</p></div>
                <div class="eg-booking-price"><strong>₹<?= number_format((float)$booking['amount']) ?></strong><span
                            class="eg-status <?= $booking['status'] === 'paid' ? 'is-paid' : '' ?>"><?= e($booking['status']) ?></span><?php if ($booking['status'] !== 'paid'): ?>
                        <a href="hotelbooking.php?hotelbooking_id=<?= (int)$booking['hotelbooking_id'] ?>">Review &amp;
                            pay</a><?php endif; ?></div></article><?php endforeach; ?></div><?php else: ?>
            <div class="eg-empty-state"><h2>No hotel bookings yet</h2>
                <p>Find a stay for your next journey.</p><a href="../hotels.php">Browse hotels</a>
            </div><?php endif; ?>
    </div>
</section><?php require __DIR__ . '/footer.php'; ?>
