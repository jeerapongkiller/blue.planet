<?php

/**
 * Minimal Google Drive client (OAuth refresh-token flow) using plain cURL — no composer needed.
 *
 * Booking images are linked to a booking WITHOUT touching the database: every uploaded file
 * carries Drive appProperties { bp_booking_id, bp_kind } and is found again with a Drive query.
 * Files stay private to the Drive account; staff view them through pages/booking/function/drive-file.php.
 */
class GoogleDrive
{
    private $accessToken = '';
    private $folderCacheFile;

    const FOLDER_NAME = 'Blue Planet - Booking Images';

    /** 'local' on localhost (AppServ test copy), 'prod' online — booking ids overlap, so each gets its own folder. */
    private $env;

    public function __construct()
    {
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $this->env = preg_match('/^(localhost|127\.0\.0\.1|::1)(:\d+)?$/i', $host) ? 'local' : 'prod';
        $this->folderCacheFile = __DIR__ . '/../storage/ai-scan/drive-folder-' . $this->env . '.php';
    }

    public static function isConfigured()
    {
        return defined('BP_DRIVE_CLIENT_ID') && BP_DRIVE_CLIENT_ID !== ''
            && defined('BP_DRIVE_CLIENT_SECRET') && BP_DRIVE_CLIENT_SECRET !== ''
            && defined('BP_DRIVE_REFRESH_TOKEN') && BP_DRIVE_REFRESH_TOKEN !== '';
    }

