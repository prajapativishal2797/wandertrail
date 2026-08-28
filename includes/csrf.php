<?php

require_once __DIR__ . '/session_bootstrap.php';

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_valid(): bool
{
    $token = $_POST['csrf_token'] ?? '';

    return is_string($token) && $token !== '' && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

/**
 * Call at the top of the POST branch of any state-changing page. Stops the
 * request with a 419 instead of processing it when the token is missing or
 * stale (expired session, resubmitted/forged form).
 */
function csrf_require(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && !csrf_valid()) {
        http_response_code(419);
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Session expired</title></head><body style="font-family:sans-serif;max-width:640px;margin:80px auto;text-align:center;">'
            . '<h1>Your session has expired</h1>'
            . '<p>The form could not be submitted because your session expired or the form was already used. Please go back and try again.</p>'
            . '<p><a href="javascript:history.back()">Go back</a></p>'
            . '</body></html>';
        exit;
    }
}
