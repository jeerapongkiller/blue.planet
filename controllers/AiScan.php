<?php
require_once __DIR__ . '/DB.php';

/**
 * AI scan helper for the Booking form (voucher image / pasted text / passport OCR).
 *
 * READ-ONLY against the database: it only loads reference lists (agents, products,
 * categories, zones, languages, nationalities, extra charges) and maps the AI output
 * onto existing ids. Nothing is inserted or updated here.
 *
 * Compatible with PHP 7.3+ (no typed properties / arrow functions / match).
 */
class AiScan extends DB
{
    private $refCache = [];

    public function __construct()
    {
        parent::__construct();
    }

    # ------------------------------------------------------------------ #
    # Reference data (read-only)
    # ------------------------------------------------------------------ #

    private function fetchAll(string $query, string $types = '', array $params = [])
    {
        $statement = $this->connection->prepare($query);
        if ($types !== '') {
            $statement->bind_param($types, ...$params);
        }
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function agents()
    {
        if (!isset($this->refCache['agents'])) {
            $this->refCache['agents'] = $this->fetchAll(
                "SELECT id, name FROM companies WHERE is_approved = 1 AND is_deleted = 0 AND company_type_id != 1"
            );
        }
        return $this->refCache['agents'];
    }

    public function products()
    {
        if (!isset($this->refCache['products'])) {
            $this->refCache['products'] = $this->fetchAll(
                "SELECT id, name FROM products WHERE is_approved = 1 AND is_deleted = 0 ORDER BY id"
            );
        }
        return $this->refCache['products'];
    }

    public function categories(int $product_id)
    {
        return $this->fetchAll(
            "SELECT id, name, transfer, customer FROM product_category
             WHERE product_id = ? AND is_approved = 1 AND is_deleted = 0 ORDER BY id",
            'i',
            [$product_id]
        );
    }

    public function zones()
    {
        if (!isset($this->refCache['zones'])) {
            $this->refCache['zones'] = $this->fetchAll(
                "SELECT id, name, name_th, start_pickup, end_pickup FROM zones WHERE is_deleted = 0 ORDER BY id"
            );
        }
        return $this->refCache['zones'];
    }

    public function languages()
    {
        if (!isset($this->refCache['languages'])) {
            $this->refCache['languages'] = $this->fetchAll("SELECT id, name_thai, name_eng FROM languages ORDER BY id");
        }
        return $this->refCache['languages'];
    }

    public function nationalities()
    {
        if (!isset($this->refCache['nationalities'])) {
            $this->refCache['nationalities'] = $this->fetchAll(
                "SELECT id, name FROM nationalitys WHERE is_approved = 1 ORDER BY name"
            );
        }
        return $this->refCache['nationalities'];
    }

    public function extraCharges()
    {
        if (!isset($this->refCache['extras'])) {
            $this->refCache['extras'] = $this->fetchAll(
                "SELECT id, name FROM extra_charges WHERE is_approved = 1 AND is_deleted = 0 ORDER BY id"
            );
        }
        return $this->refCache['extras'];
    }

    public function bookingNo(int $booking_id)
    {
        $rows = $this->fetchAll("SELECT bo_full FROM bookings_no WHERE booking_id = ? LIMIT 1", 'i', [$booking_id]);
        return !empty($rows) ? $rows[0]['bo_full'] : '';
    }

    public function bookingExists(int $booking_id)
    {
        $rows = $this->fetchAll("SELECT id FROM bookings WHERE id = ? LIMIT 1", 'i', [$booking_id]);
        return !empty($rows);
    }

    # ------------------------------------------------------------------ #
    # Gemini
    # ------------------------------------------------------------------ #

    /**
     * Call Gemini with the given parts; returns the decoded JSON object the model produced.
     * Throws Exception with a Thai message on failure.
     */
    public function gemini(array $parts, string $systemText, int $maxTokens = 6144)
    {
        $multi = $this->geminiMulti([$parts], $systemText, $maxTokens);
        if ($multi[0]['error'] !== '') {
            throw new Exception($multi[0]['error']);
        }
        return $multi[0]['data'];
    }

    /**
     * Run several Gemini requests in parallel (used for many passports at once).
     * Returns [ ['data' => array|null, 'error' => string], ... ] in the same order.
     */
    public function geminiMulti(array $partsList, string $systemText, int $maxTokens = 2048)
    {
        if (!defined('BP_GEMINI_API_KEY') || BP_GEMINI_API_KEY === '') {
            throw new Exception('ยังไม่ได้ตั้งค่า Gemini API key (config/secrets.php)');
        }
        $model = defined('BP_GEMINI_MODEL') && BP_GEMINI_MODEL !== '' ? BP_GEMINI_MODEL : 'gemini-2.5-flash';
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . BP_GEMINI_API_KEY;

        $mh = curl_multi_init();
        $handles = [];
        foreach ($partsList as $i => $parts) {
            $payload = [
                'systemInstruction' => ['parts' => [['text' => $systemText]]],
                'contents' => [['parts' => $parts]],
                'generationConfig' => [
                    'temperature' => 0.0,
                    'maxOutputTokens' => $maxTokens,
                    'response_mime_type' => 'application/json',
                    'thinkingConfig' => ['thinkingBudget' => 0],
                ],
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_multi_add_handle($mh, $ch);
            $handles[$i] = $ch;
        }

        do {
            $status = curl_multi_exec($mh, $running);
            if ($running) {
                curl_multi_select($mh, 1.0);
            }
        } while ($running && $status === CURLM_OK);

        $results = [];
        foreach ($handles as $i => $ch) {
            $resp = curl_multi_getcontent($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlErr = curl_error($ch);
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
            $results[$i] = $this->parseGeminiResponse((string)$resp, $httpCode, $curlErr);
        }
        curl_multi_close($mh);

        return $results;
    }

    private function parseGeminiResponse(string $resp, int $httpCode, string $curlErr)
    {
        // status only — responses contain customer / passport data
        $this->log("HTTP=$httpCode bytes=" . strlen($resp) . ($curlErr !== '' ? " err=$curlErr" : ''));
        if ($httpCode !== 200 || $resp === '') {
            return ['data' => null, 'error' => 'AI ไม่ตอบกลับ (HTTP ' . $httpCode . ')' . ($curlErr ? ' - ' . $curlErr : '')];
        }
        $decoded = json_decode($resp, true);
        $text = isset($decoded['candidates'][0]['content']['parts'][0]['text']) ? (string)$decoded['candidates'][0]['content']['parts'][0]['text'] : '';
        $text = trim(preg_replace('/^```json\s*|\s*```$/m', '', $text));
        $data = self::decodeJsonLenient($text);
        if (!is_array($data)) {
            $finish = isset($decoded['candidates'][0]['finishReason']) ? $decoded['candidates'][0]['finishReason'] : '';
            if ($finish === 'MAX_TOKENS') {
                return ['data' => null, 'error' => 'ข้อมูลยาวเกินไป AI ตอบไม่ครบ กรุณาครอปรูปให้เหลือเฉพาะส่วนสำคัญแล้วลองใหม่'];
            }
            return ['data' => null, 'error' => 'AI ตอบกลับไม่เป็นรูปแบบที่อ่านได้ กรุณาลองใหม่'];
        }
        return ['data' => isset($data['data']) && is_array($data['data']) ? $data['data'] : $data, 'error' => ''];
    }

    /** Gemini sometimes drops the last closing brace(s) on long lists — close them and retry. */
    private static function decodeJsonLenient(string $text)
    {
        $data = json_decode($text, true);
        if (is_array($data) || $text === '') {
            return $data;
        }
        // count unclosed { and [ outside strings, then append the missing closers in order
        $stack = [];
        $inString = false;
        $len = strlen($text);
        for ($i = 0; $i < $len; $i++) {
            $c = $text[$i];
            if ($inString) {
                if ($c === '\\') {
                    $i++;
                } elseif ($c === '"') {
                    $inString = false;
                }
                continue;
            }
            if ($c === '"') {
                $inString = true;
            } elseif ($c === '{' || $c === '[') {
                $stack[] = $c;
            } elseif (($c === '}' || $c === ']') && !empty($stack)) {
                array_pop($stack);
            }
        }
        if ($inString || empty($stack)) {
            return null;
        }
        $closers = '';
        while (!empty($stack)) {
            $closers .= array_pop($stack) === '{' ? '}' : ']';
        }
        $data = json_decode($text . $closers, true);
        return is_array($data) ? $data : null;
    }

    private function log(string $line)
    {
        $dir = __DIR__ . '/../storage/ai-scan';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        // .php + exit guard: never readable over HTTP even where .htaccess is ignored
        $file = $dir . '/ai-scan-log.php';
        if (!is_file($file)) {
            @file_put_contents($file, "<?php http_response_code(404); exit; ?>\n");
        }
        @file_put_contents($file, '[' . date('Y-m-d H:i:s') . '] ' . $line . PHP_EOL, FILE_APPEND);
    }

    # ------------------------------------------------------------------ #
    # Image helper
    # ------------------------------------------------------------------ #

    /** Downscale big photos (keeps enough resolution for handwriting). Returns [binary, mime]. */
    public static function prepareImage(string $binary, string $mime, int $maxDim = 1600)
    {
        if (!function_exists('imagecreatefromstring')) {
            return [$binary, $mime];
        }
        $src = @imagecreatefromstring($binary);
        if (!$src) {
            return [$binary, $mime];
        }
        $w = imagesx($src);
        $h = imagesy($src);
        if ($w <= $maxDim && $h <= $maxDim && strlen($binary) <= 1500 * 1024) {
            imagedestroy($src);
            return [$binary, $mime];
        }
        $ratio = min($maxDim / $w, $maxDim / $h, 1);
        $nw = max(1, (int)round($w * $ratio));
        $nh = max(1, (int)round($h * $ratio));
        $dst = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        ob_start();
        imagejpeg($dst, null, 85);
        $out = ob_get_clean();
        imagedestroy($src);
        imagedestroy($dst);
        return [$out, 'image/jpeg'];
    }

    # ------------------------------------------------------------------ #
    # Prompts
    # ------------------------------------------------------------------ #

    public function voucherInstruction()
    {
        $today = date('Y-m-d');

        $products = [];
        foreach ($this->products() as $p) {
            $products[] = $p['id'] . '=' . $p['name'];
        }
        $zones = [];
        foreach ($this->zones() as $z) {
            $zones[] = $z['id'] . '=' . $z['name'] . ($z['name_th'] !== '' && $z['name_th'] !== $z['name'] ? '/' . $z['name_th'] : '');
        }

        return
            "You read tour booking vouchers for BLUE PLANET HOLIDAY (a Phuket boat-tour operator). The input is a photo of a paper voucher " .
            "(often HANDWRITTEN), a screenshot of a LINE/WhatsApp chat, or pasted chat text. Today is {$today} (Asia/Bangkok).\n" .
            "Respond with ONE JSON object only, shaped EXACTLY as:\n" .
            '{"data":{' .
            '"voucher_no":string|null,' .
            '"agent_name":string|null,' .
            '"sender_name":string|null,' .
            '"customer_phone":string|null,' .
            '"tour_text":string|null,' .
            '"product_id":integer|null,' .
            '"booking_type":"join"|"private",' .
            '"travel_date":"YYYY-MM-DD"|null,' .
            '"transfer":"pickup"|"none"|"unknown",' .
            '"pickup_place":string|null,' .
            '"pickup_zone_id":integer|null,' .
            '"dropoff_place":string|null,' .
            '"dropoff_zone_id":integer|null,' .
            '"start_pickup":"HH:MM"|null,' .
            '"end_pickup":"HH:MM"|null,' .
            '"room_no":string|null,' .
            '"guide_language":"thai"|"english"|"chinese"|"russian"|null,' .
            '"pax_thai":{"adult":int,"child":int,"infant":int,"foc":int},' .
            '"pax_foreign":{"adult":int,"child":int,"infant":int,"foc":int},' .
            '"passengers":[{"name":string,"type":"adult"|"child"|"infant"|"foc","nationality":string|null,"passport_no":string|null,"birth_date":"YYYY-MM-DD"|null}],' .
            '"total_price":number|null,' .
            '"deposit":number|null,' .
            '"cot":number|null,' .
            '"extra_charges":[{"name":string,"amount":number}],' .
            '"remark":string|null,' .
            '"uncertain_fields":[string]' .
            "}}\n\n" .
            "RULES:\n" .
            "- OVERLAY NOTES WIN: colored labels/stickers/typed text drawn ON TOP of the photo (e.g. 'catamaran English', 'speed boat cot2200', 'update cot 1900', " .
            "'อัพเดทเป็น 4+1infant') are the operator's LATEST corrections. They OVERRIDE what is handwritten on the voucher (pax, COT, boat type, guide language).\n" .
            "- product_id: choose from PRODUCTS by destination + boat type. PP / Phi Phi / PP+Khai / 'Phi Phi Khai' = Phi Phi. CAT / catamaran / catamalan = CATAMARAN; " .
            "speed boat / speedboat / speed bout = speed boat. James Bond / Phang Nga = JAMES BOND. Similan = Similan. 'Khai' alone / 'เกาะไข่ ครึ่งวัน' = Khai half day. " .
            "If the destination is clear but the boat type is not stated, pick the speed-boat product and add 'product_id' to uncertain_fields. null if unrelated.\n" .
            "- tour_text: the program/tour line exactly as written (e.g. 'Phi Phi Khai Day Trip Speed Boat').\n" .
            "- Dates: vouchers use D/M order. 2-digit years like '26' mean 2026; Buddhist years (2569, '69') subtract 543. If the year is missing, use the next upcoming date. " .
            "travel_date = the TRIP / departure date (labels: Dep. Date, Departure Date, Trip Date, DATE in chat), NOT the voucher issue date. " .
            "Handwritten 2-digit years 68/69/70 are Buddhist (69 = 2026). If any handwritten digit of the travel date is hard to read, add 'travel_date' to uncertain_fields.\n" .
            "- Pax shorthand: '2AD' = 2 adults; '5+1CHD+1INF' = 5 adults, 1 child, 1 infant; 'PAX:2' = 2 adults; '3 Pax' = 3 adults. " .
            "Put the counts in pax_foreign unless the guests are clearly Thai (Thai names / 'คนไทย'), then use pax_thai. FOC (guide/leader free of charge) goes to foc only.\n" .
            "- booking_type: 'private' ONLY when the booking itself is explicitly private/charter; otherwise 'join'. 'PRIVATE CAR' / private transfer does NOT make the tour private.\n" .
            "- transfer: 'pickup' when a hotel / pickup place or pickup time is given; 'none' when the guest comes by themselves (มาเอง, no transfer, 'TF: no'); " .
            "'unknown' when transfer is undecided (e.g. 'TF:แจ้งอีกที') — add 'transfer' to uncertain_fields.\n" .
            "- pickup_place: hotel name as written, corrected to the real hotel name if the handwriting is obviously a known Phuket hotel. pickup_zone_id: best matching id from ZONES for that hotel's area (Patong, Karon, Kata, Kamala, Surin, Bang Tao, Phuket Town, ...); null if unsure. " .
            "ZONES come in two sets: names ending in -S / (S) are the early pickups for SIMILAN trips; names ending in -P / (P) / -PP are for all other trips (Phi Phi, James Bond, Khai). Pick the set that matches product_id.\n" .
            "- start_pickup/end_pickup: pickup time range '7.45 - 8.00' => 07:45 and 08:00. A single time => both equal.\n" .
            "- guide_language: from 'English guide', 'Eng', 'Russ G.' (russian), 'Chinese guide', 'ไกด์จีน' (chinese), 'ไกด์ไทย'.\n" .
            "- MONEY: total_price = full tour price. deposit = amount already paid to the agent. cot = CASH ON TOUR still to collect on the tour day " .
            "(labels: COT, Cot, Cash on tour, Cash). If only total and deposit are given, cot = total - deposit. If 'PAID' is stamped and no COT is written, cot = 0. " .
            "Numbers like '3,200' or '3.200' are 3200.\n" .
            "- voucher_no: the voucher / booking reference (No. 5296, 'Vc A1934', 'SPM-260831-SPMD-1S', 'FY-261004LEO-XT-A'). Keep any letters/prefix.\n" .
            "- agent_name: the travel agent that SENT the booking = the company printed in the voucher header/logo (e.g. 'Phuket Attraction', 'Anna & Victor Tour', 'ROTANA PHUKET'), " .
            "or in a chat screenshot the agent/company name typed in a message (e.g. 'Thaidream', 'Futai', 'Fuxing group'). " .
            "NEVER return 'Blue Planet' (that is us, the supplier — e.g. 'Supplier: Blue Planet', 'Catamaran by Blue planet').\n" .
            "- sender_name: staff who issued/sent it ('Issued by', 'Booked by', 'Sender'). Not the guest.\n" .
            "- customer_phone: the GUEST's phone (e.g. on the guest signature line / 'Tel' of the guest / '+91 97467 13103' in chat). NEVER a phone PRINTED on the voucher form " .
            "(header/footer 'Tel', 'WhatsApp', 'Line ID' of the company) and NEVER a guide's phone — null if no guest phone.\n" .
            "- A tour GUIDE sent by the agent ('ไกด์ ...', 'Guide: ...', often with a phone) is NOT a passenger and NOT the customer phone: put 'Guide: name phone' in remark.\n" .
            "- passengers: one entry per NAMED traveller only (lead guest name counts). Do not repeat names to fill the pax count. nationality = English country name if stated.\n" .
            "- extra_charges: additional paid items that are not the tour fare (extra luggage, private car, park fee...). amount 0 if no price.\n" .
            "- remark: useful operational notes only (meeting point, guide phone, special requests). Ignore printed terms/conditions, refund policy, addresses, social links.\n" .
            "- Use null / 0 / [] when not present. Never invent. If you are guessing a value, add its key to uncertain_fields.\n\n" .
            "PRODUCTS: " . implode(', ', $products) . "\n" .
            "ZONES: " . implode(', ', $zones);
    }

    public function passportInstruction()
    {
        return
            "Extract traveller identity data from this image. It may be ONE passport / national ID card, SEVERAL documents in one photo, " .
            "or a printed list/table of travellers. Read the MRZ (machine-readable zone) when present — it is the most reliable source.\n" .
            "Respond with ONE JSON object only, shaped EXACTLY as:\n" .
            '{"data":{"people":[{' .
            '"passport_no":string|null,' .
            '"full_name":string|null,' .
            '"nationality":string|null,' .
            '"nationality_iso3":string|null,' .
            '"birth_date":"YYYY-MM-DD"|null,' .
            '"sex":"M"|"F"|null,' .
            '"expiry_date":"YYYY-MM-DD"|null' .
            "}]}}\n" .
            "Rules: one object per person, in reading order. full_name = SURNAME + given names in Latin letters as printed (e.g. 'SAADON DAVID'). " .
            "nationality = ENGLISH COUNTRY name (e.g. 'Israel', 'Kazakhstan', 'Russia', 'China', 'Thailand'), not a demonym. " .
            "nationality_iso3 = the 3-letter code (MRZ style, e.g. ISR, KAZ, RUS, CHN, THA). Convert MRZ dates YYMMDD to YYYY-MM-DD " .
            "(birth years: choose the century that makes the person 0-100 years old). For Thai ID cards use the 13-digit number as passport_no. " .
            "Use null when unreadable. Never invent values. Return {\"data\":{\"people\":[]}} if no identity document is visible.";
    }

    # ------------------------------------------------------------------ #
    # Mapping AI output -> existing ids
    # ------------------------------------------------------------------ #

    public static function normalizeName(string $name)
    {
        $n = mb_strtoupper(trim($name), 'UTF-8');
        $n = str_replace(['&', '＆'], ' AND ', $n);
        $n = preg_replace('/\b(CO\.?|LTD\.?|LIMITED|COMPANY|CO,?\.?,?LTD\.?|PART\.?)\b/u', ' ', $n);
        $n = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $n);
        return trim(preg_replace('/\s+/', ' ', $n));
    }

    private static function distinctWords(string $normalized)
    {
        static $generic = ['PHUKET', 'TOUR', 'TOURS', 'TRAVEL', 'TRAVELS', 'AND', 'THE', 'GROUP', 'GROP', 'HOLIDAY', 'HOLIDAYS',
            'SERVICE', 'SERVICES', 'AGENCY', 'AGENT', 'AGENTS', 'TRIP', 'TRIPS', 'THAILAND', 'THAI', 'BOOKING', 'TICKET', 'TICKETS', 'OP'];
        $words = array_filter(explode(' ', $normalized), function ($w) use ($generic) {
            return $w !== '' && !in_array($w, $generic, true);
        });
        return array_values(array_unique($words));
    }

    /** Fuzzy match the AI agent name against companies. Returns ['id','name','score','candidates'] */
    public function matchAgent($agentName)
    {
        $empty = ['id' => 0, 'name' => '', 'score' => 0, 'candidates' => []];
        $agentName = trim((string)$agentName);
        if ($agentName === '') {
            return $empty;
        }
        $needle = self::normalizeName($agentName);
        $needleCompact = str_replace(' ', '', $needle);
        if ($needle === '' || preg_match('/^BLUE ?PLANET/', $needle)) {
            return $empty;
        }

        $scored = [];
        foreach ($this->agents() as $a) {
            $hay = self::normalizeName($a['name']);
            if ($hay === '') {
                continue;
            }
            $hayCompact = str_replace(' ', '', $hay);
            $lenRatio = min(mb_strlen($hayCompact), mb_strlen($needleCompact)) / max(mb_strlen($hayCompact), mb_strlen($needleCompact), 1);
            if ($hayCompact === $needleCompact) {
                $score = 100;
            } elseif ($lenRatio >= 0.6 && mb_strlen($needleCompact) >= 4
                && (mb_strpos($hayCompact, $needleCompact) !== false || mb_strpos($needleCompact, $hayCompact) !== false)) {
                // one name contains the other and they are of similar length ("THAI DREAM TOUR" vs "THAIDREAM")
                $score = 88;
            } else {
                // half string similarity + half overlap of DISTINCTIVE words
                // ("2 THE BEACH TOUR & TRAVEL" ~ "2 THE BEACH TOUR / GOOD DAY", not "BENA TOUR & TRAVEL")
                similar_text($needleCompact, $hayCompact, $pct);
                $nw = self::distinctWords($needle);
                $hw = self::distinctWords($hay);
                $overlap = (!empty($nw) && !empty($hw)) ? count(array_intersect($nw, $hw)) / min(count($nw), count($hw)) : 0;
                $score = (int)round($pct * 0.5 + $overlap * 50);
            }
            $scored[] = ['id' => (int)$a['id'], 'name' => $a['name'], 'score' => min(100, $score)];
        }
        usort($scored, function ($x, $y) {
            return $y['score'] - $x['score'];
        });
        $top = array_slice($scored, 0, 5);
        $best = !empty($top) ? $top[0] : null;
        if ($best && $best['score'] >= 75) {
            return ['id' => $best['id'], 'name' => $best['name'], 'score' => $best['score'], 'candidates' => $top];
        }
        return ['id' => 0, 'name' => '', 'score' => $best ? $best['score'] : 0, 'candidates' => $top];
    }

    /** Pick the category ids for a product: customer 1=Thai 2=Foreign, transfer 1/0 */
    public function matchCategories(int $product_id, bool $hasThai, bool $hasForeign, bool $withTransfer)
    {
        $result = [];
        if ($product_id <= 0) {
            return $result;
        }
        $cats = $this->categories($product_id);
        $want = [];
        if ($hasThai) {
            $want[] = 1;
        }
        if ($hasForeign || !$hasThai) {
            $want[] = 2;
        }
        foreach ($want as $customer) {
            foreach ($cats as $c) {
                if ((int)$c['customer'] === $customer && (int)$c['transfer'] === ($withTransfer ? 1 : 0)) {
                    $result[] = ['id' => (int)$c['id'], 'name' => $c['name'], 'customer' => $customer];
                    break;
                }
            }
        }
        return $result;
    }

    public function validZone($zone_id)
    {
        $zone_id = (int)$zone_id;
        foreach ($this->zones() as $z) {
            if ((int)$z['id'] === $zone_id) {
                return ['id' => $zone_id, 'name' => $z['name'], 'start_pickup' => substr($z['start_pickup'], 0, 5), 'end_pickup' => substr($z['end_pickup'], 0, 5)];
            }
        }
        return ['id' => 0, 'name' => '', 'start_pickup' => '', 'end_pickup' => ''];
    }

    /** Zone set suffix: "S" (Similan early pickup) or "P" (Phi Phi / James Bond / Khai); '' when unknown. */
    private static function zoneSet(string $zoneName)
    {
        $n = strtoupper(trim($zoneName));
        if (preg_match('/(-\s*S{1,2}|\(S\)|\sS)$/', $n)) {
            return 'S';
        }
        if (preg_match('/(-\s*P{1,2}|\(P\)|\sP{1,2}|[^A-Z]P)$/', $n)) {
            return 'P';
        }
        return '';
    }

    private static function zoneBase(string $zoneName)
    {
        $n = strtoupper(trim($zoneName));
        $n = preg_replace('/\s*(-\s*[SP]{1,2}|\([SP]\)|\s[SP]{1,2})$/', '', $n);
        return preg_replace('/[^\p{L}\p{N}]+/u', '', $n);
    }

    /** Swap a zone to its -S / -P sibling so it matches the program (Similan => S, others => P). */
    public function zoneForProduct(array $zone, string $productName)
    {
        if (empty($zone['id']) || $productName === '') {
            return $zone;
        }
        $want = (mb_stripos($productName, 'สิมิลัน') !== false || stripos($productName, 'SIMILAN') !== false) ? 'S' : 'P';
        $have = self::zoneSet($zone['name']);
        if ($have === '' || $have === $want) {
            return $zone;
        }
        $base = self::zoneBase($zone['name']);
        foreach ($this->zones() as $z) {
            if ((int)$z['id'] !== (int)$zone['id'] && self::zoneSet($z['name']) === $want && self::zoneBase($z['name']) === $base) {
                return $this->validZone($z['id']);
            }
        }
        return $zone;
    }

    public function validProduct($product_id)
    {
        $product_id = (int)$product_id;
        foreach ($this->products() as $p) {
            if ((int)$p['id'] === $product_id) {
                return ['id' => $product_id, 'name' => $p['name']];
            }
        }
        return ['id' => 0, 'name' => ''];
    }

    public function matchLanguage($lang)
    {
        $lang = strtolower(trim((string)$lang));
        if ($lang === '') {
            return ['id' => 0, 'name' => ''];
        }
        foreach ($this->languages() as $l) {
            if (strtolower($l['name_eng']) === $lang) {
                return ['id' => (int)$l['id'], 'name' => $l['name_thai']];
            }
        }
        return ['id' => 0, 'name' => ''];
    }

    /** Map a country name / ISO3 code to nationalitys.id */
    public function matchNationality($name, $iso3 = '')
    {
        static $iso3Map = [
            'THA' => 'Thailand', 'CHN' => 'China', 'RUS' => 'Russian Federation', 'IND' => 'India', 'ISR' => 'Israel',
            'KAZ' => 'Kazakhstan', 'POL' => 'Republic of Poland', 'CZE' => 'Czech Republic', 'BGR' => 'Bulgaria',
            'UZB' => 'Uzbekistan', 'CAN' => 'Canada', 'USA' => 'United States of America', 'GBR' => 'United Kingdom',
            'D' => 'Germany', 'DEU' => 'Germany', 'FRA' => 'France', 'AUS' => 'Australia', 'KOR' => 'Republic of Korea',
            'JPN' => 'Japan', 'MYS' => 'Malaysia', 'SGP' => 'Singapore', 'SAU' => 'Saudi Arabia', 'ARE' => 'United Arab Emirates',
            'KWT' => 'Kuwait', 'OMN' => 'Oman', 'QAT' => 'Qatar', 'EGY' => 'Egypt', 'UKR' => 'Ukraine', 'BLR' => 'Belarus',
            'ITA' => 'Italy', 'ESP' => 'Spain', 'NLD' => 'Netherlands', 'SWE' => 'Sweden', 'NOR' => 'Norway', 'DNK' => 'Denmark',
            'FIN' => 'Finland', 'CHE' => 'Switzerland', 'AUT' => 'Austria', 'BEL' => 'Belgium', 'IRL' => 'Ireland',
            'PRT' => 'Portugal', 'TUR' => 'Turkey', 'IRN' => 'Iran', 'IDN' => 'Indonesia', 'PHL' => 'Philippines',
            'VNM' => 'Viet Nam', 'TWN' => 'Taiwan', 'HKG' => 'Hong Kong', 'NZL' => 'New Zealand', 'BRA' => 'Brazil',
            'MEX' => 'Mexico', 'ARG' => 'Argentina', 'ZAF' => 'South Africa', 'PAK' => 'Pakistan', 'BGD' => 'Bangladesh',
            'LKA' => 'Sri Lanka', 'NPL' => 'Nepal', 'MMR' => 'Myanmar', 'KHM' => 'Cambodia', 'LAO' => 'Laos',
            'KGZ' => 'Kyrgyzstan', 'TJK' => 'Tajikistan', 'ARM' => 'Armenia', 'GEO' => 'Georgia', 'AZE' => 'Azerbaijan',
            'ROU' => 'Romania', 'HUN' => 'Hungary', 'SVK' => 'Slovakia', 'SRB' => 'Serbia', 'HRV' => 'Croatia',
            'LTU' => 'Lithuania', 'LVA' => 'Latvia', 'EST' => 'Estonia', 'GRC' => 'Greece', 'JOR' => 'Jordan',
            'LBN' => 'Lebanon', 'IRQ' => 'Iraq', 'BHR' => 'Bahrain', 'MAR' => 'Morocco', 'DZA' => 'Algeria',
        ];
        static $alias = [
            'RUSSIA' => 'RUSSIAN FEDERATION', 'POLAND' => 'REPUBLIC OF POLAND', 'SOUTH KOREA' => 'REPUBLIC OF KOREA',
            'KOREA' => 'REPUBLIC OF KOREA', 'USA' => 'UNITED STATES OF AMERICA', 'UNITED STATES' => 'UNITED STATES OF AMERICA',
            'UK' => 'UNITED KINGDOM', 'ENGLAND' => 'UNITED KINGDOM', 'GREAT BRITAIN' => 'UNITED KINGDOM', 'UAE' => 'UNITED ARAB EMIRATES',
            'VIETNAM' => 'VIET NAM', 'CZECHIA' => 'CZECH REPUBLIC', 'THAI' => 'THAILAND', 'CHINESE' => 'CHINA',
            'INDIAN' => 'INDIA', 'ISRAELI' => 'ISRAEL', 'RUSSIAN' => 'RUSSIAN FEDERATION', 'LAOS' => 'LAO PEOPLE S DEMOCRATIC REPUBLIC',
            'IRAN' => 'ISLAMIC REPUBLIC OF IRAN', 'TAIWAN' => 'TAIWAN',
        ];

        $list = $this->nationalities();
        $candidates = [];
        $iso3 = strtoupper(trim((string)$iso3));
        if ($iso3 !== '' && isset($iso3Map[$iso3])) {
            $candidates[] = $iso3Map[$iso3];
        }
        if (trim((string)$name) !== '') {
            $candidates[] = (string)$name;
        }

        foreach ($candidates as $cand) {
            $key = self::normalizeName($cand);
            if (isset($alias[$key])) {
                $key = $alias[$key];
            }
            // exact
            foreach ($list as $n) {
                if (self::normalizeName($n['name']) === $key) {
                    return ['id' => (int)$n['id'], 'name' => $n['name']];
                }
            }
            // "Iran" vs "Islamic Republic of Iran", "Laos" vs "Lao ..." — whole-word containment, shortest wins
            $best = null;
            foreach ($list as $n) {
                $hay = self::normalizeName($n['name']);
                if (preg_match('/\b' . preg_quote($key, '/') . '\b/u', $hay)) {
                    if ($best === null || mb_strlen($n['name']) < mb_strlen($best['name'])) {
                        $best = $n;
                    }
                }
            }
            if ($best !== null && mb_strlen($key) >= 4) {
                return ['id' => (int)$best['id'], 'name' => $best['name']];
            }
        }
        return ['id' => 0, 'name' => ''];
    }

    public function matchExtraCharge($name)
    {
        $key = self::normalizeName((string)$name);
        if ($key === '') {
            return ['id' => 0, 'name' => ''];
        }
        $best = null;
        $bestPct = 0;
        foreach ($this->extraCharges() as $e) {
            $hay = self::normalizeName($e['name']);
            if ($hay === '') {
                continue;
            }
            if ($hay === $key || mb_strpos($key, $hay) !== false || (mb_strlen($key) >= 5 && mb_strpos($hay, $key) !== false)) {
                return ['id' => (int)$e['id'], 'name' => $e['name']];
            }
            // typos in the master list, e.g. "PAIVATE CAR" vs "PRIVATE CAR"
            similar_text($key, $hay, $pct);
            if ($pct > $bestPct) {
                $bestPct = $pct;
                $best = $e;
            }
        }
        if ($best !== null && $bestPct >= 85) {
            return ['id' => (int)$best['id'], 'name' => $best['name']];
        }
        return ['id' => 0, 'name' => ''];
    }

    public static function cleanDate($value)
    {
        $value = trim((string)$value);
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $m) || !checkdate((int)$m[2], (int)$m[3], (int)$m[1])) {
            return '';
        }
        return $value;
    }

