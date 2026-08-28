<?php
require_once __DIR__ . '/config.php';
require_login('../login.php', 'user');
if (!is_post()) {
    http_response_code(405);
    exit('Method not allowed');
}
csrf_require();
$profile = db_one($con, 'SELECT user_id FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [current_user_email()]);
$type = request_string('item_type');
$itemId = request_int('item_id', 0, 'post');
if (!$profile || !in_array($type, favorite_types(), true) || $itemId < 1) {
    http_response_code(422);
    exit('Invalid favorite');
}
$saved = favorite_toggle($con, (int)$profile['user_id'], $type, $itemId);
flash_success($saved ? 'Saved to your favorites.' : 'Removed from your favorites.');
$returnTo = request_string('return_to', 'favorites.php');
if (!preg_match('~^(favorites\.php|\.\./[a-z0-9-]+\.php(?:\?[A-Za-z0-9_&=%.-]*)?)$~i', $returnTo)) {
    $returnTo = 'favorites.php';
}
redirect($returnTo);
