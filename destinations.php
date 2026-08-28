<?php

require_once __DIR__ . '/config.php';

$egPageTitle = 'Destinations, hidden gems & picnic places | WanderTrail';
$pageSize = 8;
$start = max(0, request_int('start'));
$totalRows = (int)db_value($con, 'SELECT COUNT(*) FROM tbl_subplace WHERE isdeleted = 0');
$lastStart = max(0, (int)(floor(max(0, $totalRows - 1) / $pageSize) * $pageSize));
$start = min($start, $lastStart);
$destinations = db_all(
        $con,
        'SELECT sp.*, p.place_name FROM tbl_subplace sp INNER JOIN tbl_place p ON p.place_id = sp.place_id '
        . 'WHERE sp.isdeleted = 0 ORDER BY sp.subplace_id DESC LIMIT :limit OFFSET :offset',
        ['limit' => $pageSize, 'offset' => $start]
);
$pageCount = max(1, (int)ceil($totalRows / $pageSize));
$activePage = (int)floor($start / $pageSize) + 1;

require __DIR__ . '/header.php';
?>
<section class="eg-page-hero">
    <div class="eg-section-inner">
        <p class="eg-kicker">Famous sights and local finds</p>
        <h1>Discover places beyond the usual trail.</h1>
        <p><?= cms_text('destinations', 'intro', 'content', 'From famous heritage sites to hidden gems, picnic spots, mountain trails and quiet coastlines, find your next escape anywhere in the world.') ?></p>
    </div>
</section>

<section class="eg-listing-section">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div>
                <p class="eg-kicker eg-kicker--dark">Tourist places, hidden gems &amp; picnic spots</p>
                <h2><?= cms_text('destinations', 'intro', 'title', 'Popular destinations') ?></h2>
            </div>
            <span class="eg-result-count"><?= number_format($totalRows) ?> destinations</span>
        </div>

        <?php if ($destinations): ?>
            <div class="eg-listing-grid">
                <?php foreach ($destinations as $destination): ?>
                    <article class="eg-destination-card">
                        <a class="eg-destination-card__image"
                           href="destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>">
                            <img src="admin/subplace/<?= rawurlencode((string)$destination['upload_pic1']) ?>"
                                 alt="<?= e($destination['subplace_name']) ?>" loading="lazy">
                        </a>
                        <div class="eg-destination-card__body">
                            <span class="eg-trip-card__meta"><i
                                        class="fa fa-map-marker"></i> <?= e($destination['city']) ?>, <?= e($destination['place_name']) ?></span>
                            <h2>
                                <a href="destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>"><?= e($destination['subplace_name']) ?></a>
                            </h2>
                            <p><?= e(mb_strimwidth(strip_tags((string)$destination['tag_line']), 0, 120, '...')) ?></p>
                            <div class="eg-destination-card__foot">
                                <span><small>Best time</small><?= e($destination['besttime_visit'] ?: 'All year') ?></span>
                                <div><?= favorite_button($con, 'destination', (int)$destination['subplace_id'], 'destinations.php?start=' . $start) ?>
                                    <a class="eg-text-link"
                                       href="destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>">Explore
                                        <i class="fa fa-arrow-right"></i></a></div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="eg-empty-state"><h2>No destinations found</h2>
                <p>Please check back soon for new places to explore.</p></div>
        <?php endif; ?>

        <?php if ($pageCount > 1): ?>
            <nav class="eg-pagination" aria-label="Destination pages">
                <a href="destinations.php?start=0"<?= $activePage === 1 ? ' class="is-disabled" aria-disabled="true"' : '' ?>>First</a>
                <?php for ($page = 1; $page <= $pageCount; $page++): $offset = ($page - 1) * $pageSize; ?>
                    <a href="destinations.php?start=<?= $offset ?>"<?= $page === $activePage ? ' class="is-active" aria-current="page"' : '' ?>><?= $page ?></a>
                <?php endfor; ?>
                <a href="destinations.php?start=<?= $lastStart ?>"<?= $activePage === $pageCount ? ' class="is-disabled" aria-disabled="true"' : '' ?>>Last</a>
            </nav>
        <?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
