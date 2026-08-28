<?php
$title ??= 'WanderTrail';
$currentPage = basename((string)($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
$navigation = ['index.php' => 'Home', 'destinations.php' => 'Destinations', 'packages.php' => 'Packages', 'hotels.php' => 'Hotels', 'guides.php' => 'Guides', 'enquiry.php' => 'Plan a trip'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="WanderTrail helps travellers discover overlooked places, book stays and experiences, and plan memorable trips.">
    <meta name="application-name" content="WanderTrail">
    <title><?= e($title) ?></title>
    <link rel="icon" href="<?= asset('site/images/favicon.ico') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/reset.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/font-awesome.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/fonts/fi/flaticon.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/owl.carousel.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/jquery.fancybox.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/flexslider.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/main.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/indent.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/eg-tokens.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/eg-ui.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/eg-auth.css') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/public.css?v=20260823-2') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/public-detail.css?v=20260824-1') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/public-search.css?v=20260824-1') ?>">
    <link rel="stylesheet" href="<?= asset('site/css/public-enquiry.css?v=20260824-1') ?>">
</head>
<body class="eg-public">
<header class="eg-site-header">
    <div class="eg-nav-shell"><a class="eg-brand" href="index.php" aria-label="WanderTrail home"><span
                    class="eg-brand-mark">WT</span><span><strong>WanderTrail</strong><small>Trails to the places maps forget.</small></span></a>
        <button class="eg-nav-toggle" type="button" aria-expanded="false" aria-controls="public-navigation"
                aria-label="Open navigation"><i class="fa fa-bars" aria-hidden="true"></i></button>
        <nav class="eg-public-nav" id="public-navigation"
             aria-label="Main navigation"><?php foreach ($navigation as $url => $label): ?>
                <a href="<?= e($url) ?>"<?= $currentPage === $url ? ' class="is-active" aria-current="page"' : '' ?>><?= e($label) ?></a><?php endforeach; ?>
        </nav>
        <a class="eg-account-link"
           href="<?= !empty($_SESSION['user']) ? (current_user_role() === 'admin' ? 'admin/index.php' : 'user/index.php') : 'login.php' ?>"><i
                    class="fa fa-user"
                    aria-hidden="true"></i><span><?= !empty($_SESSION['user']) ? 'My account' : 'Sign in' ?></span></a>
    </div>
</header>
