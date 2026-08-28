<?php
require_once __DIR__ . '/config.php';
$egPageTitle = 'Travel packages | WanderTrail';
$pageSize = 6;
$start = max(0, request_int('start'));
$totalRows = (int)db_value($con, 'SELECT COUNT(*) FROM tbl_package WHERE isdeleted = 0');
$lastStart = max(0, (int)(floor(max(0, $totalRows - 1) / $pageSize) * $pageSize));
$start = min($start, $lastStart);
$packages = db_all($con, 'SELECT pk.*, p.place_name FROM tbl_package pk INNER JOIN tbl_place p ON p.place_id=pk.place_id WHERE pk.isdeleted=0 ORDER BY pk.package_id DESC LIMIT :limit OFFSET :offset', ['limit' => $pageSize, 'offset' => $start]);
$pageCount = max(1, (int)ceil($totalRows / $pageSize));
$activePage = (int)floor($start / $pageSize) + 1;
require __DIR__ . '/header.php';
?>
<section class="eg-page-hero">
    <div class="eg-section-inner"><p class="eg-kicker">Curated journeys</p>
        <h1>Travel plans with room to wander.</h1>
        <p><?= cms_text('packages', 'intro', 'content', 'Thoughtfully planned journeys for culture, nature, food and unforgettable roads.') ?></p>
    </div>
</section>
<section class="eg-listing-section">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div><p class="eg-kicker eg-kicker--dark">Choose your journey</p>
                <h2><?= cms_text('packages', 'intro', 'title', 'Featured packages') ?></h2></div>
            <span class="eg-result-count"><?= number_format($totalRows) ?> packages</span></div>
        <?php if ($packages): ?>
            <div class="eg-card-grid"><?php foreach ($packages as $package): ?>
                <article class="eg-trip-card"><a class="eg-trip-card__image"
                                                 href="package.php?package_id=<?= (int)$package['package_id'] ?>"><img
                                src="admin/package/<?= rawurlencode((string)$package['package_img']) ?>"
                                alt="<?= e($package['package_name']) ?>" loading="lazy"></a>
                    <div class="eg-trip-card__body"><span class="eg-trip-card__meta"><i
                                    class="fa fa-clock-o"></i> <?= e($package['package_duration']) ?> · <?= e($package['place_name']) ?></span>
                        <h3>
                            <a href="package.php?package_id=<?= (int)$package['package_id'] ?>"><?= e($package['package_name']) ?></a>
                        </h3>
                        <p><?= e(mb_strimwidth(strip_tags((string)$package['package_des']), 0, 145, '...')) ?></p>
                        <div class="eg-card-actions"><a class="eg-text-link"
                                                        href="package.php?package_id=<?= (int)$package['package_id'] ?>">View
                                journey <i
                                        class="fa fa-arrow-right"></i></a><?= favorite_button($con, 'package', (int)$package['package_id'], 'packages.php?start=' . $start) ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?></div><?php else: ?>
            <div class="eg-empty-state"><h2>No packages found</h2>
                <p>Please check back soon for new journeys.</p></div><?php endif; ?>
        <?php if ($pageCount > 1): ?>
            <nav class="eg-pagination" aria-label="Package pages"><a
                    href="packages.php?start=0"<?= $activePage === 1 ? ' class="is-disabled"' : '' ?>>First</a><?php for ($page = 1; $page <= $pageCount; $page++): ?>
                <a href="packages.php?start=<?= ($page - 1) * $pageSize ?>"<?= $page === $activePage ? ' class="is-active" aria-current="page"' : '' ?>><?= $page ?></a><?php endfor; ?>
            <a href="packages.php?start=<?= $lastStart ?>"<?= $activePage === $pageCount ? ' class="is-disabled"' : '' ?>>Last</a>
            </nav><?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
