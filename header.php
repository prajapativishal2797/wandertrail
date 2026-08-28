<?php

// Legacy URL compatibility; the shared implementation is module-owned.
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/helpers.php';
$title = $egPageTitle ?? 'WanderTrail';
require __DIR__ . '/modules/shared/header.php';
