<section class="eg-home-section">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div><p class="eg-kicker eg-kicker--dark">Places to remember</p>
                <h2>Explore popular destinations</h2></div>
            <a class="eg-text-link" href="destinations.php">View all destinations <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="eg-place-grid"><?php foreach ($destinations as $index => $destination): ?><a
                class="eg-place-card <?= $index === 0 ? 'eg-place-card--featured' : '' ?>"
                href="destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>"><img
                        src="admin/subplace/<?= rawurlencode($destination['upload_pic1']) ?>"
                        alt="<?= e($destination['subplace_name']) ?>" loading="lazy"><span
                        class="eg-place-card__shade"></span><span
                        class="eg-place-card__content"><small><?= e($destination['place_name']) ?></small><strong><?= e($destination['subplace_name']) ?></strong><em><?= e($destination['besttime_visit'] ?: 'Discover more') ?></em></span>
                </a><?php endforeach; ?></div>
    </div>
</section>
