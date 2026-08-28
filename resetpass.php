<?php
global $pg;
$pg = 0;
include('header.php');
include('config.php');

$email = trimmed($_GET['email_id'] ?? '');
$token = trimmed($_GET['token'] ?? ($_POST['token'] ?? ''));
$tokenValid = $email !== '' && $token !== '' && password_reset_token_valid($con, $email, $token);
$errors = [];
$done = false;

if ($tokenValid && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnchange'])) {
    csrf_require();

    $newPassword = (string)($_POST['newpass'] ?? '');
    $confirmPassword = (string)($_POST['confirmpass'] ?? '');

    if (!valid_password($newPassword)) {
        $errors[] = 'Your new password must be at least 8 characters long.';
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = 'Password and confirmation do not match.';
    } else {
        complete_password_reset($con, $email, $token, $newPassword);
        $done = true;
    }
}
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href=""
                                                                                       class="last"><span>Reset</span>
                Password</a>
            <h2><span>Reset</span> your password</h2>
        </div>
    </div>
</section>

<div class="eg-page eg-auth-shell">
    <div class="eg-card eg-auth-card">
        <span class="eg-auth-eyebrow">WanderTrail</span>
        <h1 class="eg-auth-title">Choose a new password</h1>

        <?php if ($done): ?>
            <div class="eg-alert eg-alert-success" role="alert">Your password has been changed. You can now log in with
                your new password.
            </div>
            <p class="eg-text-center"><a class="eg-btn eg-btn-primary" href="login.php">Go to login</a></p>
        <?php elseif (!$tokenValid): ?>
            <div class="eg-alert eg-alert-danger" role="alert">This password reset link is invalid or has expired.</div>
            <p class="eg-text-center"><a class="eg-btn eg-btn-outline" href="forgot-password.php">Request a new link</a>
            </p>
        <?php else: ?>
            <?php foreach ($errors as $error): ?>
                <div class="eg-alert eg-alert-danger" role="alert"><?php echo h($error); ?></div>
            <?php endforeach; ?>

            <form method="post" novalidate>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="token" value="<?php echo h($token); ?>">

                <div class="eg-field">
                    <label class="eg-label" for="newpass">New password</label>
                    <input class="eg-input" type="password" id="newpass" name="newpass" minlength="8" required
                           autofocus>
                    <p class="eg-hint">At least 8 characters.</p>
                </div>

                <div class="eg-field">
                    <label class="eg-label" for="confirmpass">Confirm new password</label>
                    <input class="eg-input" type="password" id="confirmpass" name="confirmpass" minlength="8" required>
                </div>

                <button type="submit" name="btnchange" class="eg-btn eg-btn-primary eg-btn-block">Change password
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>
