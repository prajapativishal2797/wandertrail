<?php
global $pg;
$pg = 0;
include('header.php');
include('config.php');

$submitted = false;
$devResetLink = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnforgot'])) {
    csrf_require();

    $email = trimmed($_POST['email_id'] ?? '');
    if (!valid_email($email)) {
        $errors[] = 'Please enter a valid email address.';
    } else {
        $token = create_password_reset($con, $email);
        $submitted = true;

        if ($token !== null) {
            $baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
            $baseDir = $baseDir === '/' ? '' : $baseDir;
            $resetUrl = (($_SERVER['HTTPS'] ?? '') === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']
                    . $baseDir . '/resetpass.php?email_id=' . urlencode($email) . '&token=' . $token;

            $sent = send_mail(
                    $email,
                    'Reset your WanderTrail password',
                    '<p>We received a request to reset your WanderTrail password.</p>'
                    . '<p><a href="' . htmlspecialchars($resetUrl, ENT_QUOTES, 'UTF-8') . '">Click here to choose a new password</a>. '
                    . 'This link expires in 1 hour.</p>'
                    . '<p>If you did not request this, you can safely ignore this email.</p>'
            );

            if (!$sent) {
                error_log('Password reset link for ' . $email . ': ' . $resetUrl);
                if (is_local_request()) {
                    $devResetLink = $resetUrl;
                }
            }
        }
    }
}
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href=""
                                                                                       class="last"><span>Forgot</span>
                Password</a>
            <h2><span>Forgot</span> your password?</h2>
        </div>
    </div>
</section>

<div class="eg-page eg-auth-shell">
    <div class="eg-card eg-auth-card">
        <span class="eg-auth-eyebrow">WanderTrail</span>
        <h1 class="eg-auth-title">Reset your password</h1>
        <p class="eg-auth-subtitle">Enter the email address on your account and we'll send you a link to choose a new
            password.</p>

        <?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger" role="alert"><?php echo h($error); ?></div>
        <?php endforeach; ?>

        <?php if ($submitted): ?>
            <div class="eg-alert eg-alert-success" role="alert">
                If that email address is registered, we've sent a link to reset your password. Check your inbox (and
                spam folder).
            </div>
            <?php if ($devResetLink !== null): ?>
                <div class="eg-alert eg-alert-info" role="alert">
                    <strong>Development mode</strong> - MAIL_HOST/MAIL_USERNAME/MAIL_PASSWORD are not configured on this
                    machine, so no email was actually sent. Use this link to continue testing:<br>
                    <a href="<?php echo h($devResetLink); ?>"><?php echo h($devResetLink); ?></a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <form method="post" novalidate>
                <?php echo csrf_field(); ?>
                <div class="eg-field">
                    <label class="eg-label" for="email_id">Email address</label>
                    <input class="eg-input" type="email" id="email_id" name="email_id"
                           value="<?php echo old('email_id'); ?>" required autofocus>
                </div>
                <button type="submit" name="btnforgot" class="eg-btn eg-btn-primary eg-btn-block">Send reset link
                </button>
            </form>
        <?php endif; ?>

        <p class="eg-auth-footer"><a href="login.php">Back to log in</a></p>
    </div>
</div>

<?php include('footer.php'); ?>
