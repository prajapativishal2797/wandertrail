<?php

declare(strict_types=1);

require __DIR__ . '/config.php';
require_once __DIR__ . '/includes/helpers.php';
require __DIR__ . '/modules/home/data.php';

$title = 'WanderTrail | Trails to the places maps forget';
$message = null;
$error = null;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!csrf_valid()) {
        $error = 'Your session expired. Refresh the page and try again.';
    } else {
        $email = filter_var(trim((string)($_POST['email_id'] ?? '')), FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            $error = 'Enter a valid email address.';
        } elseif (newsletter_subscribe($con, $email)) {
            $message = 'You are subscribed to WanderTrail updates.';
        } else {
            $error = 'That email address is already subscribed.';
        }
    }
}

$destinations = home_destinations($con);
$packages = home_packages($con);
$hotels = home_hotels($con);

require __DIR__ . '/modules/shared/header.php';
echo '<main>';
require __DIR__ . '/modules/home/hero.php';
require __DIR__ . '/modules/destinations/featured.php';
require __DIR__ . '/modules/packages/featured.php';
require __DIR__ . '/modules/hotels/featured.php';
require __DIR__ . '/modules/planner/tools.php';
require __DIR__ . '/modules/newsletter/form.php';
echo '</main>';
require __DIR__ . '/modules/shared/footer.php';
