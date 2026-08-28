<?php

require_once __DIR__ . '/session_bootstrap.php';

const AUTH_MAX_FAILED_ATTEMPTS = 5;
const AUTH_LOCKOUT_MINUTES = 15;

function current_user_email(): ?string
{
    return $_SESSION['user'] ?? null;
}

function current_user_role(): ?string
{
    return $_SESSION['user_role'] ?? null;
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user']);
}

/**
 * Redirects away (with the session left untouched) unless the visitor is
 * logged in. Pass $role ('admin'|'user') to also enforce that the account
 * type matches - this is what admin/sidebar.php and user/header.php use to
 * fix the previous bug where any logged-in account (not just admins) could
 * reach every page under /admin.
 */
function require_login(string $redirectTo, ?string $role = null): void
{
    if (!is_logged_in() || ($role !== null && current_user_role() !== $role)) {
        header('Location: ' . $redirectTo);
        exit;
    }
}

function log_in_session(string $email, string $role): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = $email;
    $_SESSION['user_role'] = $role;
}

function log_out_session(string $redirectTo): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
    header('Location: ' . $redirectTo);
    exit;
}

/**
 * Verifies a submitted password against the stored value. Rows created
 * before this migration still hold a plaintext password (varchar(10) in
 * the original schema); on a successful legacy match the password is
 * transparently rehashed with password_hash() so it never has to be
 * compared in plaintext again.
 */
function verify_and_upgrade_password(PDO $con, int $loginId, string $plainPassword, string $storedPassword): bool
{
    $info = password_get_info($storedPassword);
    if ($info['algo'] !== null) {
        return password_verify($plainPassword, $storedPassword);
    }

    if (!hash_equals($storedPassword, $plainPassword)) {
        return false;
    }

    $newHash = password_hash($plainPassword, PASSWORD_DEFAULT);
    $stmt = $con->prepare('UPDATE tbl_login SET password = ? WHERE login_id = ?');
    $stmt->bind_param('si', $newHash, $loginId);
    $stmt->execute();
    $stmt->close();

    return true;
}

/**
 * @return array{ok: bool, role?: string, message?: string}
 */
function attempt_login(PDO $con, string $email, string $password): array
{
    $stmt = $con->prepare(
        'SELECT login_id, email_id, password, type, failed_attempts, locked_until, must_change_password '
        . 'FROM tbl_login WHERE email_id = ? AND isdeleted = 0 LIMIT 1'
    );
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) {
        return ['ok' => false, 'message' => 'Email or password is incorrect.'];
    }

    if (!empty($row['locked_until']) && strtotime($row['locked_until']) > time()) {
        $minutesLeft = (int)ceil((strtotime($row['locked_until']) - time()) / 60);

        return ['ok' => false, 'message' => "Too many failed attempts. Try again in {$minutesLeft} minute(s)."];
    }

    $loginId = (int)$row['login_id'];

    if (!verify_and_upgrade_password($con, $loginId, $password, $row['password'])) {
        $attempts = (int)$row['failed_attempts'] + 1;
        $lockedUntil = null;
        if ($attempts >= AUTH_MAX_FAILED_ATTEMPTS) {
            $lockedUntil = date('Y-m-d H:i:s', time() + AUTH_LOCKOUT_MINUTES * 60);
        }
        $stmt = $con->prepare('UPDATE tbl_login SET failed_attempts = ?, locked_until = ? WHERE login_id = ?');
        $stmt->bind_param('isi', $attempts, $lockedUntil, $loginId);
        $stmt->execute();
        $stmt->close();

        return ['ok' => false, 'message' => 'Email or password is incorrect.'];
    }

    $stmt = $con->prepare('UPDATE tbl_login SET failed_attempts = 0, locked_until = NULL, last_login_at = NOW() WHERE login_id = ?');
    $stmt->bind_param('i', $loginId);
    $stmt->execute();
    $stmt->close();

    $role = strtolower((string)$row['type']) === 'admin' ? 'admin' : 'user';
    log_in_session($row['email_id'], $role);

    return ['ok' => true, 'role' => $role, 'must_change_password' => !empty($row['must_change_password'])];
}

/**
 * Issues a password reset token (returned raw, for emailing) and stores
 * only its SHA-256 hash + expiry. Returns null when the email is not a
 * registered account - callers should still show a generic confirmation
 * message either way, to avoid leaking which emails are registered.
 */
function create_password_reset(PDO $con, string $email): ?string
{
    $stmt = $con->prepare('SELECT login_id FROM tbl_login WHERE email_id = ? AND isdeleted = 0 LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) {
        return null;
    }

    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $expires = date('Y-m-d H:i:s', time() + 3600);

    $stmt = $con->prepare('UPDATE tbl_login SET reset_token_hash = ?, reset_token_expires = ? WHERE login_id = ?');
    $stmt->bind_param('ssi', $tokenHash, $expires, $row['login_id']);
    $stmt->execute();
    $stmt->close();

    return $token;
}

function password_reset_token_valid(PDO $con, string $email, string $token): bool
{
    $tokenHash = hash('sha256', $token);
    $stmt = $con->prepare(
        'SELECT login_id FROM tbl_login '
        . 'WHERE email_id = ? AND reset_token_hash = ? AND reset_token_expires > NOW() AND isdeleted = 0 LIMIT 1'
    );
    $stmt->bind_param('ss', $email, $tokenHash);
    $stmt->execute();
    $found = (bool)$stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $found;
}

function complete_password_reset(PDO $con, string $email, string $token, string $newPassword): bool
{
    if (!password_reset_token_valid($con, $email, $token)) {
        return false;
    }

    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $con->prepare(
        'UPDATE tbl_login SET password = ?, reset_token_hash = NULL, reset_token_expires = NULL, '
        . 'must_change_password = 0, failed_attempts = 0, locked_until = NULL '
        . 'WHERE email_id = ? AND isdeleted = 0'
    );
    $stmt->bind_param('ss', $hash, $email);
    $stmt->execute();
    $stmt->close();

    return true;
}

/**
 * URL for a "Book now" / "Rate now" style call-to-action: the real
 * destination when a customer is signed in, or a login page that returns
 * them to that destination afterwards. Replaces the old links that always
 * pointed at myaccount.php with an unconditional onclick="alert('Please
 * login first')" - previously shown even to users who were already logged
 * in.
 */
function auth_cta_url(string $targetWhenLoggedIn): string
{
    if (is_logged_in() && current_user_role() === 'user') {
        return $targetWhenLoggedIn;
    }

    return 'login.php?next=' . urlencode($targetWhenLoggedIn);
}

function email_is_registered(PDO $con, string $email): bool
{
    $stmt = $con->prepare('SELECT login_id FROM tbl_login WHERE email_id = ? AND isdeleted = 0 LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $found = (bool)$stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $found;
}
