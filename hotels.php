<?php
require_once __DIR__ . '/config.php';
$egPageTitle = 'Hotels | WanderTrail';
$pageSize = 6;
$start = max(0, request_int('start'));
$totalRows = (int)db_value($con, 'SELECT COUNT(*) FROM tbl_hotel WHERE isdeleted = 0');
$lastStart = max(0, (int)(floor(max(0, $totalRows - 1) / $pageSize) * $pageSize));
$start = min($start, $lastStart);
$hotels = db_all($con, 'SELECT h.*, p.place_name FROM tbl_hotel h INNER JOIN tbl_place p ON p.place_id=h.place_id WHERE h.isdeleted=0 ORDER BY h.hotel_id DESC LIMIT :limit OFFSET :offset', ['limit' => $pageSize, 'offset' => $start]);
$pageCount = max(1, (int)ceil($totalRows / $pageSize));
$activePage = (int)floor($start / $pageSize) + 1;
require __DIR__ . '/header.php';
?>
<section class="eg-page-hero">
    <div class="eg-section-inner"><p class="eg-kicker">Stay comfortably</p>
        <h1>A welcoming base for every journey.</h1>
        <p><?= cms_text('hotels', 'intro', 'content', 'Discover trusted stays near memorable places around the world.') ?></p>
    </div>
</section>
<section class="eg-listing-section">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div><p class="eg-kicker eg-kicker--dark">Rest well</p>
                <h2><?= cms_text('hotels', 'intro', 'title', 'Recommended hotels') ?></h2></div>
            <span class="eg-result-count"><?= number_format($totalRows) ?> hotels</span></div>
        <?php if ($hotels): ?>
            <div class="eg-card-grid"><?php foreach ($hotels as $hotel): ?>
                <article class="eg-stay-card"><a class="eg-stay-card__image"
                                                 href="hotel.php?hotel_id=<?= (int)$hotel['hotel_id'] ?>"><img
                                src="admin/hotel/<?= rawurlencode((string)$hotel['hotel_image']) ?>"
                                alt="<?= e($hotel['hotel_name']) ?>" loading="lazy"></a>
                    <div class="eg-stay-card__body"><span class="eg-trip-card__meta"><i
                                    class="fa fa-map-marker"></i> <?= e($hotel['place_name']) ?></span>
                        <h3>
                            <a href="hotel.php?hotel_id=<?= (int)$hotel['hotel_id'] ?>"><?= e($hotel['hotel_name']) ?></a>
                        </h3>
                        <?= favorite_button($con, 'hotel', (int)$hotel['hotel_id'], 'hotels.php?start=' . $start) ?>
                        <div class="eg-stay-card__foot">
                            <span><small>Starting from</small><strong>₹<?= number_format((float)$hotel['hotel_price']) ?></strong></span><a
                                    href="<?= e(auth_cta_url('user/booking.php?type=hotel&id=' . (int)$hotel['hotel_id'])) ?>">Book
                                stay</a></div>
                    </div>
                </article>
            <?php endforeach; ?></div><?php else: ?>
            <div class="eg-empty-state"><h2>No hotels found</h2>
                <p>Please check back soon for new stays.</p></div><?php endif; ?>
        <?php if ($pageCount > 1): ?>
            <nav class="eg-pagination" aria-label="Hotel pages"><a
                    href="hotels.php?start=0"<?= $activePage === 1 ? ' class="is-disabled"' : '' ?>>First</a><?php for ($page = 1; $page <= $pageCount; $page++): ?>
                <a href="hotels.php?start=<?= ($page - 1) * $pageSize ?>"<?= $page === $activePage ? ' class="is-active" aria-current="page"' : '' ?>><?= $page ?></a><?php endfor; ?>
            <a href="hotels.php?start=<?= $lastStart ?>"<?= $activePage === $pageCount ? ' class="is-disabled"' : '' ?>>Last</a>
            </nav><?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
