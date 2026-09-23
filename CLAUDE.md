# Tour Mate (BLUE PLANET COMPANY) — Claude Code Guidelines
> Generated from actual project analysis | PHP 8.0 + Vuexy + MySQLi | Bangkok, Thailand

---

## Project Overview

| Item | Detail |
|---|---|
| System Name | Tour Mate |
| Purpose | Tour Operations Management System |
| Server | XAMPP, PHP 8.0, MariaDB 10.4 |
| Timezone | Asia/Bangkok |
| UI Template | Vuexy Admin Dashboard (Bootstrap 4/5 + Feather Icons) |
| Entry Point | `index.php?pages=module/action` |

---

## Architecture

### Routing Pattern
```
No framework routing — all requests go through:
index.php?pages=booking/list
index.php?pages=car-center/list
index.php?pages=invoice/create
```

### Folder Structure
```
tourmate-ai/
├── index.php              # Main entry point + routing
├── cn.php                 # Global config: DB, API keys, helper functions
├── config/env.php         # App config (name, URL, company info)
├── webhook.php            # LINE webhook handler
├── composer.json          # Dependencies (google/apiclient)
│
├── controllers/           # Business logic (MVC Controller)
│   ├── DB.php             # Base DB class (MySQLi)
│   ├── Auth.php
│   ├── Booking.php
│   ├── Invoice.php
│   └── [Other controllers...]
│
├── pages/                 # Feature pages (MVC View)
│   └── [module]/
│       ├── list.php       # List view
│       ├── create.php     # Create form
│       ├── edit.php       # Edit form
│       ├── print-*.php    # Print/export pages
│       └── function/      # AJAX endpoints (backend API)
│           ├── create.php
│           ├── edit.php
│           └── delete.php
│
├── layouts/               # Layout templates
│   └── [feature]/
│       └── [action]-main.php   # Layout wrapper per feature
│
├── app-assets/            # Vuexy template assets (DO NOT MODIFY)
├── assets/                # Custom CSS/SCSS/JS
├── database/              # SQL schema dump
└── storage/               # File uploads
```

### Layout Convention (MUST FOLLOW)
```
Every page uses this 2-file pattern:

layouts/[feature]/[action]-main.php   ← Layout wrapper (include header/footer/menu)
pages/[feature]/[action].php          ← Content + CSS + JavaScript

Example:
layouts/booking/create-main.php
pages/booking/create.php
```

---

## Language & Communication

- **Reply in Thai** for all explanations and comments
- **Code and variable names in English**
- **Inline comments in English**
- **UI strings in Thai** (matching existing system language)
- If unsure about requirements → ASK before writing code

---

## PHP Guidelines

### Database: Always Use MySQLi Prepared Statements

```php
// ✅ Correct — prepared statement (MUST USE)
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND status = ?");
$stmt->bind_param("is", $booking_id, $status);
$stmt->execute();
$result = $stmt->get_result();

// ❌ NEVER — SQL injection risk
$result = $conn->query("SELECT * FROM bookings WHERE id = " . $_GET['id']);
```

> ⚠️ Some older controllers still use raw MySQLi — when touching them, migrate to prepared statements.

### Use DB.php Base Class
```php
// ✅ Correct — use existing DB.php base class
class Booking extends DB {
    public function getBooking($id) {
        $stmt = $this->conn->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

// ❌ Don't — create new raw connections
$conn = new mysqli("localhost", "root", "", "love.andaman");
```

### Sanitize All Input
```php
// ✅ Always sanitize
$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
$id   = (int) $_POST['id'];
$date = date('Y-m-d', strtotime($_POST['date']));

// For AJAX endpoints in function/ folder
$input = json_decode(file_get_contents('php://input'), true);
$booking_id = (int)($input['booking_id'] ?? 0);
if (!$booking_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid booking ID']);
    exit;
}
```

### AJAX Endpoints Pattern (pages/[module]/function/)
```php
<?php
// Standard AJAX response pattern
header('Content-Type: application/json');
session_start();

require_once '../../../cn.php';
require_once '../../../controllers/Booking.php';

$booking = new Booking();
$input = json_decode(file_get_contents('php://input'), true);

try {
    $result = $booking->createBooking($input);
    echo json_encode(['success' => true, 'data' => $result]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
```

---

## CSS Guidelines (in pages/ files)

