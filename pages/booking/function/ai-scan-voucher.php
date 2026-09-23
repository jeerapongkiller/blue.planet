<?php
/**
 * AI voucher scan: POST voucher_image (file) OR voucher_text (pasted message).
 * Returns form-ready values mapped to existing ids (agent, product, category, zone, language, nationality).
 * Read-only: nothing is saved here.
 */
require_once __DIR__ . '/_ai-guard.php';
require_once __DIR__ . '/../../../controllers/AiScan.php';

try {
    $ai = new AiScan();
    $instruction = $ai->voucherInstruction();
    $system = 'You are a JSON-only extractor. Always respond with a single JSON object and nothing else.';

    $images = ai_uploaded_images('voucher_image', 1);
    $text = isset($_POST['voucher_text']) ? trim((string)$_POST['voucher_text']) : '';

    if (!empty($images)) {
        list($binary, $mime) = AiScan::prepareImage($images[0][0], $images[0][1], 1600);
        $parts = [
            ['text' => $instruction . "\n\nExtract from the attached image." . ($text !== '' ? "\nExtra note from staff (also apply it):\n\"\"\"\n" . $text . "\n\"\"\"" : '')],
            ['inline_data' => ['mime_type' => $mime, 'data' => base64_encode($binary)]],
        ];
    } elseif ($text !== '') {
        if (mb_strlen($text) > 8000) {
            ai_fail('ข้อความยาวเกินไป (สูงสุด 8,000 ตัวอักษร)');
        }
        $parts = [['text' => $instruction . "\n\nExtract from this message:\n\"\"\"\n" . $text . "\n\"\"\""]];
    } else {
        ai_fail('กรุณาแนบรูป Voucher หรือวางข้อความก่อน');
    }

    $raw = $ai->gemini($parts, $system, 6144);
    ai_json(['success' => true, 'data' => $ai->mapVoucher($raw)]);
} catch (Exception $e) {
    ai_fail($e->getMessage());
}
