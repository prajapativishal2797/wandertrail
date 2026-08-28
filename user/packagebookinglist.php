<?php
$userPageTitle = 'Package bookings | WanderTrail';
require __DIR__ . '/header.php';
$bookings = db_all($con, 'SELECT b.*,pk.package_name,pk.package_img,h.hotel_name FROM tbl_packagebooking b INNER JOIN tbl_package pk ON pk.package_id=b.package_id LEFT JOIN tbl_hotel h ON h.hotel_id=b.hotel_id WHERE b.user_id=? ORDER BY b.packagebooking_id DESC', [$user_id]);
?>
<section class="eg-account-page">
    <div class="eg-booking-shell">
        <div class="eg-account-form-heading"><p>Your journeys</p>
            <h1>Package bookings</h1><span>Review itineraries, approval and payment status.</span></div>
        <?php if ($bookings): ?>
            <div class="eg-booking-list"><?php foreach ($bookings as $booking): ?>
                <article><img src="../admin/package/<?= rawurlencode((string)$booking['package_img']) ?>" alt="">
                <div class="eg-booking-info"><small><?= e($booking['package_category']) ?>
                        · <?= e($booking['isapproved']) ?></small>
                    <h2><?= e($booking['package_name']) ?></h2>
                    <p><?= e($booking['start_date']) ?>
                        to <?= e($booking['end_date']) ?><?= $booking['hotel_name'] ? ' · ' . e($booking['hotel_name']) : '' ?></p>
                </div>
                <div class="eg-booking-price"><strong>₹<?= number_format((float)$booking['amount']) ?></strong><span
                            class="eg-status <?= $booking['status'] === 'paid' ? 'is-paid' : '' ?>"><?= e($booking['status']) ?></span><?php if ($booking['status'] !== 'paid'): ?>
                        <a href="packagebooking.php?packagebooking_id=<?= (int)$booking['packagebooking_id'] ?>">Review
                            &amp; pay</a><?php endif; ?></div></article><?php endforeach; ?></div><?php else: ?>
            <div class="eg-empty-state"><h2>No package bookings yet</h2>
                <p>Choose a thoughtfully planned journey.</p><a href="../packages.php">Browse packages</a>
            </div><?php endif; ?>
    </div>
</section><?php require __DIR__ . '/footer.php'; ?>