### Placement: `<style>` block BEFORE HTML content
```php
<?php
// PHP logic first
$bookings = $bookingCtrl->getAll();
?>

<!-- CSS: page-specific styles only -->
<style>
/* Use BEM naming: .block__element--modifier */
.booking-list { }
.booking-list__card { }
.booking-list__card--pending { background: #fff3cd; }
.booking-list__card--confirmed { background: #d4edda; }

@media (max-width: 768px) {
    .booking-list__card { padding: 10px; }
}
</style>

<!-- HTML content follows -->
```

### CSS Rules
```
Priority order:
1. Vuexy Bootstrap classes first (card, btn, badge, table, etc.)
2. Shared styles from assets/css/style.css second
3. Custom page-specific CSS third
4. Inline styles — last resort only

✅ Use: .card, .btn-primary, .badge-success, .table-striped (Vuexy)
❌ Don't: Override Vuexy base styles
❌ Don't: Use !important unless unavoidable
❌ Don't: Write CSS that affects other pages
```

---

## CSS Management (Shared Styles)

### Single Source of Truth
```
assets/css/style.css  ← Shared styles สำหรับทุก page
```

### Workflow: MUST Follow Every Time

**ก่อนเขียน CSS ใหม่ทุกครั้ง — ทำตามลำดับนี้:**

```
Step 1: อ่าน assets/css/style.css ก่อนเสมอ
Step 2: ตรวจสอบว่ามี class ที่ต้องการแล้วหรือยัง
Step 3A: มีแล้ว → ใช้ class นั้นโดยตรง (ห้ามสร้างซ้ำ)
Step 3B: ยังไม่มี → ตัดสินใจว่าควรไปอยู่ที่ไหน

          ใช้หลายหน้า?
          ├── ใช่ → เพิ่มใน assets/css/style.css
          └── ไม่ใช่ → เขียนใน <style> tag ของหน้านั้น
```

### เมื่อเพิ่มเข้า style.css

```css
/* assets/css/style.css */

/* ✅ เพิ่มใน section ที่เกี่ยวข้อง พร้อม comment */

/* === Status Badges === */
.status-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; }
.status-badge--confirmed  { background: #d4edda; color: #155724; }
.status-badge--pending    { background: #fff3cd; color: #856404; }
.status-badge--cancelled  { background: #f8d7da; color: #721c24; }
.status-badge--completed  { background: #cce5ff; color: #004085; }

/* === Layout Helpers === */
.flex-center  { display: flex; justify-content: center; align-items: center; }
.flex-between { display: flex; justify-content: space-between; align-items: center; }
.grid-2col    { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.grid-3col    { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

/* === Table Enhancements === */
.table-row-hover tr:hover { background-color: #f5f5f5; cursor: pointer; }
.table-compact td, .table-compact th { padding: 6px 10px; }

/* === Print Utilities === */
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
}
```

### เมื่อเขียนใน Page `<style>` tag

ใช้ **namespace prefix = ชื่อ module** เพื่อป้องกัน conflict:

```css
/* pages/booking/list.php */
<style>
/* Prefix: booking__ */
.booking__card              { border-left: 4px solid #007bff; }
.booking__card--vip         { border-left-color: #ffc107; }
.booking__pax-badge         { font-weight: bold; color: #007bff; }
.booking__flag              { width: 20px; height: 14px; margin-right: 4px; }
</style>

/* pages/car-center/list.php */
<style>
/* Prefix: car-center__ */
.car-center__vehicle-row    { background: #f8f9fa; border-radius: 6px; }
.car-center__pax-count      { font-size: 1.1rem; font-weight: bold; }
.car-center__route--depart  { border-left: 3px solid #28a745; }
.car-center__route--return  { border-left: 3px solid #dc3545; }
</style>
```

### Conflict Prevention Rules

```
✅ Safe — ไม่ชน:
  .booking__card          (namespaced)
  .invoice__total-row     (namespaced)
  .car-center__pax        (namespaced)

❌ Risky — อาจชน:
  .card                   (ซ้ำกับ Vuexy)
  .active                 (ซ้ำกับ Bootstrap)
  .table-row              (generic เกินไป)
  .status                 (generic เกินไป)

❌ NEVER:
  Override .card, .btn-*, .table-*, .badge-* (Vuexy core)
```

