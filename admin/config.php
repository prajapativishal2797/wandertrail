<?php

require_once dirname(__DIR__) . '/includes/database.php';
require_once dirname(__DIR__) . '/includes/helpers.php';

if (!isset($con) || !($con instanceof PDO)) {
    $con = explore_gujarat_database_connect();
}

require_once dirname(__DIR__) . '/includes/content.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/flash.php';
require_once dirname(__DIR__) . '/includes/validation.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/upload.php';
require_once dirname(__DIR__) . '/includes/mailer.php';
require_once dirname(__DIR__) . '/includes/favorites.php';
