<?php

function valid_email(string $value): bool
{
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false && strlen($value) <= 50;
}

/** tbl_login.email_id / tbl_register.email_id are both varchar(50). */
function valid_password(string $value): bool
{
    return strlen($value) >= 8 && strlen($value) <= 72;
}

function valid_phone(string $value): bool
{
    return (bool)preg_match('/^\d{10}$/', $value);
}

function trimmed(?string $value): string
{
    return trim((string)$value);
}

/**
 * Re-populates a text input with the previously submitted value after a
 * validation failure, so the user doesn't have to retype the whole form.
 */
function old(string $key, string $default = ''): string
{
    $value = $_POST[$key] ?? $default;

    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