### ตรวจสอบก่อน Commit

```bash
# ค้นหา class ที่ซ้ำกันระหว่าง style.css กับ page files
grep -r "^\." assets/css/style.css | cut -d'{' -f1 | sort > /tmp/shared.txt
grep -rh "^\." pages/ --include="*.php" | cut -d'{' -f1 | sort > /tmp/pages.txt
comm -12 /tmp/shared.txt /tmp/pages.txt
# ถ้ามีผลลัพธ์ = มี duplicate → ต้องแก้ไข
```

### Module Prefix Reference

```
booking__        pages/booking/
car-center__     pages/car-center/
boat-center__    pages/boat-center/
invoice__        pages/invoice/
receipt__        pages/receipt/
quotation__      pages/quotation/
dashboard__      pages/dashboard/
daily-brief__    pages/daily-brief/
order__          pages/order-*/
driver__         pages/manage-driver/
boat__           pages/manage-boat/
```

---

## JavaScript Guidelines (in pages/ files)

### Placement: `<script>` block AFTER HTML content
```php
<!-- HTML content -->
<div id="booking-list">...</div>

<!-- JS: page-specific logic at bottom -->
<script>
$(document).ready(function() {
    initPage();
    setupEvents();
});

function initPage() {
    // Initialize components
    feather.replace(); // Initialize Feather Icons
    $('.select2').select2(); // Initialize Select2
}

function setupEvents() {
    // Event listeners
    $(document).on('click', '.btn-delete', handleDelete);
    $(document).on('change', '#hotel-select', handleHotelChange);
}

function handleDelete() {
    const id = $(this).data('id');
    if (!confirm('ต้องการลบรายการนี้?')) return;

    $.ajax({
        url: 'pages/[module]/function/delete.php',
        method: 'POST',
        data: JSON.stringify({ id: id }),
        contentType: 'application/json',
        success: function(res) {
            if (res.success) {
                toastr.success('ลบเรียบร้อยแล้ว');
                location.reload();
            } else {
                toastr.error(res.message);
            }
        },
        error: function() {
            toastr.error('เกิดข้อผิดพลาด กรุณาลองใหม่');
        }
    });
}
</script>
```

### JavaScript Rules
```
✅ Use:
- jQuery (already loaded via Vuexy)
- $.ajax() for AJAX calls
- feather.replace() after dynamic DOM changes
- Select2 for dropdowns
- toastr for notifications
- ES6+ (const, let, arrow functions, template literals)

❌ Don't:
- Use var (use const/let)
- Inline onclick handlers → use $(document).on()
- Missing error handling on AJAX calls
- console.log() in production code
```

### Passing PHP Data to JavaScript
```php
<!-- ✅ Safe: use json_encode -->
<script>
const bookingData = <?php echo json_encode($booking); ?>;
const config = {
    apiUrl: '<?php echo APP_URL; ?>',
    csrfToken: '<?php echo $_SESSION['csrf_token']; ?>'
};
</script>

<!-- ❌ Never: direct echo in JS -->
<script>
const id = <?php echo $_GET['id']; ?>; // XSS risk!
</script>
```

---

## Frontend Components (Vuexy)

### Icons: Use Feather Icons
```html
<!-- ✅ Feather Icons (call feather.replace() after) -->
<i data-feather="edit"></i>
<i data-feather="trash-2"></i>
<i data-feather="plus"></i>

<!-- Also available: FontAwesome -->
<i class="fas fa-flag-usa"></i>   <!-- US flag -->
<i class="fas fa-flag"></i>       <!-- Thai flag -->
```

### Dropdowns: Always Use Select2
```html
<select class="form-control select2" id="hotel-select">
    <option value="">-- เลือกโรงแรม --</option>
    <?php foreach($hotels as $h): ?>
        <option value="<?php echo $h['id']; ?>"><?php echo htmlspecialchars($h['name']); ?></option>
    <?php endforeach; ?>
</select>

<script>
$('#hotel-select').select2({ placeholder: 'ค้นหาโรงแรม...' });
</script>
```

