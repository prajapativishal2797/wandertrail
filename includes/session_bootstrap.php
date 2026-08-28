<?php

/**
 * Starts the session with hardened cookie settings. Replaces the bare
 * session_start() calls that used to open every entry page, so cookie
 * flags are actually in effect (they must be set before the session
 * starts). Safe to include more than once.
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_name('EGSESSID');
    session_start();
}
