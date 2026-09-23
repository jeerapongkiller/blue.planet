<?php
/**
 * Shared bootstrap for the AI scan / Drive endpoints:
 * POST-only, logged-in user with the BOOKING permission (permission id 1), JSON output.
 */
ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../../config/env.php';
require_once __DIR__ . '/../../../config/secrets.php';

function ai_json(array $data)
{
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function ai_fail(string $message, int $http = 200)
{
    http_response_code($http);
    ai_json(['success' => false, 'message' => $message]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ai_fail('Method not allowed', 405);
}

if (empty($_SESSION['supplier']['id'])) {
    ai_fail('Unauthorized - กรุณาเข้าสู่ระบบใหม่', 401);
}

$__permissions = isset($_SESSION['supplier']['permission']) && is_array($_SESSION['supplier']['permission']) ? $_SESSION['supplier']['permission'] : [];
if (!in_array(1, $__permissions) && (int)$_SESSION['supplier']['role_id'] !== 1) {
    ai_fail('ไม่มีสิทธิ์ใช้งานเมนู Booking', 403);
}

// Read the uploaded images of a multi-file field; returns [[binary, mime, name], ...]
function ai_uploaded_images(string $field, int $maxFiles = 60)
{
    $out = [];
    if (empty($_FILES[$field]['tmp_name'])) {
        return $out;
    }
    $tmp = (array)$_FILES[$field]['tmp_name'];
    $types = (array)$_FILES[$field]['type'];
    $names = (array)$_FILES[$field]['name'];
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/heic', 'image/heif'];
    foreach ($tmp as $i => $path) {
        if (count($out) >= $maxFiles) {
            break;
        }
        if (empty($path) || !is_uploaded_file($path)) {
            continue;
        }
        $binary = file_get_contents($path);
        if ($binary === false || $binary === '') {
            continue;
        }
        $mime = function_exists('mime_content_type') ? (string)mime_content_type($path) : (string)$types[$i];
        if (!in_array($mime, $allowed, true)) {
            continue;
        }
        $out[] = [$binary, $mime, (string)$names[$i]];
    }
    return $out;
}
