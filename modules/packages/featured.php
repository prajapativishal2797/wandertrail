<section class="eg-home-section eg-home-section--soft">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div><p class="eg-kicker eg-kicker--dark">Curated journeys</p>
                <h2>Travel plans with room to wander</h2></div>
            <a class="eg-text-link" href="packages.php">Browse all packages <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="eg-card-grid"><?php foreach ($packages as $package): ?>
                <article class="eg-trip-card"><a class="eg-trip-card__image"
                                                 href="package.php?package_id=<?= (int)$package['package_id'] ?>"><img
                            src="admin/package/<?= rawurlencode($package['package_img']) ?>"
                            alt="<?= e($package['package_name']) ?>" loading="lazy"></a>
                <div class="eg-trip-card__body"><span class="eg-trip-card__meta"><i
                                class="fa fa-clock-o"></i> <?= e($package['package_duration']) ?></span>
                    <h3>
                        <a href="package.php?package_id=<?= (int)$package['package_id'] ?>"><?= e($package['package_name']) ?></a>
                    </h3>
                    <p><?= e(mb_strimwidth(strip_tags($package['package_des']), 0, 145, '...')) ?></p><a
                            class="eg-text-link"
                            href="package.php?package_id=<?= (int)$package['package_id'] ?>">View journey <i
                                class="fa fa-arrow-right"></i></a></div></article><?php endforeach; ?></div>
    </div>
</section>
