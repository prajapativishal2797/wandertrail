<?php
require_once __DIR__ . '/config.php';
$packageId = request_int('package_id');
$package = db_one($con, 'SELECT pk.*,p.place_name,h.hotel_name FROM tbl_package pk LEFT JOIN tbl_place p ON p.place_id=pk.place_id LEFT JOIN tbl_hotel h ON h.hotel_id=pk.hotel_id WHERE pk.package_id=? AND pk.isdeleted=0 LIMIT 1', [$packageId]);
if (!$package) {
    http_response_code(404);
    $egPageTitle = 'Package not found | WanderTrail';
    require __DIR__ . '/header.php';
    echo '<section class="eg-listing-section"><div class="eg-section-inner"><div class="eg-empty-state"><h2>Package not found</h2><p>This journey is no longer available.</p><a href="packages.php">Browse packages</a></div></div></section>';
    require __DIR__ . '/footer.php';
    return;
}
$egPageTitle = $package['package_name'] . ' | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-detail-hero">
    <div class="eg-section-inner"><a href="packages.php"><i class="fa fa-arrow-left"></i> All packages</a>
        <div><p class="eg-kicker"><?= e($package['package_type']) ?> journey</p>
            <h1><?= e($package['package_name']) ?></h1><span><i
                        class="fa fa-clock-o"></i> <?= e($package['package_duration']) ?><?= $package['place_name'] ? ' · ' . e($package['place_name']) : '' ?></span>
        </div>
    </div>
</section>
<section class="eg-detail-section">
    <div class="eg-section-inner eg-detail-layout">
        <div><img class="eg-detail-image" src="admin/package/<?= rawurlencode((string)$package['package_img']) ?>"
                  alt="<?= e($package['package_name']) ?>">
            <div class="eg-detail-copy"><p class="eg-kicker eg-kicker--dark">Journey overview</p>
                <h2>What to expect</h2>
                <p><?= e($package['package_des']) ?></p>
                <dl>
                    <div>
                        <dt>Duration</dt>
                        <dd><?= e($package['package_duration']) ?></dd>
                    </div>
                    <div>
                        <dt>Package style</dt>
                        <dd><?= e(ucfirst((string)$package['package_type'])) ?></dd>
                    </div>
                    <div>
                        <dt>Included stay</dt>
                        <dd><?= e($package['hotel_name'] ?: 'Selected during booking') ?></dd>
                    </div>
                </dl>
            </div>
        </div>
        <aside class="eg-booking-panel"><small>Starting
                from</small><strong>₹<?= number_format((float)$package['package_startprice']) ?></strong><span>per package</span><a
                    href="<?= e(auth_cta_url('user/booking.php?type=package&id=' . $packageId)) ?>">Book this
                package</a><a class="eg-enquire-link"
                              href="<?= e(auth_cta_url('user/booking.php?type=package&mode=custom&id=' . $packageId)) ?>">Customize
                this trip</a><a class="eg-enquire-link" href="enquiry.php?type=package&id=<?= $packageId ?>">Ask the
                travel
                agency</a><?= favorite_button($con, 'package', $packageId, 'package.php?package_id=' . $packageId) ?><p>
                Final pricing depends on dates, rooms and traveller count.</p></aside>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
