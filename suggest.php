<?php
require_once __DIR__ . '/config.php';
$errors = [];
if (is_post()) {
    csrf_require();
    $destinationId = request_int('subplace_id', 0, 'post');
    $friendEmail = request_string('friend_email');
    $message = request_string('message');
    $destination = db_one($con, 'SELECT subplace_id,subplace_name FROM tbl_subplace WHERE subplace_id=? AND isdeleted=0 LIMIT 1', [$destinationId]);
    if (!$destination) $errors[] = 'Choose a valid destination.';
    if (!valid_email($friendEmail)) $errors[] = 'Enter a valid email address.';
    if (mb_strlen($message) > 500) $errors[] = 'Your message must be 500 characters or fewer.';
    if (!$errors) {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/exploregujarat/suggest.php'), '/\\') . '/destination.php?subplace_id=' . $destinationId;
        $body = '<p>A friend recommends <strong>' . e($destination['subplace_name']) . '</strong> for your next trip.</p>' . ($message !== '' ? '<p>' . nl2br(e($message)) . '</p>' : '') . '<p><a href="' . e($url) . '">View destination</a></p>';
        $sent = send_mail($friendEmail, 'A destination for your travel list', $body);
        flash_set($sent ? 'success' : 'info', $sent ? 'The destination has been shared.' : 'Your details are valid, but email is not configured on this local server.');
        redirect('suggest.php');
    }
}
$destinations = db_all($con, 'SELECT subplace_id,subplace_name FROM tbl_subplace WHERE isdeleted=0 ORDER BY subplace_name');
$pageTitle = 'Share a destination | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-enquiry-hero">
    <div class="container"><span>Inspire a journey</span>
        <h1>Share a discovery with a friend</h1>
        <p>Send a destination recommendation directly to someone planning their next escape.</p></div>
</section>
<section class="eg-enquiry-section">
    <div class="container">
        <div class="eg-enquiry-card">
            <div class="eg-enquiry-copy"><p class="eyebrow">Travel recommendation</p>
                <h2>Choose a place worth sharing</h2>
                <p>We will send one useful destination link. We do not add the recipient to a mailing list.</p></div>
            <div><?= flash_render() ?><?php foreach ($errors as $error): ?>
                    <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
                <form method="post" class="eg-enquiry-form"><?= csrf_field() ?><label>Destination<select
                                name="subplace_id" required>
                            <option value="">Choose a destination</option><?php foreach ($destinations as $item): ?>
                                <option value="<?= (int)$item['subplace_id'] ?>"<?= request_int('subplace_id', 0, 'post') === (int)$item['subplace_id'] ? ' selected' : '' ?>><?= e($item['subplace_name']) ?></option><?php endforeach; ?>
                        </select></label><label>Friend's email<input type="email" name="friend_email" required
                                                                     value="<?= e($_POST['friend_email'] ?? '') ?>"></label><label>Your
                        message (optional)<textarea name="message" rows="4"
                                                    maxlength="500"><?= e($_POST['message'] ?? '') ?></textarea></label>
                    <button type="submit">Share destination</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
