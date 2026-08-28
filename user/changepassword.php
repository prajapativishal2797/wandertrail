<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$user = current_user_email();
$errors = [];
if (is_post()) {
    csrf_require();
    $currentPassword = (string)($_POST['current_password'] ?? '');
    $newPassword = (string)($_POST['new_password'] ?? '');
    $confirmation = (string)($_POST['password_confirmation'] ?? '');
    $login = db_one($con, 'SELECT login_id,password FROM tbl_login WHERE email_id=? AND isdeleted=0 LIMIT 1', [$user]);
    if (!$login || !verify_and_upgrade_password($con, (int)$login['login_id'], $currentPassword, (string)$login['password'])) {
        $errors[] = 'Your current password is incorrect.';
    } elseif (!valid_password($newPassword)) {
        $errors[] = 'The new password must be at least 8 characters long.';
    } elseif ($newPassword !== $confirmation) {
        $errors[] = 'The new password and confirmation do not match.';
    } else {
        db_execute($con, 'UPDATE tbl_login SET password=?,must_change_password=0 WHERE login_id=?', [password_hash($newPassword, PASSWORD_DEFAULT), (int)$login['login_id']]);
        flash_success('Your password has been changed.');
        redirect('editprofile.php');
    }
}
$userPageTitle = 'Change password | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell is-narrow">
        <div class="eg-account-form-heading"><p>Account security</p>
            <h1>Change password</h1><span>Use at least eight characters and avoid reusing an old password.</span></div>
        <?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
        <form method="post" class="eg-account-form"><?= csrf_field() ?>
            <div class="eg-form-grid single"><label>Current password<input type="password" name="current_password"
                                                                           required
                                                                           autocomplete="current-password"></label><label>New
                    password<input type="password" name="new_password" minlength="8" required
                                   autocomplete="new-password"></label><label>Confirm new password<input type="password"
                                                                                                         name="password_confirmation"
                                                                                                         minlength="8"
                                                                                                         required
                                                                                                         autocomplete="new-password"></label>
            </div>
            <div class="eg-form-actions">
                <button type="submit">Update password</button>
                <a href="editprofile.php">Cancel</a></div>
        </form>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
