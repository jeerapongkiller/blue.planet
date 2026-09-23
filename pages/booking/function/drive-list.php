<?php
/**
 * List the Drive images attached to a booking. POST booking_id.
 */
require_once __DIR__ . '/_ai-guard.php';
require_once __DIR__ . '/../../../controllers/GoogleDrive.php';

$booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
if ($booking_id <= 0) {
    ai_fail('Missing booking_id');
}
if (!GoogleDrive::isConfigured()) {
    ai_json(['success' => true, 'configured' => false, 'items' => []]);
}

try {
    $drive = new GoogleDrive();
    $drive->authenticate();
    ai_json(['success' => true, 'configured' => true, 'items' => $drive->listBookingImages($booking_id)]);
} catch (Exception $e) {
    ai_fail($e->getMessage());
}