### Standard Table Pattern
```html
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">รายการ Booking</h4>
        <a href="?pages=booking/create" class="btn btn-primary">
            <i data-feather="plus"></i> เพิ่มใหม่
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ชื่อลูกค้า</th>
                        <th>วันที่</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['travel_date'])); ?></td>
                        <td><span class="badge badge-<?php echo $row['status_class']; ?>"><?php echo $row['status_label']; ?></span></td>
                        <td>
                            <a href="?pages=booking/edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                <i data-feather="edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="<?php echo $row['id']; ?>">
                                <i data-feather="trash-2"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
```

---

## API Integrations

### 1. LINE Messaging API
```php
// Webhook handler: webhook.php
// ✅ Always verify signature first
$signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];
$body = file_get_contents('php://input');
$hash = base64_encode(hash_hmac('sha256', $body, LINE_CHANNEL_SECRET, true));

if (!hash_equals($hash, $signature)) {
    http_response_code(400);
    exit('Invalid signature');
}

// Parse events
$events = json_decode($body, true)['events'];
foreach ($events as $event) {
    // Handle message / image events
}
```

### 2. Google Gemini Vision API (Core AI Feature)
```php
// Use existing checkImageIsVoucher() in cn.php
// DO NOT recreate this function

$result = checkImageIsVoucher($image_base64);
// Returns: is_voucher, voucher_no, customer_name, travel_date, pax, tour_name

// Always handle failure cases
if (!$result['is_voucher']) {
    // Not a voucher — handle gracefully
}
```

### 3. Google Maps APIs
```php
// Existing patterns in pages/booking/function/
// search-address.php  → Places Autocomplete
// get-coords.php      → Geocoding

// JS pattern for address search
$('#hotel-input').on('input', function() {
    const query = $(this).val();
    $.get('pages/booking/function/search-address.php', { q: query }, function(res) {
        // Show suggestions
    });
});
```

### 4. API Keys Security
```
⚠️ CURRENT ISSUE: API keys stored directly in cn.php

When touching cn.php:
- DO NOT commit API keys to Git
- Suggest migration to config/env.php
- Add cn.php to .gitignore if not already

Future: migrate to $_ENV or getenv()
```

---

## Database Guidelines

### Connection
```php
// ✅ Use DB.php base class
require_once '../../controllers/DB.php';
$db = new DB(); // or extend in controller

// DB names:
// Local:      love.andaman
// Production: dbbwxpwydehjr5
```

### Key Table Groups
```
Booking:   bookings, booking_products, booking_special_requests
Fleet:     boats, cars, boat_types, car_categories
Personnel: drivers, captains, crews, guides
Financial: invoices, receipts, quotations, payments
Location:  hotels, zones, provinces, parks
LINE:      line_booking_requests, line_booking_images
Users:     users, agents, permissions
```

### Date Handling (Thailand Context)
```php
// ✅ Always use Thai timezone
date_default_timezone_set('Asia/Bangkok');

// Display format: Thai style
echo date('d/m/Y', strtotime($date));  // 25/05/2568

// Store format: MySQL standard
$store_date = date('Y-m-d'); // 2025-05-25

// Buddhist year display (when needed)
$thai_year = date('Y') + 543;
```

### Financial Calculations
```php
// ✅ VAT = 7%
$subtotal    = $amount / 1.07;           // extract from VAT-inclusive price
$vat_amount  = $amount - $subtotal;
$total       = $subtotal + $vat_amount;

// ✅ Withholding Tax (หัก ณ ที่จ่าย) = 1% or 3%
$wht_rate    = 0.01; // or 0.03
$wht_amount  = $subtotal * $wht_rate;
$net_payment = $total - $wht_amount;

// ✅ Discount
// Type: 'baht' or 'percent'
if ($discount_type === 'percent') {
    $discount_amount = $subtotal * ($discount_value / 100);
} else {
    $discount_amount = $discount_value;
}

// ✅ Park fees: Thai vs English tourist pricing
$park_fee = ($nationality === 'thai') ? $thai_price : $foreign_price;
```

---

## Business Logic Rules

### Booking Types
```
Join    = Group tour, multiple customers share transport
Private = Exclusive booking for one customer/group
```

### Booking Status Flow
```
draft → confirmed → in_progress → completed
                 → cancelled
                 → no_show
```

### Booking Pricing Components
```
Base price
+ Park fees (Thai/Foreign rate)
+ Extra services
- Discount (Baht or %)
= Subtotal
+ VAT 7% (if applicable)
- WHT (if applicable)
= Net total
```