    public static function cleanTime($value)
    {
        $value = trim((string)$value);
        if (!preg_match('/^(\d{1,2})[:.](\d{2})$/', $value, $m) || (int)$m[1] > 23 || (int)$m[2] > 59) {
            return '';
        }
        return sprintf('%02d:%02d', (int)$m[1], (int)$m[2]);
    }

    private static function paxBlock($raw)
    {
        $out = ['adult' => 0, 'child' => 0, 'infant' => 0, 'foc' => 0];
        if (is_array($raw)) {
            foreach ($out as $k => $v) {
                $out[$k] = isset($raw[$k]) ? max(0, (int)$raw[$k]) : 0;
            }
        }
        return $out;
    }

    private static function money($v)
    {
        if ($v === null || $v === '') {
            return null;
        }
        return (float)preg_replace('/[^\d.\-]/', '', str_replace(',', '', (string)$v));
    }

    /** Convert the raw AI voucher JSON into form-ready values with ids. */
    public function mapVoucher(array $d)
    {
        $s = function ($key) use ($d) {
            return isset($d[$key]) && is_scalar($d[$key]) ? trim((string)$d[$key]) : '';
        };

        $paxThai = self::paxBlock(isset($d['pax_thai']) ? $d['pax_thai'] : null);
        $paxForeign = self::paxBlock(isset($d['pax_foreign']) ? $d['pax_foreign'] : null);
        $hasThai = array_sum($paxThai) > 0;
        $hasForeign = array_sum($paxForeign) > 0;

        $transfer = in_array($s('transfer'), ['pickup', 'none', 'unknown'], true) ? $s('transfer') : 'unknown';
        $product = $this->validProduct(isset($d['product_id']) ? $d['product_id'] : 0);
        $categories = $this->matchCategories($product['id'], $hasThai, $hasForeign, $transfer !== 'none');

        $agent = $this->matchAgent($s('agent_name'));
        $pickupZone = $this->zoneForProduct($this->validZone(isset($d['pickup_zone_id']) ? $d['pickup_zone_id'] : 0), $product['name']);
        $dropoffZone = $this->zoneForProduct($this->validZone(isset($d['dropoff_zone_id']) ? $d['dropoff_zone_id'] : 0), $product['name']);
        $language = $this->matchLanguage($s('guide_language'));

        $passengers = [];
        if (!empty($d['passengers']) && is_array($d['passengers'])) {
            foreach ($d['passengers'] as $p) {
                if (!is_array($p) || empty($p['name'])) {
                    continue;
                }
                $nat = $this->matchNationality(isset($p['nationality']) ? $p['nationality'] : '');
                $type = isset($p['type']) && in_array($p['type'], ['adult', 'child', 'infant', 'foc'], true) ? $p['type'] : 'adult';
                $passengers[] = [
                    'name' => trim((string)$p['name']),
                    'type' => $type,
                    'passport_no' => isset($p['passport_no']) ? trim((string)$p['passport_no']) : '',
                    'birth_date' => self::cleanDate(isset($p['birth_date']) ? $p['birth_date'] : ''),
                    'nationality_id' => $nat['id'],
                    'nationality_name' => $nat['name'] !== '' ? $nat['name'] : (isset($p['nationality']) ? (string)$p['nationality'] : ''),
                ];
            }
        }

        $extras = [];
        if (!empty($d['extra_charges']) && is_array($d['extra_charges'])) {
            foreach ($d['extra_charges'] as $e) {
                if (!is_array($e) || empty($e['name'])) {
                    continue;
                }
                $match = $this->matchExtraCharge($e['name']);
                $extras[] = [
                    'name' => trim((string)$e['name']),
                    'amount' => (float)self::money(isset($e['amount']) ? $e['amount'] : 0),
                    'extra_charge_id' => $match['id'],
                ];
            }
        }

        $uncertain = [];
        if (!empty($d['uncertain_fields']) && is_array($d['uncertain_fields'])) {
            foreach ($d['uncertain_fields'] as $u) {
                if (is_scalar($u)) {
                    $uncertain[] = (string)$u;
                }
            }
        }
        if ($s('agent_name') !== '' && ($agent['id'] === 0 || $agent['score'] < 90)) {
            $uncertain[] = 'agent_name';
        }

        $cot = self::money(isset($d['cot']) ? $d['cot'] : null);
        $total = self::money(isset($d['total_price']) ? $d['total_price'] : null);
        $deposit = self::money(isset($d['deposit']) ? $d['deposit'] : null);
        if ($cot === null && $total !== null && $deposit !== null) {
            $cot = max(0, $total - $deposit);
        }

        return [
            'voucher_no' => $s('voucher_no'),
            'agent' => [
                'raw' => $s('agent_name'),
                'id' => $agent['id'],
                'name' => $agent['name'],
                'score' => $agent['score'],
                'candidates' => $agent['candidates'],
            ],
            'sender' => $s('sender_name'),
            'telephone' => $s('customer_phone'),
            'tour_text' => $s('tour_text'),
            'product' => $product,
            'categories' => $categories,
            'booking_type' => $s('booking_type') === 'private' ? 2 : 1,
            'travel_date' => self::cleanDate($s('travel_date')),
            'transfer' => $transfer,
            'pickup_place' => $s('pickup_place'),
            'pickup_zone' => $pickupZone,
            'dropoff_place' => $s('dropoff_place'),
            'dropoff_zone' => $dropoffZone,
            'start_pickup' => self::cleanTime($s('start_pickup')),
            'end_pickup' => self::cleanTime($s('end_pickup')),
            'room_no' => $s('room_no'),
            'language' => $language,
            'pax_thai' => $paxThai,
            'pax_foreign' => $paxForeign,
            'passengers' => $passengers,
            'total_price' => $total,
            'deposit' => $deposit,
            'cot' => $cot,
            'extra_charges' => $extras,
            'remark' => $s('remark'),
            'uncertain' => array_values(array_unique($uncertain)),
        ];
    }

