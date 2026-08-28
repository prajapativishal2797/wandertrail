<?php
$userPageTitle = 'Discover more | My account';
require __DIR__ . '/header.php';

$destinations = db_all($con, 'SELECT sp.*, p.place_name FROM tbl_subplace sp INNER JOIN tbl_place p ON p.place_id=sp.place_id WHERE sp.isdeleted=0 ORDER BY sp.subplace_id DESC LIMIT 6');
$packages = db_all($con, 'SELECT pk.*, p.place_name FROM tbl_package pk INNER JOIN tbl_place p ON p.place_id=pk.place_id WHERE pk.isdeleted=0 ORDER BY pk.package_id DESC LIMIT 3');
$hotels = db_all($con, 'SELECT h.*, p.place_name FROM tbl_hotel h INNER JOIN tbl_place p ON p.place_id=h.place_id WHERE h.isdeleted=0 ORDER BY h.hotel_id DESC LIMIT 3');
$hotelBookings = (int)db_value($con, 'SELECT COUNT(*) FROM tbl_hotelbooking WHERE user_id=?', [$user_id]);
$packageBookings = (int)db_value($con, 'SELECT COUNT(*) FROM tbl_packagebooking WHERE user_id=?', [$user_id]);
$savedItems = (int)db_value($con, 'SELECT COUNT(*) FROM tbl_user_favorite WHERE user_id=?', [$user_id]);
?>
<section class="eg-account-hero">
    <div><p>Welcome back, <?= e($profile['first_name']) ?></p>
        <h1>Where will the world take you next?</h1>
        <form action="../searchplace.php" method="get"><i class="fa fa-search"></i><input name="search"
                                                                                          placeholder="Search destinations">
            <button type="submit">Explore</button>
        </form>
    </div>
</section>
<section class="eg-account-overview">
    <div class="eg-account-inner"><a href="hotelbookinglist.php"><strong><?= $hotelBookings ?></strong><span>Hotel bookings</span></a><a
                href="packagebookinglist.php"><strong><?= $packageBookings ?></strong><span>Package bookings</span></a><a
                href="favorites.php"><strong><?= $savedItems ?></strong><span>Saved favorites</span></a><a
                href="editprofile.php"><strong><i class="fa fa-user"></i></strong><span>Manage profile</span></a></div>
</section>
<section class="eg-account-section">
    <div class="eg-account-inner">
        <div class="eg-account-heading">
            <div><p>Places to remember</p>
                <h2>Popular destinations</h2></div>
            <a href="../destinations.php">View all</a></div>
        <div class="eg-account-destination-grid"><?php foreach ($destinations as $destination): ?><a
                href="../destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>"><img
                        src="../admin/subplace/<?= rawurlencode((string)$destination['upload_pic1']) ?>"
                        alt="<?= e($destination['subplace_name']) ?>"><span><small><?= e($destination['place_name']) ?></small><strong><?= e($destination['subplace_name']) ?></strong></span>
                </a><?php endforeach; ?></div>
    </div>
</section>
<section class="eg-account-section is-soft">
    <div class="eg-account-inner">
        <div class="eg-account-heading">
            <div><p>Curated journeys</p>
                <h2>Packages ready to book</h2></div>
            <a href="../packages.php">View all</a></div>
        <div class="eg-account-card-grid"><?php foreach ($packages as $package): ?>
                <article><a class="image" href="../package.php?package_id=<?= (int)$package['package_id'] ?>"><img
                            src="../admin/package/<?= rawurlencode((string)$package['package_img']) ?>"
                            alt="<?= e($package['package_name']) ?>"></a>
                <div><small><?= e($package['package_duration']) ?> · <?= e($package['place_name']) ?></small>
                    <h3><?= e($package['package_name']) ?></h3><a
                            href="booking.php?type=package&id=<?= (int)$package['package_id'] ?>">Book package</a></div>
                </article><?php endforeach; ?></div>
    </div>
</section>
<section class="eg-account-section">
    <div class="eg-account-inner">
        <div class="eg-account-heading">
            <div><p>Rest well</p>
                <h2>Recommended hotels</h2></div>
            <a href="../hotels.php">View all</a></div>
        <div class="eg-account-card-grid"><?php foreach ($hotels as $hotel): ?>
                <article><a class="image" href="../hotel.php?hotel_id=<?= (int)$hotel['hotel_id'] ?>"><img
                            src="../admin/hotel/<?= rawurlencode((string)$hotel['hotel_image']) ?>"
                            alt="<?= e($hotel['hotel_name']) ?>"></a>
                <div><small><?= e($hotel['place_name']) ?></small>
                    <h3><?= e($hotel['hotel_name']) ?></h3><a
                            href="booking.php?type=hotel&id=<?= (int)$hotel['hotel_id'] ?>">Book from
                        ₹<?= number_format((float)$hotel['hotel_price']) ?></a></div></article><?php endforeach; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
