<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');

$email = current_user_email();
$profile = db_one($con, 'SELECT user_id FROM tbl_register WHERE email_id = ? AND isdeleted = 0 LIMIT 1', [$email]);
if (!$profile) log_out_session('../login.php');
$userId = (int)$profile['user_id'];
$type = strtolower(request_string('type', 'destination'));
$legacyIds = ['destination' => (int)($_GET['subplace_id'] ?? 0), 'hotel' => (int)($_GET['hotel_id'] ?? 0), 'package' => (int)($_GET['package_id'] ?? 0), 'guide' => (int)($_GET['guide_id'] ?? 0)];
$itemId = request_int('item_id', $legacyIds[$type] ?? 0);
$catalog = [
        'destination' => ['table' => 'tbl_subplace', 'id' => 'subplace_id', 'name' => 'subplace_name', 'back' => '../destination.php?subplace_id='],
        'hotel' => ['table' => 'tbl_hotel', 'id' => 'hotel_id', 'name' => 'hotel_name', 'back' => '../hotel.php?hotel_id='],
        'package' => ['table' => 'tbl_package', 'id' => 'package_id', 'name' => 'package_name', 'back' => '../package.php?package_id='],
        'guide' => ['table' => 'tbl_tourguide', 'id' => 'guide_id', 'name' => 'guide_name', 'back' => '../guide.php?guide_id='],
];
if (!isset($catalog[$type]) || $itemId < 1) {
    http_response_code(404);
    exit('The item you want to review was not found.');
}
$meta = $catalog[$type];
$item = db_one($con, "SELECT {$meta['id']} AS item_id, {$meta['name']} AS item_name FROM {$meta['table']} WHERE {$meta['id']} = ? AND isdeleted = 0 LIMIT 1", [$itemId]);
if (!$item) {
    http_response_code(404);
    exit('The item you want to review was not found.');
}
$existing = db_one($con, 'SELECT score, review_title, review_text FROM tbl_travel_review WHERE user_id=? AND item_type=? AND item_id=? LIMIT 1', [$userId, $type, $itemId]);
$errors = [];
if (is_post()) {
    csrf_require();
    $score = request_int('score');
    $title = request_string('review_title');
    $text = request_string('review_text');
    if ($score < 1 || $score > 5) $errors[] = 'Choose a rating from 1 to 5.';
    if (mb_strlen($title) > 120) $errors[] = 'Review title must be 120 characters or fewer.';
    if (mb_strlen($text) > 1000) $errors[] = 'Review must be 1,000 characters or fewer.';
    if (!$errors) {
        db_execute($con, "INSERT INTO tbl_travel_review (user_id,item_type,item_id,score,review_title,review_text) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE score=VALUES(score),review_title=VALUES(review_title),review_text=VALUES(review_text),status='published'", [$userId, $type, $itemId, $score, $title ?: null, $text ?: null]);
        flash_success('Your review has been saved. Thank you for sharing your experience.');
        redirect('rating.php?type=' . rawurlencode($type) . '&item_id=' . $itemId);
    }
}
$summary = db_one($con, "SELECT COUNT(*) total,ROUND(AVG(score),1) average_score FROM tbl_travel_review WHERE item_type=? AND item_id=? AND status='published'", [$type, $itemId]);
$userPageTitle = 'Review ' . $item['item_name'] . ' | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell is-narrow">
        <div class="eg-account-form-heading"><p><?= e(ucfirst($type)) ?> review</p>
            <h1><?= e($item['item_name']) ?></h1>
            <span><?= (int)$summary['total'] ? e($summary['average_score']) . '/5 from ' . e($summary['total']) . ' traveller review(s)' : 'Be the first traveller to review this experience.' ?></span>
        </div>
        <?= flash_render() ?><?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
        <form method="post" class="eg-account-form"><?= csrf_field() ?>
            <div class="eg-form-grid single">
                <label>Your rating<select name="score" required>
                        <option value="">Choose a score
                        </option><?php $selected = (int)($_POST['score'] ?? $existing['score'] ?? 0);
                        foreach ([5 => 'Excellent', 4 => 'Very good', 3 => 'Good', 2 => 'Fair', 1 => 'Poor'] as $value => $label): ?>
                            <option value="<?= $value ?>"<?= $selected === $value ? ' selected' : '' ?>><?= $value ?>
                            — <?= e($label) ?></option><?php endforeach; ?></select></label>
                <label>Review title<input type="text" name="review_title" maxlength="120"
                                          value="<?= e($_POST['review_title'] ?? $existing['review_title'] ?? '') ?>"
                                          placeholder="A short summary"></label>
                <label>Your experience<textarea name="review_text" rows="6" maxlength="1000"
                                                placeholder="What should other travellers know?"><?= e($_POST['review_text'] ?? $existing['review_text'] ?? '') ?></textarea></label>
            </div>
            <div class="eg-form-actions">
                <button type="submit"><?= $existing ? 'Update review' : 'Publish review' ?></button>
                <a href="<?= e($meta['back'] . $itemId) ?>">Back to <?= e($type) ?></a></div>
        </form>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
