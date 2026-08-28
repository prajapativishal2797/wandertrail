<?php

function home_destinations(PDO $db, int $limit = 6): array
{
    $statement = $db->prepare('SELECT sp.*, p.place_name FROM tbl_subplace sp INNER JOIN tbl_place p ON p.place_id = sp.place_id WHERE sp.isdeleted = 0 ORDER BY sp.subplace_id DESC LIMIT ?');
    $statement->bind_param('i', $limit);
    $statement->execute();
    return $statement->get_result()->fetch_all(PDO::FETCH_ASSOC);
}

function home_packages(PDO $db, int $limit = 3): array
{
    $statement = $db->prepare('SELECT * FROM tbl_package WHERE isdeleted = 0 ORDER BY package_id DESC LIMIT ?');
    $statement->bind_param('i', $limit);
    $statement->execute();
    return $statement->get_result()->fetch_all(PDO::FETCH_ASSOC);
}

function home_hotels(PDO $db, int $limit = 3): array
{
    $statement = $db->prepare('SELECT h.*, p.place_name FROM tbl_hotel h INNER JOIN tbl_place p ON p.place_id = h.place_id WHERE h.isdeleted = 0 ORDER BY h.hotel_id DESC LIMIT ?');
    $statement->bind_param('i', $limit);
    $statement->execute();
    return $statement->get_result()->fetch_all(PDO::FETCH_ASSOC);
}

function newsletter_subscribe(PDO $db, string $email): bool
{
    $statement = $db->prepare('SELECT 1 FROM tbl_subscriber WHERE email_id = ? LIMIT 1');
    $statement->bind_param('s', $email);
    $statement->execute();
    if ($statement->get_result()->fetch_row()) {
        return false;
    }

    $statement = $db->prepare('INSERT INTO tbl_subscriber (email_id) VALUES (?)');
    $statement->bind_param('s', $email);
    return $statement->execute();
}