    private function request(string $method, string $url, $body = null, array $headers = [], bool $raw = false)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        if ($this->accessToken !== '') {
            $headers[] = 'Authorization: Bearer ' . $this->accessToken;
        }
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        $ctype = (string)curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        if ($resp === false || $code < 200 || $code >= 300) {
            $msg = $err !== '' ? $err : ('HTTP ' . $code);
            $decoded = json_decode((string)$resp, true);
            if (isset($decoded['error']['message'])) {
                $msg .= ' - ' . $decoded['error']['message'];
            } elseif (isset($decoded['error_description'])) {
                $msg .= ' - ' . $decoded['error_description'];
            }
            throw new Exception('Google Drive: ' . $msg);
        }
        if ($raw) {
            return ['body' => $resp, 'type' => $ctype];
        }
        return json_decode($resp, true);
    }

    public function authenticate()
    {
        if (!self::isConfigured()) {
            throw new Exception('ยังไม่ได้ตั้งค่า Google Drive (config/secrets.php)');
        }
        $token = $this->request('POST', 'https://oauth2.googleapis.com/token', http_build_query([
            'client_id' => BP_DRIVE_CLIENT_ID,
            'client_secret' => BP_DRIVE_CLIENT_SECRET,
            'refresh_token' => BP_DRIVE_REFRESH_TOKEN,
            'grant_type' => 'refresh_token',
        ]), ['Content-Type: application/x-www-form-urlencoded']);
        if (empty($token['access_token'])) {
            throw new Exception('Google Drive: ไม่ได้รับ access token');
        }
        $this->accessToken = $token['access_token'];
    }

    /** Folder that holds all Blue Planet booking images (auto-created once, id cached in storage/). */
    public function folderId()
    {
        if (defined('BP_DRIVE_FOLDER_ID') && BP_DRIVE_FOLDER_ID !== '') {
            return BP_DRIVE_FOLDER_ID;
        }
        if (is_file($this->folderCacheFile)) {
            $cache = include $this->folderCacheFile;
            if (is_array($cache) && !empty($cache['id'])) {
                return $cache['id'];
            }
        }

        $parent = defined('BP_DRIVE_PARENT_FOLDER') ? BP_DRIVE_PARENT_FOLDER : '';
        $q = "mimeType='application/vnd.google-apps.folder' and trashed=false and appProperties has { key='bp_root' and value='" . $this->env . "' }";
        $found = $this->request('GET', 'https://www.googleapis.com/drive/v3/files?' . http_build_query([
            'q' => $q,
            'fields' => 'files(id,name)',
            'supportsAllDrives' => 'true',
            'includeItemsFromAllDrives' => 'true',
        ]));
        if (!empty($found['files'][0]['id'])) {
            $id = $found['files'][0]['id'];
        } else {
            $meta = [
                'name' => self::FOLDER_NAME . ($this->env === 'local' ? ' (LOCAL TEST)' : ''),
                'mimeType' => 'application/vnd.google-apps.folder',
                'appProperties' => ['bp_root' => $this->env],
            ];
            if ($parent !== '') {
                $meta['parents'] = [$parent];
            }
            $created = $this->request(
                'POST',
                'https://www.googleapis.com/drive/v3/files?supportsAllDrives=true&fields=id',
                json_encode($meta),
                ['Content-Type: application/json']
            );
            $id = $created['id'];
        }

        $dir = dirname($this->folderCacheFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        // PHP file (returns an array) so the cache is never served as text over HTTP
        @file_put_contents($this->folderCacheFile, "<?php\nif (!defined('BP_DRIVE_CLIENT_ID')) { http_response_code(404); exit; }\nreturn " . var_export(['id' => $id], true) . ";\n");
        return $id;
    }

    /** Upload one image linked to a booking via appProperties. Returns ['id','name','link']. */
    public function uploadBookingImage(string $binary, string $mime, string $fileName, int $booking_id, string $kind)
    {
        $meta = [
            'name' => $fileName,
            'parents' => [$this->folderId()],
            'appProperties' => [
                'bp_booking_id' => (string)$booking_id,
                'bp_kind' => $kind,
            ],
        ];
        $boundary = 'bp' . md5(uniqid('', true));
        $body = "--$boundary\r\n"
            . "Content-Type: application/json; charset=UTF-8\r\n\r\n"
            . json_encode($meta) . "\r\n"
            . "--$boundary\r\n"
            . "Content-Type: $mime\r\n\r\n"
            . $binary . "\r\n"
            . "--$boundary--";

        $file = $this->request(
            'POST',
            'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart&supportsAllDrives=true&fields=id,name,webViewLink',
            $body,
            ['Content-Type: multipart/related; boundary=' . $boundary]
        );
        return ['id' => $file['id'], 'name' => $file['name'], 'link' => isset($file['webViewLink']) ? $file['webViewLink'] : ''];
    }

    /** All images uploaded for a booking (newest first). */
    public function listBookingImages(int $booking_id)
    {
        // only this environment's folder (local test ids overlap with production ids)
        $q = "'" . $this->folderId() . "' in parents and trashed=false and appProperties has { key='bp_booking_id' and value='" . (int)$booking_id . "' }";
        $res = $this->request('GET', 'https://www.googleapis.com/drive/v3/files?' . http_build_query([
            'q' => $q,
            'orderBy' => 'createdTime desc',
            'fields' => 'files(id,name,mimeType,createdTime,webViewLink,appProperties)',
            'pageSize' => 100,
            'supportsAllDrives' => 'true',
            'includeItemsFromAllDrives' => 'true',
        ]));
        $items = [];
        foreach (isset($res['files']) ? $res['files'] : [] as $f) {
            $items[] = [
                'id' => $f['id'],
                'name' => $f['name'],
                'kind' => isset($f['appProperties']['bp_kind']) ? $f['appProperties']['bp_kind'] : '',
                'created' => isset($f['createdTime']) ? date('d/m/Y H:i', strtotime($f['createdTime'])) : '',
                'link' => isset($f['webViewLink']) ? $f['webViewLink'] : '',
            ];
        }
        return $items;
    }

    /** Download a booking image; verifies it really belongs to Blue Planet (has bp_booking_id). */
    public function downloadBookingImage(string $file_id)
    {
        if (!preg_match('/^[A-Za-z0-9_-]{10,}$/', $file_id)) {
            throw new Exception('Invalid file id');
        }
        $meta = $this->request('GET', 'https://www.googleapis.com/drive/v3/files/' . $file_id . '?supportsAllDrives=true&fields=id,name,mimeType,parents,appProperties');
        if (empty($meta['appProperties']['bp_booking_id']) || !in_array($this->folderId(), isset($meta['parents']) ? $meta['parents'] : [], true)) {
            throw new Exception('File is not a booking image');
        }
        $data = $this->request('GET', 'https://www.googleapis.com/drive/v3/files/' . $file_id . '?alt=media&supportsAllDrives=true', null, [], true);
        return ['name' => $meta['name'], 'mime' => $meta['mimeType'], 'body' => $data['body']];
    }
}
