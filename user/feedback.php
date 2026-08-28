<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$user = current_user_email();
$profile = db_one($con, 'SELECT user_id FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [$user]);
$errors = [];
if (is_post()) {
    csrf_require();
    $message = request_string('feedback_msg');
    if (mb_strlen($message) < 10) $errors[] = 'Please provide at least 10 characters of feedback.'; elseif (mb_strlen($message) > 1000) $errors[] = 'Feedback must be no longer than 1,000 characters.';
    else {
        db_execute($con, 'INSERT INTO tbl_feedback (user_id,date,feedback_msg) VALUES (?,NOW(),?)', [(int)$profile['user_id'], $message]);
        flash_success('Thank you for your feedback.');
        redirect('feedback.php');
    }
}
$userPageTitle = 'Feedback | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell is-narrow">
        <div class="eg-account-form-heading"><p>Help us improve</p>
            <h1>Share feedback</h1><span>Tell the travel agency what worked well or what could be better.</span>
        </div><?= flash_render() ?><?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
        <form method="post" class="eg-account-form"><?= csrf_field() ?>
            <div class="eg-form-grid single"><label>Your feedback<textarea name="feedback_msg" rows="6" maxlength="1000"
                                                                           required><?= e($_POST['feedback_msg'] ?? '') ?></textarea></label>
            </div>
            <div class="eg-form-actions">
                <button type="submit">Send feedback</button>
                <a href="index.php">Cancel</a></div>
        </form>
    </div>
</section><?php require __DIR__ . '/footer.php'; ?>
