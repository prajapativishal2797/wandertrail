<?php

function favorite_types(): array
{
    return ['destination', 'hotel', 'package', 'guide'];
}

function favorite_exists(PDO $db, int $userId, string $type, int $itemId): bool
{
    return (bool)db_value($db, 'SELECT 1 FROM tbl_user_favorite WHERE user_id=? AND item_type=? AND item_id=? LIMIT 1', [$userId, $type, $itemId]);
}

function favorite_toggle(PDO $db, int $userId, string $type, int $itemId): bool
{
    if (!in_array($type, favorite_types(), true) || $itemId < 1) {
        throw new InvalidArgumentException('Invalid favorite item.');
    }
    if (favorite_exists($db, $userId, $type, $itemId)) {
        db_execute($db, 'DELETE FROM tbl_user_favorite WHERE user_id=? AND item_type=? AND item_id=?', [$userId, $type, $itemId]);
        return false;
    }
    db_execute($db, 'INSERT INTO tbl_user_favorite (user_id,item_type,item_id) VALUES (?,?,?)', [$userId, $type, $itemId]);
    return true;
}

function favorite_user_id(PDO $db): ?int
{
    if (!function_exists('current_user_email') || current_user_role() !== 'user') {
        return null;
    }
    $id = db_value($db, 'SELECT user_id FROM tbl_register WHERE email_id=? AND isdeleted=0 LIMIT 1', [current_user_email()]);
    return $id === false ? null : (int)$id;
}

function favorite_button(PDO $db, string $type, int $itemId, string $returnTo): string
{
    $userId = favorite_user_id($db);
    if ($userId === null) {
        return '<a class="eg-save-link" href="login.php">Sign in to save</a>';
    }
    $saved = favorite_exists($db, $userId, $type, $itemId);
    return '<form class="eg-save-form" method="post" action="user/favorite-toggle.php">'
        . csrf_field() . '<input type="hidden" name="item_type" value="' . e($type) . '">'
        . '<input type="hidden" name="item_id" value="' . $itemId . '">'
        . '<input type="hidden" name="return_to" value="' . e('../' . ltrim($returnTo, '/')) . '">'
        . '<button type="submit"><i class="fa ' . ($saved ? 'fa-heart' : 'fa-heart-o') . '"></i> '
        . ($saved ? 'Saved' : 'Save') . '</button></form>';
}
