<?php

require_once __DIR__ . '/session_bootstrap.php';

function flash_set(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function flash_success(string $message): void
{
    flash_set('success', $message);
}

function flash_error(string $message): void
{
    flash_set('error', $message);
}

/**
 * Renders and clears any queued flash messages. Include assets/site/css/eg-ui.css
 * (or the admin/user equivalent) for the .eg-alert styles.
 */
function flash_render(): string
{
    if (empty($_SESSION['flash'])) {
        return '';
    }

    $out = '<div class="eg-alerts">';
    foreach ($_SESSION['flash'] as $item) {
        $type = $item['type'] === 'error' ? 'danger' : $item['type'];
        $out .= '<div class="eg-alert eg-alert-' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '" role="alert">'
            . htmlspecialchars($item['message'], ENT_QUOTES, 'UTF-8')
            . '</div>';
    }
    $out .= '</div>';

    unset($_SESSION['flash']);

    return $out;
}
