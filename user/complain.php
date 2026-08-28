<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$user = current_user_email();
$profile = db_one($con, 'SELECT user_id FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [$user]);
$errors = [];
if (is_post()) {
    csrf_require();
    $message = request_string('complain_msg');
    if (mb_strlen($message) < 10) $errors[] = 'Please describe the issue in at least 10 characters.'; elseif (mb_strlen($message) > 1500) $errors[] = 'The support request must be no longer than 1,500 characters.';
    else {
        db_execute($con, 'INSERT INTO tbl_complain (user_id,date,complain_msg,isapproved) VALUES (?,NOW(),?,"pending")', [(int)$profile['user_id'], $message]);
        flash_success('Your support request has been registered.');
        redirect('complain.php');
    }
}
$userPageTitle = 'Customer support | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell is-narrow">
        <div class="eg-account-form-heading"><p>Customer support</p>
            <h1>Report a booking issue</h1><span>Include the booking type, booking number and a clear description so the agency can help quickly.</span>
        </div><?= flash_render() ?><?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
        <form method="post" class="eg-account-form"><?= csrf_field() ?>
            <div class="eg-form-grid single"><label>Issue details<textarea name="complain_msg" rows="7" maxlength="1500"
                                                                           required><?= e($_POST['complain_msg'] ?? '') ?></textarea></label>
            </div>
            <div class="eg-form-actions">
                <button type="submit">Submit support request</button>
                <a href="index.php">Cancel</a></div>
        </form>
    </div>
</section><?php require __DIR__ . '/footer.php'; ?>
