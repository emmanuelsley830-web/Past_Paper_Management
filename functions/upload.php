<?php
function store_pdf(array $file): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return [false, 'Please choose a valid PDF file.'];
    }
    if ($file['size'] > MAX_UPLOAD_BYTES) {
        return [false, 'PDF size exceeds the configured limit.'];
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if ($mime !== 'application/pdf') {
        return [false, 'Only PDF files are allowed.'];
    }
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    $name = date('Y/m');
    $dir = UPLOAD_DIR . '/' . $name;
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $filename = bin2hex(random_bytes(16)) . '.pdf';
    $target = $dir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        return [false, 'Upload failed. Please try again.'];
    }
    return [true, 'uploads/papers/' . $name . '/' . $filename];
}

function remove_uploaded_file(?string $path): void
{
    if (!$path) {
        return;
    }
    $full = BASE_PATH . '/' . ltrim($path, '/');
    if (is_file($full) && str_starts_with(realpath($full), realpath(UPLOAD_DIR))) {
        unlink($full);
    }
}

