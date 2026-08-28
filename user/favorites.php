<?php
$userPageTitle = 'Saved favorites | WanderTrail';
require __DIR__ . '/header.php';
$favorites = [];
$queries = [
        'destination' => ['SELECT f.favorite_id,sp.subplace_id item_id,sp.subplace_name title,sp.tag_line summary,sp.upload_pic1 image FROM tbl_user_favorite f INNER JOIN tbl_subplace sp ON sp.subplace_id=f.item_id WHERE f.user_id=? AND f.item_type="destination" ORDER BY f.created_at DESC', '../admin/subplace/', '../destination.php?subplace_id='],
        'hotel' => ['SELECT f.favorite_id,h.hotel_id item_id,h.hotel_name title,p.place_name summary,h.hotel_image image FROM tbl_user_favorite f INNER JOIN tbl_hotel h ON h.hotel_id=f.item_id INNER JOIN tbl_place p ON p.place_id=h.place_id WHERE f.user_id=? AND f.item_type="hotel" ORDER BY f.created_at DESC', '../admin/hotel/', '../hotel.php?hotel_id='],
        'package' => ['SELECT f.favorite_id,pk.package_id item_id,pk.package_name title,pk.package_duration summary,pk.package_img image FROM tbl_user_favorite f INNER JOIN tbl_package pk ON pk.package_id=f.item_id WHERE f.user_id=? AND f.item_type="package" ORDER BY f.created_at DESC', '../admin/package/', '../package.php?package_id='],
        'guide' => ['SELECT f.favorite_id,g.guide_id item_id,g.guide_name title,g.language_known summary,g.guide_image image FROM tbl_user_favorite f INNER JOIN tbl_tourguide g ON g.guide_id=f.item_id WHERE f.user_id=? AND f.item_type="guide" ORDER BY f.created_at DESC', '../admin/tourguide/', '../guide.php?guide_id='],
];
foreach ($queries as $type => [$sql, $imageBase, $urlBase]) {
    foreach (db_all($con, $sql, [$user_id]) as $row) {
        $row['type'] = $type;
        $row['image_url'] = $imageBase . rawurlencode((string)$row['image']);
        $row['url'] = $urlBase . (int)$row['item_id'];
        $favorites[] = $row;
    }
}
?>
<section class="eg-account-page">
    <div class="eg-booking-shell">
        <div class="eg-account-form-heading"><p>Your shortlist</p>
            <h1>Saved favorites</h1><span>Keep destinations, stays, packages and guides together while you plan.</span>
        </div><?= flash_render() ?>
        <?php if ($favorites): ?>
            <div class="eg-favorite-grid"><?php foreach ($favorites as $favorite): ?>
                <article><a href="<?= e($favorite['url']) ?>"><img src="<?= e($favorite['image_url']) ?>"
                                                                   alt="<?= e($favorite['title']) ?>"></a>
                <div><small><?= e($favorite['type']) ?></small>
                    <h2><a href="<?= e($favorite['url']) ?>"><?= e($favorite['title']) ?></a></h2>
                    <p><?= e(mb_strimwidth(strip_tags((string)$favorite['summary']), 0, 100, '...')) ?></p>
                    <form method="post" action="favorite-toggle.php"><?= csrf_field() ?><input type="hidden"
                                                                                               name="item_type"
                                                                                               value="<?= e($favorite['type']) ?>"><input
                                type="hidden" name="item_id" value="<?= (int)$favorite['item_id'] ?>"><input
                                type="hidden" name="return_to" value="favorites.php">
                        <button type="submit">Remove</button>
                    </form>
                </div></article><?php endforeach; ?></div>
        <?php else: ?>
            <div class="eg-empty-state"><h2>Nothing saved yet</h2>
                <p>Use the save button while browsing to build your shortlist.</p><a href="../destinations.php">Explore
                    destinations</a></div><?php endif; ?></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