### Car Center Logic
```
Pages: pages/car-center/
- ขาไป (Departure): hotel pickup → tour departure point
- ขากลับ (Return): tour end point → hotel dropoff
- PAX display: show passenger count per vehicle
- Flag icons: Thai flag / Foreign flag for nationality
```

### Personnel Assignment
```
Driver     → assigned to car jobs
Captain    → assigned to boat
Crew       → assists captain on boat
Guide      → accompanies tour group
```

---

## Security Rules

### Input Validation (MANDATORY)
```php
// Every AJAX endpoint must validate:
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Check session
if (!isset($_SESSION['supplier'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Validate required fields
$required = ['booking_id', 'customer_name', 'travel_date'];
foreach ($required as $field) {
    if (empty($input[$field])) {
        echo json_encode(['success' => false, 'message' => "Missing: $field"]);
        exit;
    }
}
```

### Output Encoding (MANDATORY)
```php
// ✅ Always encode output
echo htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');

// ✅ Safe JSON for JS
const data = <?php echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
```

### Session Auth Check
```php
// Include at top of every protected page
session_start();
if (!isset($_SESSION['supplier'])) {
    header('Location: index.php?pages=authentication/login');
    exit;
}
$current_user = $_SESSION['supplier'];
```

---

## Print Pages Pattern

```php
// pages/[module]/print-invoice.php
// Print pages are standalone — no layout wrapper needed

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $invoice['number']; ?></title>
    <style>
        /* Print-specific CSS */
        @media print {
            .no-print { display: none; }
        }
        body { font-family: 'Sarabun', sans-serif; }
    </style>
</head>
<body>
    <!-- Invoice content -->
    <button onclick="window.print()" class="no-print btn btn-primary">พิมพ์</button>
</body>
</html>
```

---

## Creating New Module (Step-by-Step)

When asked to create a new module (e.g., "create transfer management"):

```
1. Controllers: controllers/Transfer.php  (extends DB)
2. Pages:
   pages/transfer/list.php
   pages/transfer/create.php
   pages/transfer/edit.php
   pages/transfer/function/create.php
   pages/transfer/function/edit.php
   pages/transfer/function/delete.php
3. Layout:
   layouts/transfer/list-main.php
   layouts/transfer/create-main.php
   layouts/transfer/edit-main.php
4. Database:
   CREATE TABLE transfers (...)
5. Menu: Add to main-menu in layouts/
```

---

## What NOT to Do

```
❌ Never modify app-assets/ (Vuexy core files)
❌ Never use raw MySQLi without prepared statements
❌ Never echo user input without htmlspecialchars()
❌ Never store sensitive data (passwords) in plain text
❌ Never commit API keys (cn.php has LINE/Gemini/Google keys)
❌ Never create duplicate DB connections — use DB.php
❌ Never break existing URL patterns (?pages=module/action)
❌ Never add features to booking/invoice/receipt without testing accuracy
```

---

## Priority Order

When making decisions, prioritize:

```
1. Data Accuracy   — booking, invoice, receipt ต้องแม่นยำ 100%
2. Security        — sanitize, prepared statements, session checks
3. Thai UX         — Thai language, Thai date format, Thai baht
4. Mobile Support  — ผู้ใช้บางส่วนใช้ phone
5. Vuexy Consistency — ใช้ Vuexy components ให้ consistent
6. Performance     — optimize เมื่อจำเป็นเท่านั้น
```

---

## When Uncertain

```
- ไม่แน่ใจ business logic (เช่น discount calculation) → ถามก่อน
- ไม่แน่ใจ database relationship → ดู schema ก่อน
- ไม่แน่ใจ Vuexy component → ดู app-assets/ ก่อน
- แก้ core workflow (booking, invoice, LINE) → แจ้งก่อนทุกครั้ง
```

---

## Quick Reference

```
Entry point  : index.php?pages=[module]/[action]
Global config: cn.php (DB + API keys + helpers)
App config   : config/env.php
DB class     : controllers/DB.php
Auth check   : $_SESSION['supplier']
DB local     : love.andaman
DB production: dbbwxpwydehjr5
Timezone     : Asia/Bangkok
Icons        : Feather Icons + FontAwesome
Dropdowns    : Select2
Notifications: toastr
Charts       : Vuexy built-in (ApexCharts)
Excel export : PHPSpreadsheet
Email        : PHPMailer
```
