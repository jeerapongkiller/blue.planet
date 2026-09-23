<?php
/**
 * Upload voucher / passport images of a booking to Google Drive.
 * POST booking_id, images[] (files), kinds[] ('voucher' | 'passport').
 * The link to the booking lives in Drive appProperties — the database is not changed.
 */
require_once __DIR__ . '/_ai-guard.php';
require_once __DIR__ . '/../../../controllers/AiScan.php';
require_once __DIR__ . '/../../../controllers/GoogleDrive.php';

$booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
if ($booking_id <= 0) {
    ai_fail('Missing booking_id');
}

try {
    $ai = new AiScan();
    if (!$ai->bookingExists($booking_id)) {
        ai_fail('ไม่พบ Booking นี้');
    }
    $bookingNo = $ai->bookingNo($booking_id);

    $images = ai_uploaded_images('images', 60);
    if (empty($images)) {
        ai_json(['success' => true, 'uploaded' => 0, 'items' => [], 'errors' => []]);
    }
    $kinds = isset($_POST['kinds']) ? (array)$_POST['kinds'] : [];

    $drive = new GoogleDrive();
    $drive->authenticate();

    $items = [];
    $errors = [];
    $stamp = date('Ymd_His');
    foreach ($images as $i => $img) {
        $kind = (isset($kinds[$i]) && $kinds[$i] === 'passport') ? 'passport' : 'voucher';
        list($binary, $mime) = AiScan::prepareImage($img[0], $img[1], 2000);
        $ext = $mime === 'image/png' ? 'png' : ($mime === 'image/webp' ? 'webp' : 'jpg');
        $fileName = ($bookingNo !== '' ? $bookingNo : 'BK' . $booking_id) . '_' . strtoupper($kind) . '_' . $stamp . '_' . ($i + 1) . '.' . $ext;
        try {
            $items[] = $drive->uploadBookingImage($binary, $mime, $fileName, $booking_id, $kind) + ['kind' => $kind];
        } catch (Exception $e) {
            $errors[] = $img[2] . ': ' . $e->getMessage();
        }
    }

    ai_json(['success' => empty($errors) || !empty($items), 'uploaded' => count($items), 'items' => $items, 'errors' => $errors]);
} catch (Exception $e) {
    ai_fail($e->getMessage());
}
