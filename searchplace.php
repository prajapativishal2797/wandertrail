<?php
require_once __DIR__ . '/config.php';
$query = trim((string)($_GET['search'] ?? $_GET['user_query'] ?? ''));
$egPageTitle = ($query !== '' ? 'Search: ' . $query : 'Search destinations') . ' | WanderTrail';
$parameters = [];
$where = 'sp.isdeleted=0';
if ($query !== '') {
    $where .= ' AND (sp.subplace_name LIKE ? OR sp.city LIKE ? OR p.place_name LIKE ? OR sp.tag_line LIKE ?)';
    $like = '%' . $query . '%';
    $parameters = [$like, $like, $like, $like];
}
$results = db_all($con, 'SELECT sp.*,p.place_name FROM tbl_subplace sp INNER JOIN tbl_place p ON p.place_id=sp.place_id WHERE ' . $where . ' ORDER BY sp.subplace_name LIMIT 24', $parameters);
require __DIR__ . '/header.php';
?>
<section class="eg-search-hero">
    <div class="eg-section-inner"><p class="eg-kicker">Find your next stop</p>
        <h1><?= $query !== '' ? 'Results for “' . e($query) . '”' : 'Search worldwide destinations' ?></h1>
        <form method="get"><i class="fa fa-search"></i><input name="search" value="<?= e($query) ?>"
                                                              placeholder="City, region or experience" autofocus>
            <button type="submit">Search</button>
        </form>
    </div>
</section>
<section class="eg-listing-section">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div><p class="eg-kicker eg-kicker--dark">Destination results</p>
                <h2><?= $query === '' ? 'Explore all places' : (count($results) . ' place' . (count($results) === 1 ? '' : 's') . ' found') ?></h2>
            </div>
            <a class="eg-text-link" href="destinations.php">Browse all destinations</a></div>
        <?php if ($results): ?>
            <div class="eg-listing-grid"><?php foreach ($results as $destination): ?>
                <article class="eg-destination-card"><a class="eg-destination-card__image"
                                                        href="destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>"><img
                            src="admin/subplace/<?= rawurlencode((string)$destination['upload_pic1']) ?>"
                            alt="<?= e($destination['subplace_name']) ?>"></a>
                <div class="eg-destination-card__body"><span class="eg-trip-card__meta"><i
                                class="fa fa-map-marker"></i> <?= e($destination['city']) ?>, <?= e($destination['place_name']) ?></span>
                    <h2>
                        <a href="destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>"><?= e($destination['subplace_name']) ?></a>
                    </h2>
                    <p><?= e(mb_strimwidth(strip_tags((string)$destination['tag_line']), 0, 120, '...')) ?></p>
                    <div class="eg-destination-card__foot">
                        <span><small>Best time</small><?= e($destination['besttime_visit'] ?: 'All year') ?></span><a
                                class="eg-text-link"
                                href="destination.php?subplace_id=<?= (int)$destination['subplace_id'] ?>">Explore <i
                                    class="fa fa-arrow-right"></i></a></div>
                </div></article><?php endforeach; ?></div>
        <?php else: ?>
            <div class="eg-empty-state"><h2>No matching destinations</h2>
                <p>Try a broader city, region, or experience such as heritage, coast, or wildlife.</p><a
                        href="destinations.php">Browse destinations</a></div><?php endif; ?></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
