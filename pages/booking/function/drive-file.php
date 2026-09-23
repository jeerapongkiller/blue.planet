<?php
/**
 * Stream a booking image from Google Drive to a logged-in user (files are not public on Drive).
 * GET id=<drive file id>
 */
ini_set('display_errors', '0');
require_once __DIR__ . '/../../../config/env.php';
require_once __DIR__ . '/../../../config/secrets.php';
require_once __DIR__ . '/../../../controllers/GoogleDrive.php';

if (empty($_SESSION['supplier']['id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

$file_id = isset($_GET['id']) ? (string)$_GET['id'] : '';

try {
    $drive = new GoogleDrive();
    $drive->authenticate();
    $file = $drive->downloadBookingImage($file_id);
} catch (Exception $e) {
    http_response_code(404);
    exit('File not found');
}

$mime = in_array($file['mime'], ['image/jpeg', 'image/png', 'image/webp'], true) ? $file['mime'] : 'application/octet-stream';
header('Content-Type: ' . $mime);
header('Content-Disposition: inline; filename="' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file['name']) . '"');
header('Cache-Control: private, max-age=3600');
header('X-Content-Type-Options: nosniff');
echo $file['body'];
