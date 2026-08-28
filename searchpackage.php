<?php
require_once __DIR__ . '/config.php';
$query = trim((string)($_GET['search'] ?? $_GET['user_query'] ?? ''));
$egPageTitle = ($query !== '' ? 'Package search: ' . $query : 'Search packages') . ' | WanderTrail';
$parameters = [];
$where = 'pk.isdeleted=0';
if ($query !== '') {
    $where .= ' AND (pk.package_name LIKE ? OR pk.package_type LIKE ? OR pk.package_des LIKE ? OR p.place_name LIKE ?)';
    $like = '%' . $query . '%';
    $parameters = [$like, $like, $like, $like];
}
$results = db_all($con, 'SELECT pk.*,p.place_name FROM tbl_package pk LEFT JOIN tbl_place p ON p.place_id=pk.place_id WHERE ' . $where . ' ORDER BY pk.package_id DESC LIMIT 24', $parameters);
require __DIR__ . '/header.php';
?>
<section class="eg-search-hero">
    <div class="eg-section-inner"><p class="eg-kicker">Find a journey</p>
        <h1><?= $query !== '' ? 'Packages matching “' . e($query) . '”' : 'Search travel packages' ?></h1>
        <form method="get"><i class="fa fa-search"></i><input name="search" value="<?= e($query) ?>"
                                                              placeholder="Wildlife, family, beach or destination">
            <button type="submit">Search</button>
        </form>
    </div>
</section>
<section class="eg-listing-section">
    <div class="eg-section-inner">
        <div class="eg-section-heading">
            <div><p class="eg-kicker eg-kicker--dark">Package results</p>
                <h2><?= count($results) ?> journey<?= count($results) === 1 ? '' : 's' ?> found</h2></div>
            <a class="eg-text-link" href="packages.php">Browse all packages</a></div><?php if ($results): ?>
            <div class="eg-card-grid"><?php foreach ($results as $package): ?>
                <article class="eg-trip-card"><a class="eg-trip-card__image"
                                                 href="package.php?package_id=<?= (int)$package['package_id'] ?>"><img
                            src="admin/package/<?= rawurlencode((string)$package['package_img']) ?>"
                            alt="<?= e($package['package_name']) ?>"></a>
                <div class="eg-trip-card__body"><span class="eg-trip-card__meta"><?= e($package['package_duration']) ?> · <?= e($package['package_type']) ?></span>
                    <h3>
                        <a href="package.php?package_id=<?= (int)$package['package_id'] ?>"><?= e($package['package_name']) ?></a>
                    </h3>
                    <p><?= e(mb_strimwidth(strip_tags((string)$package['package_des']), 0, 145, '...')) ?></p><a
                            class="eg-text-link" href="package.php?package_id=<?= (int)$package['package_id'] ?>">View
                        package <i class="fa fa-arrow-right"></i></a></div></article><?php endforeach; ?>
            </div><?php else: ?>
            <div class="eg-empty-state"><h2>No packages found</h2>
                <p>Try a travel style such as family, wildlife, honeymoon, or beach.</p></div><?php endif; ?></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
