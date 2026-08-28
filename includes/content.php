<?php

function h(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function cms_block(string $pageKey, string $blockKey): ?array
{
    global $con;
    static $cache = [];

    $cacheKey = $pageKey . ':' . $blockKey;
    if (array_key_exists($cacheKey, $cache)) {
        return $cache[$cacheKey];
    }

    $statement = $con->prepare(
        'SELECT content_id, page_key, block_key, title, content, image_path '
        . 'FROM tbl_content_block WHERE page_key = ? AND block_key = ? AND is_active = 1 LIMIT 1'
    );
    $statement->bind_param('ss', $pageKey, $blockKey);
    $statement->execute();
    $result = $statement->get_result();
    $block = $result->fetch_assoc() ?: null;
    $statement->close();

    return $cache[$cacheKey] = $block;
}

function cms_text(string $pageKey, string $blockKey, string $field = 'content', string $fallback = ''): string
{
    $block = cms_block($pageKey, $blockKey);
    return h($block[$field] ?? $fallback);
}
