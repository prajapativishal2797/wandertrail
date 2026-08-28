<?php

const UPLOAD_ALLOWED_IMAGE_MIME = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'webp' => 'image/webp',
];

const UPLOAD_ALLOWED_DOCUMENT_MIME = [
        'pdf' => 'application/pdf',
    ] + UPLOAD_ALLOWED_IMAGE_MIME;

/**
 * Validates and stores an uploaded file safely: enforces a max size, checks
 * the extension against an allow-list, verifies the actual file content
 * (MIME sniffing + getimagesize for images) matches that extension, and
 * writes it under a random filename so the original name never reaches the
 * filesystem. This closes the unrestricted-upload hole in the previous
 * register/id-proof and admin image-upload forms (no MIME/type checks, and
 * uploaded files kept their original, attacker-controlled name).
 *
 * @param array<string,mixed> $file one entry of $_FILES
 * @param array<string,string> $allowedMime extension => expected MIME, e.g. UPLOAD_ALLOWED_IMAGE_MIME
 * @return array{ok: bool, path: string, error: string} $path is a path relative to the project root
 */
function safe_upload(array $file, string $destDirAbsolute, string $destDirRelative, array $allowedMime, int $maxBytes = 10485760): array
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'path' => '', 'error' => 'The file could not be uploaded.'];
    }

    if ($file['size'] <= 0 || $file['size'] > $maxBytes) {
        $maxMb = (int)($maxBytes / 1048576);

        return ['ok' => false, 'path' => '', 'error' => "The file must be smaller than {$maxMb}MB."];
    }

    $ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    if (!isset($allowedMime[$ext])) {
        return ['ok' => false, 'path' => '', 'error' => 'That file type is not allowed.'];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $detectedMime = $finfo ? finfo_file($finfo, $file['tmp_name']) : false;
    if ($finfo) {
        finfo_close($finfo);
    }

    if ($detectedMime !== $allowedMime[$ext]) {
        return ['ok' => false, 'path' => '', 'error' => "The file's content does not match a .$ext file."];
    }

    if (array_key_exists($ext, UPLOAD_ALLOWED_IMAGE_MIME) && @getimagesize($file['tmp_name']) === false) {
        return ['ok' => false, 'path' => '', 'error' => 'The image file is corrupt or unreadable.'];
    }

    if (!is_dir($destDirAbsolute) && !mkdir($destDirAbsolute, 0755, true) && !is_dir($destDirAbsolute)) {
        return ['ok' => false, 'path' => '', 'error' => 'The upload folder is not available.'];
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $absolutePath = rtrim($destDirAbsolute, '/\\') . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
        return ['ok' => false, 'path' => '', 'error' => 'The file could not be saved.'];
    }

    @chmod($absolutePath, 0644);

    $relativePath = rtrim($destDirRelative, '/') . '/' . $filename;

    return ['ok' => true, 'path' => $relativePath, 'error' => ''];
}
