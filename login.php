<?php
global $pg;
$pg = 0;
include('header.php');
include('config.php');

/**
 * Only ever redirect to a path we recognise (user/*.php or admin/*.php) -
 * a bare "next" taken from the query string and redirected to verbatim
 * would be an open redirect.
 */
function eg_safe_next(?string $next): ?string
{
    if ($next === null || $next === '') {
        return null;
    }
    if (preg_match('~^(user|admin)/[A-Za-z0-9_\-]+\.php(\?[A-Za-z0-9_\-&=%.]*)?$~', $next)) {
        return $next;
    }

    return null;
}

$next = eg_safe_next($_GET['next'] ?? ($_POST['next'] ?? null));

if (is_logged_in()) {
    $target = $next ?? (current_user_role() === 'admin' ? 'admin/index.php' : 'user/index.php');
    header('Location: ' . $target);
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnlogin'])) {
    csrf_require();

    $email = trimmed($_POST['email'] ?? '');
    $password = (string)($_POST['pass'] ?? '');

    if ($email === '' || $password === '') {
        $errors[] = 'Please enter both your email and password.';
    } else {
        $result = attempt_login($con, $email, $password);
        if ($result['ok']) {
            $target = ($result['role'] === 'user' && !empty($result['must_change_password']))
                    ? 'user/changepassword.php'
                    : (($next !== null && $result['role'] === 'user')
                            ? $next
                            : ($result['role'] === 'admin' ? 'admin/index.php' : 'user/index.php'));
            header('Location: ' . $target);
            exit;
        }
        $errors[] = $result['message'];
    }
}
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href=""
                                                                                       class="last"><span>Log</span> In</a>
            <h2><span>Welcome</span> back</h2>
        </div>
    </div>
</section>

<div class="eg-page eg-auth-shell">
    <div class="eg-card eg-auth-card">
        <span class="eg-auth-eyebrow">WanderTrail</span>
        <h1 class="eg-auth-title">Log in to your account</h1>
        <p class="eg-auth-subtitle">Book hotels and packages, track your trips, and manage your profile.</p>

        <?php echo flash_render(); ?>
        <?php foreach ($errors as $error): ?>
            <div class="eg-alert eg-alert-danger" role="alert"><?php echo h($error); ?></div>
        <?php endforeach; ?>

        <form method="post" novalidate>
            <?php echo csrf_field(); ?>
            <?php if ($next !== null): ?><input type="hidden" name="next"
                                                value="<?php echo h($next); ?>"><?php endif; ?>

            <div class="eg-field">
                <label class="eg-label" for="email">Email address</label>
                <input class="eg-input" type="email" id="email" name="email" value="<?php echo old('email'); ?>"
                       required autofocus>
            </div>

            <div class="eg-field">
                <label class="eg-label" for="pass">Password</label>
                <input class="eg-input" type="password" id="pass" name="pass" required>
            </div>

            <div class="eg-auth-links">
                <span></span>
                <a class="eg-btn-link" href="forgot-password.php">Forgot your password?</a>
            </div>

            <button type="submit" name="btnlogin" class="eg-btn eg-btn-primary eg-btn-block">Log in</button>
        </form>

        <p class="eg-auth-footer">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>

<?php include('footer.php'); ?>
