<?php
/**
 * AI passport / ID OCR: POST passport_images[] (1..40 files). Each photo may hold one or several
 * documents (or a printed traveller list). Images are processed in parallel.
 * Returns people[] with file_index so the UI can keep the photo for Drive upload.
 * Read-only: nothing is saved here.
 */
require_once __DIR__ . '/_ai-guard.php';
require_once __DIR__ . '/../../../controllers/AiScan.php';

try {
    $images = ai_uploaded_images('passport_images', 40);
    if (empty($images)) {
        ai_fail('กรุณาเลือกรูป Passport อย่างน้อย 1 รูป (JPG / PNG)');
    }

    $ai = new AiScan();
    $instruction = $ai->passportInstruction();
    $system = 'You are a JSON-only passport OCR extractor. Respond with a single JSON object and nothing else.';

    $partsList = [];
    foreach ($images as $img) {
        list($binary, $mime) = AiScan::prepareImage($img[0], $img[1], 1600);
        $partsList[] = [
            ['text' => $instruction],
            ['inline_data' => ['mime_type' => $mime, 'data' => base64_encode($binary)]],
        ];
    }

    // parallel, in batches of 8 to stay within API rate limits
    $people = [];
    $errors = [];
    foreach (array_chunk($partsList, 8, true) as $chunk) {
        $indexes = array_keys($chunk);
        $results = $ai->geminiMulti(array_values($chunk), $system, 4096);
        foreach ($results as $k => $res) {
            $fileIndex = $indexes[$k];
            if ($res['error'] !== '') {
                $errors[] = ['file_index' => $fileIndex, 'file_name' => $images[$fileIndex][2], 'message' => $res['error']];
                continue;
            }
            $rows = $ai->mapPassportPeople($res['data']);
            if (empty($rows)) {
                $errors[] = ['file_index' => $fileIndex, 'file_name' => $images[$fileIndex][2], 'message' => 'ไม่พบข้อมูล Passport ในรูปนี้'];
            }
            foreach ($rows as $row) {
                $row['file_index'] = $fileIndex;
                $people[] = $row;
            }
        }
    }

    ai_json(['success' => true, 'people' => $people, 'errors' => $errors]);
} catch (Exception $e) {
    ai_fail($e->getMessage());
}
