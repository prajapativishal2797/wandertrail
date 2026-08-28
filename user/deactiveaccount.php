<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$user = current_user_email();
$errors = [];
if (is_post()) {
    csrf_require();
    $current = (string)($_POST['current_password'] ?? '');
    $login = db_one($con, 'SELECT login_id,password FROM tbl_login WHERE email_id=? AND isdeleted=0 LIMIT 1', [$user]);
    if (!$login || !verify_and_upgrade_password($con, (int)$login['login_id'], $current, (string)$login['password'])) $errors[] = 'Your current password is incorrect.';
    else {
        db_transaction($con, function (PDO $db) use ($user): void {
            db_execute($db, 'UPDATE tbl_login SET isdeleted=1 WHERE email_id=?', [$user]);
            db_execute($db, 'UPDATE tbl_register SET isdeleted=1 WHERE email_id=?', [$user]);
        });
        log_out_session('../index.php');
    }
}
$userPageTitle = 'Deactivate account | WanderTrail';
require __DIR__ . '/header.php';
?>
<section class="eg-account-page">
    <div class="eg-account-form-shell is-narrow">
        <div class="eg-account-form-heading"><p>Account settings</p>
            <h1>Deactivate account</h1><span>Your login and customer profile will be disabled. Existing booking records remain with the agency.</span>
        </div><?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endforeach; ?>
        <form method="post" class="eg-account-form"
              onsubmit="return confirm('Deactivate your WanderTrail account?');"><?= csrf_field() ?>
            <div class="eg-form-grid single"><label>Current password<input type="password" name="current_password"
                                                                           required
                                                                           autocomplete="current-password"></label>
            </div>
            <div class="eg-form-actions">
                <button type="submit">Deactivate account</button>
                <a href="editprofile.php">Cancel</a></div>
        </form>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
