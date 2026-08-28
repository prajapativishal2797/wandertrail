<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
$user = current_user_email();
$profile = db_one($con, 'SELECT * FROM tbl_register WHERE email_id = ? AND isdeleted = 0 LIMIT 1', [$user]);
if (!$profile) {
    log_out_session('../login.php');
}
$user_id = (int)$profile['user_id'];
$email_id = (string)$profile['email_id'];
$name = trim((string)$profile['first_name'] . ' ' . (string)$profile['last_name']);
$name = $name !== '' ? $name : $email_id;
$userPageTitle ??= 'My account | WanderTrail';
$userCurrentPage = basename((string)($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
$userNavigation = ['index.php' => 'Discover', 'favorites.php' => 'Saved', 'hotelbookinglist.php' => 'Hotel bookings', 'packagebookinglist.php' => 'Package bookings', 'editprofile.php' => 'Profile'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($userPageTitle) ?></title>
    <link rel="icon" href="../assets/site/images/favicon.ico">
    <link rel="stylesheet" href="../assets/user/css/reset.css">
    <link rel="stylesheet" href="../assets/user/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/user/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/user/fonts/fi/flaticon.css">
    <link rel="stylesheet" href="../assets/user/css/main.css">
    <link rel="stylesheet" href="../assets/user/css/indent.css">
    <link rel="stylesheet" href="../assets/site/css/eg-tokens.css">
    <link rel="stylesheet" href="../assets/site/css/eg-ui.css">
    <link rel="stylesheet" href="../assets/site/css/user-area.css?v=20260824-1">
    <link rel="stylesheet" href="../assets/site/css/user-bookings.css?v=20260824-1">
    <link rel="stylesheet" href="../assets/site/css/user-favorites.css?v=20260824-1">
    <link rel="stylesheet" href="../assets/site/css/user-payment.css?v=20260824-1">
    <link rel="stylesheet" href="../assets/site/css/user-booking-form.css?v=20260824-1">
</head>
<body class="eg-user-area">
<header class="eg-user-header">
    <div class="eg-user-nav-shell">
        <a class="eg-user-brand" href="index.php"><span>WT</span><strong>WanderTrail</strong></a>
        <button class="eg-user-nav-toggle" type="button" aria-expanded="false" aria-controls="user-navigation"><i
                    class="fa fa-bars"></i></button>
        <nav class="eg-user-nav" id="user-navigation"
             aria-label="User navigation"><?php foreach ($userNavigation as $url => $label): ?>
                <a href="<?= e($url) ?>"<?= $userCurrentPage === $url ? ' class="is-active" aria-current="page"' : '' ?>><?= e($label) ?></a><?php endforeach; ?>
        </nav>
        <div class="eg-user-menu"><span><small>Signed in as</small><?= e($name) ?></span><a href="logout.php">Log
                out</a></div>
    </div>
</header>
<main class="eg-user-main">