    /** Convert raw passport JSON people[] into form-ready rows. */
    public function mapPassportPeople(array $d)
    {
        $people = isset($d['people']) && is_array($d['people']) ? $d['people'] : (isset($d['passport_no']) || isset($d['full_name']) ? [$d] : []);
        $out = [];
        foreach ($people as $p) {
            if (!is_array($p)) {
                continue;
            }
            $name = isset($p['full_name']) ? trim((string)$p['full_name']) : '';
            $passport = isset($p['passport_no']) ? strtoupper(preg_replace('/\s+/', '', (string)$p['passport_no'])) : '';
            if ($name === '' && $passport === '') {
                continue;
            }
            $nat = $this->matchNationality(isset($p['nationality']) ? $p['nationality'] : '', isset($p['nationality_iso3']) ? $p['nationality_iso3'] : '');
            $out[] = [
                'name' => $name,
                'passport_no' => $passport,
                'birth_date' => self::cleanDate(isset($p['birth_date']) ? $p['birth_date'] : ''),
                'nationality_id' => $nat['id'],
                'nationality_name' => $nat['name'] !== '' ? $nat['name'] : (isset($p['nationality']) ? (string)$p['nationality'] : ''),
                'sex' => isset($p['sex']) ? (string)$p['sex'] : '',
                'expiry_date' => self::cleanDate(isset($p['expiry_date']) ? $p['expiry_date'] : ''),
            ];
        }
        return $out;
    }
}
