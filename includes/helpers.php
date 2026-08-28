<?php

// Some legacy routes compose multiple entry points. Keep this shared library
// safe even if an older route uses `require` instead of `require_once`.
if (defined('EXPLORE_GUJARAT_HELPERS_LOADED')) {
    return;
}
define('EXPLORE_GUJARAT_HELPERS_LOADED', true);

function e(mixed $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function asset(string $path): string
{
    return 'assets/' . ltrim($path, '/');
}

function request_int(string $key, int $default = 0, string $source = 'get'): int
{
    $value = filter_input($source === 'post' ? INPUT_POST : INPUT_GET, $key, FILTER_VALIDATE_INT);
    return $value === false || $value === null ? $default : $value;
}

function request_string(string $key, string $default = '', string $source = 'post'): string
{
    $values = $source === 'get' ? $_GET : $_POST;
    return trim((string)($values[$key] ?? $default));
}

function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}
