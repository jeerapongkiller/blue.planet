<?php
require_once 'controllers/Booking.php';

$bookObj = new Booking();
$today = date("Y-m-d");
$times = date("H:i:s");

if (!empty($_GET['id']) && $_GET['id'] > 0) {
    $get_bo_full = $bookObj->get_value('bo_full', 'bookings_no', $_GET['id']);
    function cal_date_diff($date1, $date2)
    {
        $a = date_create($date1);
        $b = date_create($date2);
        $diff = date_diff($a, $b);
        $day_diff_inv =  $diff->format("%R%a");
        $num_diff_inv =  $diff->format("%a");

        return $day_diff_inv;
    }
    $account = '';
} else {
    header('location:./?pages=booking/list');
}
?>
<div class="close_status">
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Booking</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./?pages=booking/list" class="btn-page-block-spinner">Booking List</a></li>
                                    <li class="breadcrumb-item active"><?php echo $get_bo_full['bo_full']; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- Vertical Wizard -->
                <section class="horizontal-wizard">
                    <div class="bs-stepper horizontal-wizard-example">
                        <div class="bs-stepper-header">
                            <div class="step" data-target="#booking-preview-vertical">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">1</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Preview</span>
                                        <span class="bs-stepper-subtitle">Please fill out</span>
                                    </span>
                                </button>
                            </div>
                            <div class="step" data-target="#program-details-vertical">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-box">2</span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-title">Program Details</span>
                                        <span class="bs-stepper-subtitle">Please fill out</span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content">
                            <!-- Booking Preview Vertical -->
                            <div id="booking-preview-vertical" class="content">
                                <?php
                                include 'inc-print.php';
                                if ($bp_id > 0) { ?>
                                    <a href="./?pages=booking/print&id=<?php echo $bo_id; ?>" target="_blank"><button class="btn btn-info" id="print-btn">Print</button></a>
                                    <button class="btn btn-info" id="email-btn" onclick='sendemail("click");' hidden>Send E-Mail</button>
                                    <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="download_image('voucher');">Image</button></a>
                                    <a href="./?pages=booking/download&id=<?php echo $bo_id; ?>" target="_blank" hidden><button class="btn btn-info" id="clickbind">Download as PDF</button></a>
                                    <a href="javascript:void(0)"><button type="button" class="btn btn-info" value="image" onclick="sendline();" hidden>Send Line</button></a>
                                    <div id="div-email"></div>
                                <?php } ?>
                            </div>
                            <!-- Programs Detail Vertical -->
                            <div id="program-details-vertical" class="content">
                                <form id="booking-edit-form" name="booking-edit-form" method="post" enctype="multipart/form-data">
                                    <!-- Start Form Booking Detail -->
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Booking Detail</h5>
                                        </div>
                                        <div class="card-body mt-2">
                                            <input type="hidden" id="bo_id" name="bo_id" value="<?php echo $bo_id; ?>">
                                            <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>">
                                            <input type="hidden" id="book_type_id" name="book_type_id" value="<?php echo $book_type; ?>">
                                            <input type="hidden" id="book_full" name="book_full" value="<?php echo $book_full; ?>">
                                            <input type="hidden" id="open-rates" name="open_rates" value="<?php echo $open_rates; ?>" />
                                            <input type="hidden" name="mange_transfer_id" value="<?php echo $mange_transfer_id; ?>" /> <!-- manage transfer booking id -->
                                            <input type="hidden" name="mange_transfer" value="<?php echo $mange_transfer; ?>" /> <!-- manage transfer id -->
                                            <input type="hidden" name="mange_boat_id" value="<?php echo $mange_boat_id; ?>" /> <!-- manage boat booking id -->
                                            <input type="hidden" name="mange_boat" value="<?php echo $mange_boat; ?>" /> <!-- manage boat id -->
                                            <input type="hidden" name="confirm_id" value="<?php echo $confirm_id; ?>" /> <!-- confirm agent id -->
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="booking_no">Booking No.</label>
                                                    <div class="input-group">
                                                        <p><?php echo $book_full; ?></p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="booking_date">Booking Date</label>
                                                    <div class="input-group">
                                                        <p><?php echo date('j F Y', strtotime($book_date)); ?></p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="customer_type">Booking Type</label>
                                                    <?php
                                                    $books_type = $bookObj->show_booking_type();
                                                    foreach ($books_type as $type) {
                                                        $checked_book = $type['id'] == $book_type ? 'checked' : '';
                                                    ?>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="<?php echo 'booktype' . $type['id']; ?>" name="booking_type_id" class="custom-control-input customer_type" value="<?php echo $type['id']; ?>" <?php echo $checked_book; ?> onchange="check_date();" />
                                                            <label class="custom-control-label" for="<?php echo 'booktype' . $type['id']; ?>"><?php echo $type['name']; ?></label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group" id="frm-agent">
                                                        <label for="agent">Agent (เอเยนต์)</label>
                                                        <select class="form-control select2" id="agent" name="agent" onchange="search_program();">
                                                            <option value="0">Please Select Agent...</option>
                                                            <option value="outside">กรอกข้อมูลเพิ่มเติม</option>
                                                            <?php
                                                            $agents = $bookObj->show_agent();
                                                            foreach ($agents as $agent) {
                                                                $selected_agent = $agent['id'] == $agent_id ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $agent['id']; ?>" <?php echo $selected_agent; ?>><?php echo $agent['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="frm-agent-outside" hidden>
                                                        <label for="agent_outside">Agent</label>
                                                        <input type="text" class="form-control" id="agent_outside" name="agent_outside" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label for="book_status">Booking Status</label>
                                                        <select class="form-control select2" id="book_status" name="book_status" onchange="check_charge(this);">
                                                            <?php
                                                            $bookstype = $bookObj->show_booking_status();
                                                            foreach ($bookstype as $booktype) {
                                                            ?>
                                                                <option value="<?php echo $booktype['id']; ?>" <?php echo $book_status == $booktype['id'] ? 'selected' : ''; ?>><?php echo $booktype['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3" id="div-rates-charge" hidden>
                                                    <div class="form-group">
                                                        <label class="form-label" for="rates_charge">Rates Charge</label>
                                                        <input type="text" class="form-control numeral-mask" id="rates_charge" name="rates_charge" value="<?php echo number_format($rates['rate_total'][0]); ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="voucher_no_agent">Voucher No. (Agent)</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="voucher_no_agent" name="voucher_no_agent" value="<?php echo $voucher_no_agent; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="sender">Sender</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="sender" name="sender" value="<?php echo $sender; ?>">
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group col-md-3">
                                                    <input type="hidden" id="cus_id" name="cus_id" value="<?php echo !empty($customers['cus_id'][0]) ? $customers['cus_id'][0] : 0; ?>">
                                                    <label for="cus_name">Customer Name</label>
                                                    <input type="text" class="form-control" id="cus_name" name="cus_name" value="<?php echo !empty($customers['name'][0]) ? $customers['name'][0] : ''; ?>" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="cus_telephone">Telephone</label>
                                                    <input type="text" class="form-control" id="cus_telephone" name="cus_telephone" value="<?php echo !empty($customers['telephone'][0]) ? $customers['telephone'][0] : ''; ?>" />
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Detail -->
                                    <!-- Start Form Booking Product Detail -->
                                    <div id="div-show"></div>
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Program Detail</h5>
                                        </div>
                                        <div class="card-body mt-2">
                                            <input type="hidden" id="customer_thai" name="customer_thai" value="0" />
                                            <input type="hidden" id="customer_foreign" name="customer_foreign" value="0" />
                                            <input type="hidden" id="pror_id" name="pror_id" value="" />
                                            <input type="hidden" id="bo_id" name="bo_id" value="<?php echo $bo_id; ?>">
                                            <input type="hidden" id="bp_id" name="bp_id" value="<?php echo $bp_id; ?>">
                                            <!-- <input type="hidden" id="bpr_id" name="bpr_id" value="<?php echo $bpr_id; ?>"> -->
                                            <input type="hidden" id="bpr_id" name="bpr_id" value="<?php echo $rates['id'][0]; ?>">
                                            <input type="hidden" id="bt_id" name="bt_id" value="<?php echo $bt_id; ?>">
                                            <input type="hidden" id="btr_id" name="btr_id" value="<?php echo $btr_id; ?>">
                                            <input type="hidden" id="bopa_id" name="bopa_id" value="<?php echo $bopa_id; ?>">
                                            <input type="hidden" id="bopae_id" name="bopae_id" value="<?php echo $bopae_id; ?>">
                                            <input type="hidden" id="search_travel" name="search_travel" value="<?php echo !empty($_GET['search_travel']) ? $_GET['search_travel'] : ''; ?>">
                                            <input type="hidden" id="search_agent" name="search_agent" value="<?php echo !empty($_GET['search_agent']) ? $_GET['search_agent'] : ''; ?>">
                                            <!-- get value default  -->
                                            <input type="hidden" id="prod_id" name="prod_id" value="<?php echo $product_id; ?>">
                                            <!-- <input type="text" id="cate_id" name="cate_id" value="<?php echo json_encode($rates['category'], true); ?>"> -->
                                            <input type="hidden" id="travel" name="travel" value="<?php echo $travel_date; ?>">
                                            <input type="hidden" id="bpr_array" name="bpr_array" value='<?php echo json_encode($rates); ?>'>
                                            <input type="hidden" id="cate_id" name="cate_id" value="<?php echo $category_id; ?>">
                                            <input type="hidden" id="prod_rate_id" name="prod_rate_id" value="<?php echo $prod_rate_id; ?>">
                                            <input type="hidden" id="rate_ad" value="<?php echo $rates['rate_adult'][0]; ?>">
                                            <input type="hidden" id="rate_chd" value="<?php echo $rates['rate_child'][0]; ?>">
                                            <input type="hidden" id="rate_int" value="<?php echo $rates['rate_infant'][0]; ?>">
                                            <input type="hidden" id="rate_tt" value="<?php echo $rates['rate_total'][0]; ?>">
                                            <div class="row">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="travel_date">Travel Date</label><br>
                                                        <input type="text" class="form-control" id="travel_date" name="travel_date" value="<?php echo $travel_date; ?>" onchange="search_program();" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="product_id">Programe</label>
                                                        <select class="form-control select2" id="product_id" name="product_id" onchange="search_program();">
                                                            <?php
                                                            $prods = $bookObj->show_product();
                                                            foreach ($prods as $prod) {
                                                                $selected_prod = $prod['id'] == $product_id ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $prod['id']; ?>" <?php echo $selected_prod; ?>><?php echo $prod['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="category_id">Categorys</label>
                                                        <select class="form-control select2" id="category_id" name="category_id" onchange="check_category();">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 col-12">
                                                    <label for="language_id">ภาษา (ไกด์)</label>
                                                    <select class="form-control select2" id="language_id" name="language_id">
                                                        <option value="0">เลือกภาษา</option>
                                                        <?php
                                                        $languages = $bookObj->showlanguages();
                                                        foreach ($languages as $language) {
                                                            $selected = $language['id'] == $lang_id ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $language['id']; ?>" <?php echo $selected; ?>><?php echo $language['name_thai']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="form-group col-md-3 col-12">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="adult">Adult (ผู้ใหญ่)</label>
                                                                    <input type="text" class="form-control numeral-mask" id="adult" name="adult" oninput="duplicate_pax('adult');" value="<?php echo array_sum($rates['adult']); ?>" />
                                                                </div>
                                                            </td>
                                                            <td class="td-x"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td id="td-adult">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_adult">Rate Adult (ราคาผู้ใหญ่)</label>
                                                                    <input type="text" id="rate_adult" name="rate_adult" class="form-control numeral-mask" oninput="check_rate();" value="<?php echo array_sum(['rate_adult']); ?>">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="form-group col-md-3 col-12">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="child">Children (เด็ก)</label>
                                                                    <input type="text" class="form-control numeral-mask" id="child" name="child" oninput="duplicate_pax('child');" value="<?php echo array_sum($rates['child']); ?>" />
                                                                </div>
                                                            </td>
                                                            <td class="td-x"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td id="td-child">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_child">Rate Children (ราคาเด็ก)</label>
                                                                    <input type="text" id="rate_child" name="rate_child" class="form-control numeral-mask" value="<?php echo array_sum($rates['rate_child']); ?>" oninput="check_rate();">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="form-group col-md-3 col-12">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="infant">Infant (ทารก)</label>
                                                                    <input type="text" class="form-control numeral-mask" id="infant" name="infant" oninput="duplicate_pax('infant');" value="<?php echo array_sum($rates['infant']); ?>" />
                                                                </div>
                                                            </td>
                                                            <td class="td-x"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td id="td-infant">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_infant">Rate Infant (ราคาทารก)</label>
                                                                    <input type="text" id="rate_infant" name="rate_infant" class="form-control numeral-mask" value="<?php echo array_sum($rates['rate_infant']); ?>" oninput="check_rate();">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="form-group col-md-1 col-12">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="foc">FOC</label>
                                                                    <input type="text" class="form-control numeral-mask" id="foc" name="foc" oninput="duplicate_pax('infant');" value="<?php echo array_sum($rates['foc']); ?>" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="bp_note">Program (Tour Detail)</label>
                                                        <textarea class="form-control" name="bp_note" id="bp_note" rows="3"><?php echo $bp_note; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-2 col-12">
                                                    <label class="form-label" for="cot">COT</label>
                                                    <input type="text" class="form-control numeral-mask" id="cot" name="cot" value="<?php echo !empty($cot) ? $cot : 0; ?>" />
                                                    <input type="hidden" id="cot_id" name="cot_id" value="<?php echo !empty($cot_id) ? $cot_id : 0; ?>" />
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <div class="form-group">
                                                        <label class="form-label" for="discount">Discount (ส่วนลด)</label>
                                                        <input type="text" class="form-control numeral-mask" id="discount" name="discount" value="<?php echo number_format($discount); ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4" id="div-total">
                                                    <div class="form-group">
                                                        <label class="form-label" for="rate_total">Total Price (Program)</label>
                                                        <input type="text" class="form-control numeral-mask" id="rate_total" name="rate_total" onchange="check_rate('input');" value="<?php echo number_format($rate_total); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Product Detail -->
                                    <!-- Start Form Customer Detail -->
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Customers Detail</h5>
                                        </div>
                                        <div class="card-body mt-2">
                                            <div class="itinerary-repeater">
                                                <div data-repeater-list="itinerary">
                                                    <?php if ($customers) {
                                                        for ($i = 0; $i < count($customers['cus_id']); $i++) { ?>
                                                            <input type="hidden" name="before_cus_id[]" value="<?php echo $customers['cus_id'][$i]; ?>">
                                                            <div data-repeater-item>
                                                                <input type="hidden" name="cus_id" value="<?php echo $customers['cus_id'][$i]; ?>">
                                                                <input type="hidden" name="head" value="<?php echo $customers['head'][$i]; ?>">
                                                                <div class="row d-flex align-items-start">
                                                                    <div class="col-md-1 col-12">
                                                                        <div class="form-group">
                                                                            <label for="age">ผู้ใหญ่/เด็ก/ทารก</label>
                                                                            <select class="form-control" name="cus_age">
                                                                                <option value=""></option>
                                                                                <option value="1" <?php echo $customers['cus_age'][$i] == 1 ? 'selected' : ''; ?>>Adult</option>
                                                                                <option value="2" <?php echo $customers['cus_age'][$i] == 2 ? 'selected' : ''; ?>>Child</option>
                                                                                <option value="3" <?php echo $customers['cus_age'][$i] == 3 ? 'selected' : ''; ?>>Infant</option>
                                                                                <option value="3" <?php echo $customers['cus_age'][$i] == 4 ? 'selected' : ''; ?>>FOC</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12">
                                                                        <div class="form-group">
                                                                            <label for="id_card">ID Passport/ ID Card</label>
                                                                            <input type="text" class="form-control" name="id_card" aria-describedby="id_card" value="<?php echo $customers['id_card'][$i] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12">
                                                                        <div class="form-group">
                                                                            <label for="name">Name</label>
                                                                            <input type="text" class="form-control" name="cus_name" aria-describedby="name" value="<?php echo $customers['name'][$i] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12">
                                                                        <div class="form-group">
                                                                            <label for="birth_date">Birth Date</label>
                                                                            <input type="date" class="form-control birth-date" name="cus_birth_date" aria-describedby="birth_date" value="<?php echo $customers['birth_date'][$i] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12">
                                                                        <div class="form-group">
                                                                            <label for="telephone">Telephone/WhatsApp</label>
                                                                            <input type="text" class="form-control" name="cus_telephone" aria-describedby="telephone" value="<?php echo $customers['telephone'][$i] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12">
                                                                        <div class="form-group">
                                                                            <label for="nationality_id">Nationality</label>
                                                                            <select class="form-control" name="cus_nationality_id" data-itinerary-repeater="select2">
                                                                                <option value="0">Please Select Nationality...</option>
                                                                                <?php
                                                                                $nations = $bookObj->shownation();
                                                                                foreach ($nations as $nation) {
                                                                                    $select_nation = $nation['id'] == $customers['nationality'][$i] ? 'selected' : '';
                                                                                ?>
                                                                                    <option value="<?php echo $nation['id']; ?>" <?php echo $select_nation; ?>><?php echo $nation['name']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="col-md-1 col-12">
                                                                        <div class="form-group">
                                                                            <label for="cus_type">Thai/Foreigner</label>
                                                                            <select class="form-control" name="cus_type">
                                                                                <option value=""></option>
                                                                                <option value="1" <?php echo $customers['cus_type'][$i] == 1 || $customers['nationality'][$i] == 182 ? 'selected' : ''; ?>>Thai</option>
                                                                                <option value="2" <?php echo $customers['cus_type'][$i] == 2 && $customers['nationality'][$i] != 182 ? 'selected' : ''; ?>>Foreigner</option>
                                                                            </select>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="col-md-1 col-12 mb-50 mt-2">
                                                                        <div class="form-group">
                                                                            <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                                <i data-feather="x" class="mr-25"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div data-repeater-item>
                                                            <input type="hidden" name="cus_id" value="">
                                                            <input type="hidden" name="head" value="0">
                                                            <div class="row d-flex align-items-start">
                                                                <div class="col-md-1 col-12">
                                                                    <div class="form-group">
                                                                        <label for="age">ผู้ใหญ่/เด็ก/ทารก</label>
                                                                        <select class="form-control" name="cus_age">
                                                                            <option value=""></option>
                                                                            <option value="1">Adult</option>
                                                                            <option value="2">Child</option>
                                                                            <option value="3">Infant</option>
                                                                            <option value="3">FOC</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <div class="form-group">
                                                                        <label for="id_card">ID Passport/ ID Card</label>
                                                                        <input type="text" class="form-control" name="id_card" aria-describedby="id_card" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <div class="form-group">
                                                                        <label for="name">Name</label>
                                                                        <input type="text" class="form-control" name="cus_name" aria-describedby="name" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <div class="form-group">
                                                                        <label for="birth_date">Birth Date</label>
                                                                        <input type="date" class="form-control birth-date" name="cus_birth_date" aria-describedby="birth_date" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <div class="form-group">
                                                                        <label for="telephone">Telephone/WhatsApp</label>
                                                                        <input type="text" class="form-control" name="cus_telephone" aria-describedby="telephone" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <div class="form-group">
                                                                        <label for="nationality_id">Nationality</label>
                                                                        <select class="form-control" name="cus_nationality_id" data-itinerary-repeater="select2">
                                                                            <option value="0">Please Select Nationality...</option>
                                                                            <?php
                                                                            $nations = $bookObj->shownation();
                                                                            foreach ($nations as $nation) {
                                                                            ?>
                                                                                <option value="<?php echo $nation['id']; ?>"><?php echo $nation['name']; ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-md-2 col-12">
                                                                    <div class="form-group">
                                                                        <label for="cus_type">Thai/Foreigner</label>
                                                                        <select class="form-control" name="cus_type">
                                                                            <option value=""></option>
                                                                            <option value="1">Thai</option>
                                                                            <option value="2">Foreigner</option>
                                                                        </select>
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-md-1 col-12 mb-50 mt-2">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                            <i data-feather="x" class="mr-25"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-outline-primary mr-50" type="button" data-repeater-create>
                                                            <i data-feather="plus" class="mr-25"></i>
                                                            <span>Add Customer</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Customer Detail -->
                                    <!-- Start Form Booking Transfer Detail -->
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Transfer Detail</h5>
                                        </div>
                                        <div class="card-body mt-2">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-12">
                                                    <label class="form-label">Transfer</label>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="pickup_type_1" name="pickup_type" class="custom-control-input" value="1" onclick="check_pickup_type(1);" <?php echo $pickup_type == 1 || $pickup_type == 0 ? 'checked' : ''; ?> />
                                                        <label class="custom-control-label" for="pickup_type_1">เอารถรับส่ง</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="pickup_type_2" name="pickup_type" class="custom-control-input" value="2" onclick="check_pickup_type(2);" <?php echo $pickup_type == 2 ? 'checked' : ''; ?> />
                                                        <label class="custom-control-label" for="pickup_type_2">เดินทางมาเอง</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-12">
                                                    <label class="form-label">Transfer Type </label>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="transfer_type_join" name="transfer_type" class="custom-control-input" value="1" <?php echo $transfer_type == 1 || $transfer_type == 0 ? 'checked' : ''; ?> onchange="check_transfer_type();" />
                                                        <label class="custom-control-label" for="transfer_type_join">Join</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="transfer_type_private" name="transfer_type" class="custom-control-input" value="2" <?php echo $transfer_type == 2 ? 'checked' : ''; ?> onchange="check_transfer_type();" />
                                                        <label class="custom-control-label" for="transfer_type_private">Private</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3 col-12">
                                                    <label class="form-label" for="tran_adult_pax">Adult (ผู้ใหญ่)</label>
                                                    <input type="text" class="form-control numeral-mask" id="tran_adult_pax" name="tran_adult_pax" oninput="check_rate_transfer();" value="<?php echo $bt_adult; ?>" />
                                                    <input type="hidden" id="tran_adult" name="tran_adult" class="form-control" value="0">
                                                </div>
                                                <div class="form-group col-md-3 col-12">
                                                    <label class="form-label" for="tran_child_pax">Children (เด็ก)</label>
                                                    <input type="text" class="form-control numeral-mask" id="tran_child_pax" name="tran_child_pax" oninput="check_rate_transfer();" value="<?php echo $bt_child; ?>" />
                                                    <input type="hidden" id="tran_child" name="tran_child" class="form-control" value="0">
                                                </div>
                                                <div class="form-group col-md-3 col-12">
                                                    <label class="form-label" for="tran_infant_pax">Infant (ทารก)</label>
                                                    <input type="text" class="form-control numeral-mask" id="tran_infant_pax" name="tran_infant_pax" oninput="check_rate_transfer();" value="<?php echo $bt_infant; ?>" />
                                                    <input type="hidden" id="tran_infant" name="tran_infant" class="form-control" value="0">
                                                </div>
                                                <div class="form-group col-md-1 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="tran_foc_pax">FOC</label>
                                                        <input type="text" class="form-control numeral-mask" id="tran_foc_pax" name="tran_foc_pax" value="<?php echo $bt_foc; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <table>
                                                        <tr>
                                                            <td width="100%" colspan="3"><label for="start_pickup">Pickup Time (เวลารับ)</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="45%">
                                                                <input type="text" id="start_pickup" name="start_pickup" class="form-control time-mask text-left" placeholder="HH:MM" value="<?php echo date("H:i", strtotime($start_pickup)); ?>" />
                                                            </td>
                                                            <td width="10%" align="center"> - </td>
                                                            <td width="45%">
                                                                <input type="text" id="end_pickup" name="end_pickup" class="form-control time-mask text-left" placeholder="HH:MM" value="<?php echo date("H:i", strtotime($end_pickup)); ?>" />
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label for="pickup">Pickup Zone (โซนรับ)</label>
                                                        <select class="form-control select2" id="zone_pickup" name="pickup" onchange="check_time('zone_pickup');">
                                                            <option value="0">Please Select pickup...</option>
                                                            <?php
                                                            $zones = $bookObj->show_zone();
                                                            foreach ($zones as $zone) {
                                                                $select_zp = $zone['id'] == $pickup_id ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $zone['id']; ?>" <?php echo $select_zp; ?> data-start-pickup="<?php echo date("H:i", strtotime($zone['start_pickup'])); ?>" data-end-pickup="<?php echo date("H:i", strtotime($zone['end_pickup'])); ?>"><?php echo $zone['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3" hidden>
                                                    <div class="form-group">
                                                        <label for="hotel_pickup">Pickup Hotel (สถานที่รับ)</label>
                                                        <select class="form-control select2" id="hotel_pickup" name="hotel_pickup" onchange="check_hotel('pickup');">
                                                            <option value="0">Please Select Hotel...</option>
                                                            <?php
                                                            $hotels = $bookObj->show_hotel();
                                                            foreach ($hotels as $hotel) {
                                                                // $select_pp = $hotel['id'] == $hotel_pickup_id ? 'selected' : '';
                                                                $select_pp = $hotel['id'] == 0 ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $hotel['id']; ?>" data-zone="<?php echo $hotel['zone_id']; ?>" <?php echo $select_pp; ?>><?php echo $hotel['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="hotel_pickup_outside">Pickup Outside (ระบุสถานที่นอก)<?php echo $hotel_pickup_outside; ?></label>
                                                        <input type="text" id="hotel_pickup_outside" name="hotel_pickup_outside" class="form-control" value="<?php echo $hotel_pickup_outside; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="room_no">Room No. (ห้อง)</label>
                                                        <input type="text" id="room_no" name="room_no" class="form-control" value="<?php echo $room_no; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label for="dropoff">Zone Dropoff (โซนส่ง)</label>
                                                        <select class="form-control select2" id="dropoff" name="dropoff">
                                                            <option value="0">Please Select dropoff...</option>
                                                            <?php
                                                            $dropoffs = $bookObj->show_zone('dropoff');
                                                            foreach ($dropoffs as $dropoff) {
                                                                $select_zd = $dropoff['id'] == $dropoff_id ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $dropoff['id']; ?>" <?php echo $select_zd; ?>><?php echo $dropoff['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3" hidden>
                                                    <div class="form-group">
                                                        <label for="hotel_dropoff">Dropoff Hotel (สถานที่ส่ง)</label>
                                                        <select class="form-control select2" id="hotel_dropoff" name="hotel_dropoff" onchange="check_hotel('dropoff');">
                                                            <option value="0">Please Select Hotel...</option>
                                                            <?php
                                                            $hotels = $bookObj->show_hotel();
                                                            foreach ($hotels as $hotel) {
                                                                // $select_pd = $hotel['id'] == $hotel_dropoff_id ? 'selected' : '';
                                                                $select_pd = $hotel['id'] == 0 ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $hotel['id']; ?>" data-zone="<?php echo $hotel['zone_id']; ?>" <?php echo $select_pd; ?>><?php echo $hotel['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="hotel_dropoff_outside">Dropoff Outside (ระบุสถานที่นอก)</label>
                                                        <input type="text" id="hotel_dropoff_outside" name="hotel_dropoff_outside" class="form-control" placeholder="ที่เดียวกับสถานที่รับ" value="<?php echo $hotel_dropoff_outside; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="trans_note">Note (Transfer Detail)</label>
                                                        <textarea class="form-control" name="trans_note" id="trans_note" rows="3"><?php echo $bt_note; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" hidden>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="tran_total_price">Total Price (Transfer)</label>
                                                        <input type="text" id="tran_total_price" name="tran_total_price" class="form-control numeral-mask" value="<?php echo number_format($btr_rate_private); ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Transfer Detail -->
                                    <!-- Start Form Booking Payment Detail -->
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5" hidden>
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Booking Payment</h5>
                                        </div>
                                        <div class="card-body mt-2">
                                            <div class="payments-repeater">
                                                <div data-repeater-list="payments">
                                                    <?php if ($payments) {
                                                        for ($i = 0; $i < count($payments['bopa_id']); $i++) { ?>
                                                            <input type="hidden" name="before_bopa_id[]" value="<?php echo $payments['bopa_id'][$i]; ?>">
                                                            <input type="hidden" name="before_photo[]" value="<?php echo $payments['bopa_photo'][$i]; ?>">
                                                            <div data-repeater-item>
                                                                <input type="hidden" name="bopa_id" value="<?php echo $payments['bopa_id'][$i]; ?>">
                                                                <div class="row d-flex align-items-start">
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label for="book_payment">Payment (การชำระเงิน)</label>
                                                                            <select class="form-control" name="book_payment" data-payments-repeater="select2">
                                                                                <option value="">Please Select Payment...</option>
                                                                                <?php
                                                                                $book_payments = $bookObj->show_booking_payment();
                                                                                foreach ($book_payments as $book_payment) {
                                                                                    $select_payment = $book_payment['id'] == $payments['bopay_id'][$i] ? 'selected' : '';
                                                                                ?>
                                                                                    <option value="<?php echo $book_payment['id']; ?>" <?php echo $select_payment; ?>><?php echo $book_payment['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="total_paid">ยอดที่ชำระ</label>
                                                                            <input type="text" name="total_paid" class="form-control" data-payments-repeater="numeral-mask" value="<?php echo !empty($payments['total_paid'][$i]) ? number_format($payments['total_paid'][$i]) : 0;  ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="paid_date">วันที่ชำระเงิน</label><br>
                                                                            <input type="text" class="form-control" name="paid_date" data-payments-repeater="datepicker" value="<?php echo ($payments['date_paid'][$i] != '0000-00-00') ? $payments['date_paid'][$i] : ''; ?>" />
                                                                            <input type="hidden" name="paid_time" value="<?php echo $times; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label for="payments_type">รูปแบบการชำระเงิน</label>
                                                                            <select class="form-control" name="payments_type" data-payments-repeater="select2" onchange="check_payments_type(this);">
                                                                                <option value="">Please choose payments type ... </option>
                                                                                <?php
                                                                                $payments_type = $bookObj->show_payments_type(3);
                                                                                foreach ($payments_type as $payment_type) {
                                                                                    $select_payment = $payment_type['id'] == $payments['payment_type_id'][$i] ? 'selected' : '';
                                                                                ?>
                                                                                    <option value="<?php echo $payment_type['id']; ?>" <?php echo $select_payment; ?>><?php echo $payment_type['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group" data-div-payments="account" name="div-bank-account" <?php echo $payments['payment_type_id'][$i] != 7 ? 'hidden' : ''; ?>>
                                                                            <label for="bank_account">เข้าบัญชี</label>
                                                                            <select class="form-control" name="bank_account" data-payments-repeater="select2">
                                                                                <option value="">Please choose bank account ... </option>
                                                                                <?php
                                                                                $banks_acc = $bookObj->show_bank_account();
                                                                                foreach ($banks_acc as $bank_acc) {
                                                                                    $select_bank = $bank_acc['id'] == $payments['bank_account_id'][$i] ? 'selected' : '';
                                                                                ?>
                                                                                    <option value="<?php echo $bank_acc['id']; ?>" <?php echo $select_bank; ?>><?php echo $bank_acc['banName'] . ' ' . $bank_acc['account_no'] . ' (' . $bank_acc['account_name'] . ')'; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12">
                                                                        <div class="form-group" data-div-payments="card" name="div-card" <?php echo $payments['payment_type_id'][$i] != 8 ? 'hidden' : ''; ?>>
                                                                            <label for="card_no">Card Number</label>
                                                                            <input type="text" class="form-control" id="card_no" name="card_no" value="<?php echo !empty($payments['card_no'][$i]) ? $payments['card_no'][$i] : ''; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label>หลักฐานการชำระ</label>
                                                                            <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                                                <?php if (!empty($payments['bopa_photo'][$i])) { ?>
                                                                                    <img src="<?php echo $hostPageUrl; ?>/uploads/booking/paid/<?php echo $payments['bopa_photo'][$i]; ?>" class="img-fluid product-img" alt="Photo" width="200" />
                                                                                <?php } ?>
                                                                            </div>
                                                                            <input type="file" class="form-control-file" name="photo" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="note">หมายเหตุ</label>
                                                                            <textarea class="form-control" name="note" rows="3"><?php echo $payments['bopa_note'][$i]; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 col-12 mb-50 mt-2">
                                                                        <div class="form-group">
                                                                            <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                                <i data-feather="x" class="mr-25"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div data-repeater-item>
                                                            <input type="hidden" name="bopa_id" value="">
                                                            <div class="row d-flex align-items-start">
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label for="book_payment">Payment (การชำระเงิน)</label>
                                                                        <select class="form-control" name="book_payment" data-payments-repeater="select2">
                                                                            <option value="">Please Select Payment...</option>
                                                                            <?php
                                                                            $payments = $bookObj->show_booking_payment();
                                                                            foreach ($payments as $payment) {
                                                                            ?>
                                                                                <option value="<?php echo $payment['id']; ?>"><?php echo $payment['name']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="total_paid">ยอดที่ชำระ</label>
                                                                        <input type="text" name="total_paid" class="form-control" data-payments-repeater="numeral-mask" value="" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="paid_date">วันที่ชำระเงิน</label><br>
                                                                        <input type="text" class="form-control" name="paid_date" data-payments-repeater="datepicker" value="<?php echo $date_paid; ?>" />
                                                                        <input type="hidden" name="paid_time" value="<?php echo $times; ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label for="payments_type">รูปแบบการชำระเงิน</label>
                                                                        <select class="form-control" name="payments_type" data-payments-repeater="select2" onchange="check_payments_type(this);">
                                                                            <option value="">Please choose payments type ... </option>
                                                                            <?php
                                                                            $payments = $bookObj->show_payments_type(3);
                                                                            foreach ($payments as $payment) {
                                                                            ?>
                                                                                <option value="<?php echo $payment['id']; ?>"><?php echo $payment['name']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group" data-div-payments="account" name="div-bank-account" hidden>
                                                                        <label for="bank_account">เข้าบัญชี</label>
                                                                        <select class="form-control" name="bank_account" data-payments-repeater="select2">
                                                                            <option value="">Please choose bank account ... </option>
                                                                            <?php
                                                                            $banks_acc = $bookObj->show_bank_account();
                                                                            foreach ($banks_acc as $bank_acc) {
                                                                            ?>
                                                                                <option value="<?php echo $bank_acc['id']; ?>"><?php echo $bank_acc['banName'] . ' ' . $bank_acc['account_no'] . ' (' . $bank_acc['account_name'] . ')'; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-12">
                                                                    <div class="form-group" data-div-payments="card" name="div-card" hidden>
                                                                        <label for="card_no">Card Number</label>
                                                                        <input type="text" class="form-control" id="card_no" name="card_no" value="" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label>หลักฐานการชำระ</label>
                                                                        <div class="d-flex align-items-center justify-content-center mt-2 mb-2">
                                                                        </div>
                                                                        <input type="file" class="form-control-file" name="photo" value="" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="note">หมายเหตุ</label>
                                                                        <textarea class="form-control" name="note" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1 col-12 mb-50 mt-2">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                            <i data-feather="x" class="mr-25"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-outline-primary mr-50" type="button" data-repeater-create>
                                                            <i data-feather="plus" class="mr-25"></i>
                                                            <span>Add Payment</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Payment Detail -->
                                    <!-- Start Form Booking Extra Charge Detail -->
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Extra Charge Detail</h5>
                                        </div>
                                        <?php
                                        $extras = $bookObj->show_extra_charge();
                                        foreach ($extras as $extra) {
                                            echo '<input type="hidden" class="small" id="extar_ad' . $extra['id'] . '" value="' . $extra['rate_adult'] . '">';
                                            echo '<input type="hidden" class="small" id="extar_chd' . $extra['id'] . '" value="' . $extra['rate_child'] . '">';
                                            echo '<input type="hidden" class="small" id="extar_inf' . $extra['id'] . '" value="' . $extra['rate_infant'] . '">';
                                            echo '<input type="hidden" class="small" id="extar_total' . $extra['id'] . '" value="' . $extra['rate_total'] . '">';
                                        }
                                        ?>
                                        <div class="card-body mt-2">
                                            <div class="extra-charge-repeater">
                                                <div data-repeater-list="extra-charge">
                                                    <?php if ($extar) {
                                                        for ($i = 0; $i < count($extar['bec_id']); $i++) { ?>
                                                            <input type="hidden" name="before_bec_id[]" value="<?php echo $extar['bec_id'][$i]; ?>">
                                                            <div data-repeater-item>
                                                                <input type="hidden" name="bec_id" value="<?php echo $extar['bec_id'][$i]; ?>">
                                                                <div id="div-start-extra-charge">
                                                                    <div class="row d-flex align-items-start">
                                                                        <div class="col-md-3 col-12">
                                                                            <div class="form-group">
                                                                                <label for="extra_charge">Extra Charge (ค่าใช้จ่ายเพิ่มเติม)</label>
                                                                                <select class="form-control" name="extra_charge" data-extra-repeater="select2" onchange="chang_extra_charge(this);">
                                                                                    <option value="0">Please Select Extra Charge...</option>
                                                                                    <?php
                                                                                    foreach ($extras as $extra) {
                                                                                        $select_extra = $extra['id'] == $extar['extra_id'][$i] ? 'selected' : '';
                                                                                    ?>
                                                                                        <option value="<?php echo $extra['id']; ?>" <?php echo $select_extra; ?>><?php echo $extra['name']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-12">
                                                                            <div class="form-group">
                                                                                <label for="extc_name">Custom Extra Charge (กำหนดเองค่าใช้จ่ายเพิ่มเติม)</label>
                                                                                <input type="text" class="form-control" name="extc_name" aria-describedby="extc_name" value="<?php echo $extar['bec_name'][$i]; ?>" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 col-12">
                                                                            <div class="form-group">
                                                                                <label for="extra_type">Extra Charge Type (ค่าใช้จ่ายประเภท)</label>
                                                                                <select class="form-control" name="extra_type" data-extra-repeater="select2" onchange="check_extar_type(this);">
                                                                                    <option value="0" <?php echo $extar['bec_type'][$i] == 0 ? 'selected' : ''; ?>>Please Select Type...</option>
                                                                                    <option value="1" <?php echo $extar['bec_type'][$i] == 1 ? 'selected' : ''; ?>>Per Pax</option>
                                                                                    <option value="2" <?php echo $extar['bec_type'][$i] == 2 ? 'selected' : ''; ?>>Total</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-12">
                                                                            <div class="form-group">
                                                                                <label for="extc_total">Total (รวมทั้งหมด)</label><br>
                                                                                <span name="extc_total" class="text-danger text-bold h5"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1 col-12 mb-50 mt-2">
                                                                            <div class="form-group">
                                                                                <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                                    <i data-feather="x"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row d-flex align-items-start">
                                                                        <div class="col-md-3 col-12" name="div_extar_perpax" hidden>
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_adult">Adult (ผู้ใหญ่)</label>
                                                                                            <input type="number" class="form-control" name="extra_adult" oninput="checke_rate_extar();" value="<?php echo $extar['bec_adult'][$i]; ?>" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                    <td <?php echo $account; ?>>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_rate_adult">Rate Adult (ราคาผู้ใหญ่)</label>
                                                                                            <input type="text" name="extra_rate_adult" class="form-control numeral-mask" value="<?php echo number_format($extar['bec_rate_adult'][$i]); ?>" oninput="checke_rate_extar();">
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-md-3 col-12" name="div_extar_perpax" hidden>
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_child">Children (เด็ก)</label>
                                                                                            <input type="number" class="form-control" name="extra_child" oninput="checke_rate_extar();" value="<?php echo $extar['bec_child'][$i]; ?>" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                    <td <?php echo $account; ?>>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_rate_child">Rate Children (ราคาเด็ก)</label>
                                                                                            <input type="text" name="extra_rate_child" class="form-control numeral-mask" value="<?php echo number_format($extar['bec_rate_child'][$i]); ?>" oninput="checke_rate_extar();">
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-md-3 col-12" name="div_extar_perpax" hidden>
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_infant">Infant (ทารก)</label>
                                                                                            <input type="number" class="form-control" name="extra_infant" oninput="checke_rate_extar();" value="<?php echo $extar['bec_infant'][$i]; ?>" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                    <td <?php echo $account; ?>>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_rate_infant">Rate Infant (ราคาทารก)</label>
                                                                                            <input type="text" name="extra_rate_infant" class="form-control numeral-mask" value="<?php echo number_format($extar['bec_rate_infant'][$i]); ?>" oninput="checke_rate_extar();">
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-md-3 col-12" name="div_extar_total" hidden>
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_num_private">Private (จำนวน)</label>
                                                                                            <input type="number" class="form-control" name="extra_num_private" oninput="checke_rate_extar();" value="<?php echo $extar['bec_privates'][$i]; ?>" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                    <td <?php echo $account; ?>>
                                                                                        <div class="form-group">
                                                                                            <label class="form-label" for="extra_rate_private">Rate Private (ราคา/จำนวน)</label>
                                                                                            <input type="text" name="extra_rate_private" class="form-control numeral-mask" value="<?php echo number_format($extar['bec_rate_private'][$i]); ?>" oninput="checke_rate_extar();">
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr />
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div data-repeater-item>
                                                            <input type="hidden" name="bec_id" value="">
                                                            <div id="div-extra-charge">
                                                                <div class="row d-flex align-items-start">
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label for="extra_charge">Extra Charge (ค่าใช้จ่ายเพิ่มเติม)</label>
                                                                            <select class="form-control" name="extra_charge" data-extra-repeater="select2" onchange="chang_extra_charge(this);">
                                                                                <option value="0">Please Select Extra Charge...</option>
                                                                                <?php
                                                                                foreach ($extras as $extra) {
                                                                                ?>
                                                                                    <option value="<?php echo $extra['id']; ?>"><?php echo $extra['name']; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label for="extc_name">Custom Extra Charge (กำหนดเองค่าใช้จ่ายเพิ่มเติม)</label>
                                                                            <input type="text" class="form-control" name="extc_name" aria-describedby="extc_name" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label for="extra_type">Extra Charge Type (ค่าใช้จ่ายประเภท)</label>
                                                                            <select class="form-control" name="extra_type" data-extra-repeater="select2" onchange="check_extar_type(this);">
                                                                                <option value="0">Please Select Type...</option>
                                                                                <option value="1">Per Pax</option>
                                                                                <option value="2">Total</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 col-12" <?php echo $account; ?>>
                                                                        <div class="form-group">
                                                                            <label for="extc_total">Total (รวมทั้งหมด)</label><br>
                                                                            <span name="extc_total" class="text-danger text-bold h5"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 col-12 mb-50 mt-2">
                                                                        <div class="form-group">
                                                                            <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                                <i data-feather="x"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row d-flex align-items-start">
                                                                    <div class="col-md-3 col-12" name="div_extar_perpax" hidden>
                                                                        <table>
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_adult">Adult (ผู้ใหญ่)</label>
                                                                                        <input type="number" class="form-control" name="extra_adult" oninput="checke_rate_extar();" value="0" />
                                                                                    </div>
                                                                                </td>
                                                                                <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                <td <?php echo $account; ?>>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_rate_adult">Rate Adult (ราคาผู้ใหญ่)</label>
                                                                                        <input type="text" name="extra_rate_adult" class="form-control numeral-mask" value="0" oninput="checke_rate_extar();">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-3 col-12" name="div_extar_perpax" hidden>
                                                                        <table>
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_child">Children (เด็ก)</label>
                                                                                        <input type="number" class="form-control" name="extra_child" oninput="checke_rate_extar();" value="0" />
                                                                                    </div>
                                                                                </td>
                                                                                <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                <td <?php echo $account; ?>>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_rate_child">Rate Children (ราคาเด็ก)</label>
                                                                                        <input type="text" name="extra_rate_child" class="form-control numeral-mask" value="0" oninput="checke_rate_extar();">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-3 col-12" name="div_extar_perpax" hidden>
                                                                        <table>
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_infant">Infant (ทารก)</label>
                                                                                        <input type="number" class="form-control" name="extra_infant" oninput="checke_rate_extar();" value="0" />
                                                                                    </div>
                                                                                </td>
                                                                                <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                <td <?php echo $account; ?>>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_rate_infant">Rate Infant (ราคาทารก)</label>
                                                                                        <input type="text" name="extra_rate_infant" class="form-control numeral-mask" value="0" oninput="checke_rate_extar();">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-3 col-12" name="div_extar_total" hidden>
                                                                        <table>
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_num_private">Private (จำนวน)</label>
                                                                                        <input type="number" class="form-control" name="extra_num_private" oninput="checke_rate_extar();" value="0" />
                                                                                    </div>
                                                                                </td>
                                                                                <td <?php echo $account; ?>><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                                                <td <?php echo $account; ?>>
                                                                                    <div class="form-group">
                                                                                        <label class="form-label" for="extra_rate_private">Rate Private (ราคา/จำนวน)</label>
                                                                                        <input type="text" name="extra_rate_private" class="form-control numeral-mask" value="0" oninput="checke_rate_extar();">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr />
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-outline-primary mr-50" type="button" data-repeater-create>
                                                            <i data-feather="plus" class="mr-25"></i>
                                                            <span>Add Extar Chang</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Extra Charge Detail -->
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <?php if ($book_status != 3 && !empty($ooollooo)) { ?>
                                            <span>
                                                <button type="button" class="btn btn-info btn-page-block-spinner" data-toggle="modal" data-target="#modal-add-invoice" onclick="modal_add_invoice();">Invoice</button>
                                                <?php if ($inv_id > 0) { ?>
                                                    <a href="./?pages=invoice/print&action=preview&inv_id=<?php echo $inv_id; ?>&cover_id=0" target="_blank">
                                                        <button type="button" class="btn btn-info btn-page-block-spinner">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                                            </svg>
                                                            Print Invoice
                                                        </button>
                                                    </a>
                                                <?php } ?>
                                            </span>
                                        <?php } else {
                                            echo '<span></span>';
                                        } ?>
                                        <button type="submit" class="btn btn-primary btn-page-block-spinner" name="submit" value="Submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!------------------------------------------------------------------>
                            <!-- End Form Modal -->

                            <!-- Items Vertical -->
                        </div>
                </section>

                <!-- Start Form Modal -->
                <!------------------------------------------------------------------>
                <div class="modal-size-xl d-inline-block">
                    <div class="modal fade text-left" id="modal-add-invoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel16">สร้าง Invoice</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="invoice-form" name="invoice-form" method="post" enctype="multipart/form-data">
                                        <input type="hidden" id="inv_id" name="inv_id" value="<?php echo $inv_id; ?>">
                                        <input type="hidden" id="today" name="today" value="<?php echo $today; ?>">
                                        <input type="hidden" id="amount" name="amount" value="<?php echo $book_type == 1 ? $product_total + $transfer_total + $extar_total : $rate_total + $transfer_total + $extar_total; ?>">
                                        <div id="div-show"></div>
                                        <div class="row">
                                            <div class="form-group col-md-3 col-12">
                                                <label class="form-label" for="is_approved"></label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" checked />
                                                    <label class="custom-control-label" for="is_approved">วางบิลแล้ว</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" <?php echo $inv_id > 0 ? 'hidden' : ''; ?>>
                                            <div class="form-group col-md-3 col-12">
                                                <label for="inv_no">ใบวางบิล</label>
                                                <input type="hidden" id="inv_no" name="inv_no" value="">
                                                <input type="hidden" id="inv_full" name="inv_full" value="">
                                                <div class="input-group">
                                                    <span id="inv_no_text"><?php echo $inv_id > 0 ? $inv_full : ''; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="inv_date">วันที่วางบิล</label></br>
                                                    <input type="text" class="form-control date-flatpickr" id="inv_date" name="inv_date" value="<?php echo $inv_id > 0 ? $inv_date : $today; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="rec_date">กำหนดครบชำระภายในวันที่</label></br>
                                                    <input type="text" class="form-control date-flatpickr" id="rec_date" name="rec_date" value="<?php echo $inv_id > 0 ? $rec_date : $today; ?>" onchange="check_diff_date()" />
                                                    <p class="text-danger font-weight-bold" id="diff_rec_date"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-header">
                                                    <h5>Agent</h5>
                                                </div>
                                                <hr class="mt-0">
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <label class="form-label" for="agent_name">Company</label>
                                                <div class="input-group">
                                                    <?php echo $agent_name; ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <label class="form-label" for="agent_tax">Tax ID.</label>
                                                <div class="input-group">
                                                    <?php echo $agent_license; ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <label class="form-label" for="agent_tel">Tel</label>
                                                <div class="input-group">
                                                    <?php echo $agent_telephone; ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <label class="form-label" for="agent_address">Address</label>
                                                <div class="input-group">
                                                    <?php echo $agent_address; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-header">
                                                    <h5 class="mt-1">เงื่อนไขราคา</h5>
                                                </div>
                                                <hr class="mt-0">
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <label for="currency">สกุลเงิน</label>
                                                <div id="div-currency">
                                                    <select class="form-control select2" id="currency" name="currency">
                                                        <option value="">Please choose currency ... </option>
                                                        <?php
                                                        $currencys = $bookObj->showcurrency();
                                                        foreach ($currencys as $currency) {
                                                        ?>
                                                            <option value="<?php echo $currency['id']; ?>" data-name="<?php echo $currency['name']; ?>" <?php echo $currency_id != $currency['id'] ? $currency['id'] == 4 ? 'selected' : '' : 'selected'; ?>><?php echo $currency['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="input-group">
                                                    <span id="currency_text"></span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <label for="vat">ภาษีมูลค่าเพิ่ม</label>
                                                <div id="div-vat">
                                                    <select class="form-control select2" id="vat" name="vat" onchange="calculator_price();">
                                                        <option value="0">No Vat ... </option>
                                                        <?php
                                                        $vats = $bookObj->showvat();
                                                        foreach ($vats as $vat) {
                                                            $selected = $vat['id'] == $vat_id ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $vat['id']; ?>" data-name="<?php echo $vat['name']; ?>" <?php echo $selected; ?>><?php echo $vat['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="input-group">
                                                    <span id="vat_text"></span>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <label for="withholding">หัก ณ ที่จ่าย (%)</label>
                                                <div id="div-withholding">
                                                    <input type="text" class="form-control numeral-mask" id="withholding" name="withholding" value="<?php echo $withholding; ?>" oninput="calculator_price();" />
                                                </div>
                                                <div class="input-group">
                                                    <span id="withholding"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Start Data Table payment -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-header">
                                                    <h5 class="mt-1">การชำระเงิน</h5>
                                                </div>
                                                <hr class="mt-0">
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <div class="form-group">
                                                    <?php $branches = $bookObj->showbranch(); ?>
                                                    <label for="branch">สาขา</label>
                                                    <select class="form-control select2" id="branch" name="branch">
                                                        <option value="">Please choose Branch ... </option>
                                                        <?php
                                                        foreach ($branches as $branch) {
                                                            $selected = $branch['id'] == $branche_id ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $branch['id']; ?>" data-name="<?php echo $branch['name']; ?>"><?php echo $branch['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-12" id="div-bank-account">
                                                <div class="form-group">
                                                    <?php $banks_acc = $bookObj->showbankaccount(); ?>
                                                    <label for="bank_account">เข้าบัญชี</label>
                                                    <select class="form-control select2" id="bank_account" name="bank_account">
                                                        <option value="">Please choose bank account ... </option>
                                                        <?php
                                                        foreach ($banks_acc as $bank_acc) {
                                                            $selected = $bank_acc['id'] == $inv_bank_account ? 'selected' : '';
                                                        ?>
                                                            <option value="<?php echo $bank_acc['id']; ?>" data-name="<?php echo $bank_acc['account_name']; ?>" <?php echo $selected; ?>><?php echo $bank_acc['banName'] . ' ' . $bank_acc['account_no'] . ' (' . $bank_acc['account_name'] . ')'; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td width="34%" align="left" class="default-td" colspan="4">
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-4 text-right">
                                                                Voucher No.
                                                            </dt>
                                                            <dd class="col-sm-8"><?php echo $voucher_no_agent; ?></dd>
                                                        </dl>
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-4 text-right">
                                                                Booking No.
                                                            </dt>
                                                            <dd class="col-sm-8"><?php echo $book_full; ?></dd>
                                                        </dl>
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-4 text-right">
                                                                โปรแกรม <br>
                                                                <small>(Programe)</small>
                                                            </dt>
                                                            <dd class="col-sm-8"><?php echo $product_name; ?></dd>
                                                        </dl>
                                                    </td>
                                                    <td align="left" class="default-td" colspan="2">
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-4 text-right">
                                                                วันที่เที่ยว <br>
                                                                <small>(Travel Date)</small>
                                                            </dt>
                                                            <dd class="col-sm-8"><?php echo date('j F Y', strtotime($travel_date)); ?></dd>
                                                        </dl>
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-4 text-right">
                                                                ประเภทลูกค้า <br>
                                                                <small>(Guest Type)</small>
                                                            </dt>
                                                            <dd class="col-sm-8"><?php echo $book_type_name; ?></dd>
                                                        </dl>
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-4 text-right">
                                                                ชื่อลูกค้า <br>
                                                                <small>(Customer Name)</small>
                                                            </dt>
                                                            <dd class="col-sm-8"><?php echo $customers['name'][0]; ?></dd>
                                                        </dl>
                                                    </td>
                                                    <td width="34%" align="left" class="default-td" colspan="2">
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-6 text-right">
                                                                สถานที่รับ <br>
                                                                <small>(Pick-Up Hotel)</small>
                                                            </dt>
                                                            <dd class="col-sm-6"><?php echo $hotel_pickup_name; ?></dd>
                                                        </dl>
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-6 text-right">
                                                                หมายเลขห้อง <br>
                                                                <small>(Room No.)</small>
                                                            </dt>
                                                            <dd class="col-sm-6"><?php echo $room_no; ?></dd>
                                                        </dl>
                                                        <dl class="row" style="margin-bottom: 0;">
                                                            <dt class="col-sm-6 text-right">
                                                                เวลารับ <br>
                                                                <p style="font-size: 10px; margin-bottom: 0;">(Pick-Up Time)</small>
                                                            </dt>
                                                            <dd class="col-sm-6" id="pickup_time_text"><?php echo date('H:i', strtotime($start_pickup)); ?></dd>
                                                        </dl>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered">
                                                <thead class="bg-warning bg-darken-2 text-white">
                                                    <tr>
                                                        <td class="text-center" bgcolor="#333" style="color: #fff; border-radius: 15px 0px 0px 0px; padding: 5px 0;" width="10%"><b>เลขที่</b><br>
                                                            <small>No.</small>
                                                        </td>
                                                        <td class="text-center" bgcolor="#333" style="color: #fff;" width="40%"><b>รายการ</b><br>
                                                            <small>Description</small>
                                                        </td>
                                                        <td class="text-center" bgcolor="#333" style="color: #fff;" width="15%"><b>จํานวน</b><br>
                                                            <small>Quantity.</small>
                                                        </td>
                                                        <td class="text-center" bgcolor="#333" style="color: #fff;" width="15%"><b>ราคา/หน่วย</b><br>
                                                            <small>Unit Price.</small>
                                                        </td>
                                                        <td class="text-center" bgcolor="#333" style="color: #fff; border-radius: 0px 15px 0px 0px;" width="20%"><b>จํานวนเงิน</b><br>
                                                            <small>Amount</small>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>Adult</td>
                                                        <td class="text-center"><?php echo $adult; ?></td>
                                                        <td class="text-center"><?php echo !empty($rate_adult) ? number_format($rate_adult) : 0; ?></td>
                                                        <td class="text-center" <?php echo $book_type == 2 ? 'hidden' : ''; ?>><?php echo !empty($rate_adult) ? number_format($adult * $rate_adult) : 0; ?></td>
                                                        <td class="text-center" <?php echo $book_type == 1 ? 'hidden' : ''; ?> rowspan="3"><?php echo !empty($rate_total) ? number_format($rate_total) : 0; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td>Children</td>
                                                        <td class="text-center"><?php echo $child; ?></td>
                                                        <td class="text-center"><?php echo !empty($rate_child) ? number_format($rate_child) : 0; ?></td>
                                                        <td class="text-center" <?php echo $book_type == 2 ? 'hidden' : ''; ?>><?php echo !empty($rate_child) ? number_format($child * $rate_child) : 0; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td>Infant</td>
                                                        <td class="text-center"><?php echo $infant; ?></td>
                                                        <td class="text-center"><?php echo !empty($rate_infant) ? number_format($rate_infant) : 0; ?></td>
                                                        <td class="text-center" <?php echo $book_type == 2 ? 'hidden' : ''; ?>><?php echo !empty($rate_infant) ? number_format($infant * $rate_infant) : 0; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">Transfer : <b><?php echo ($transfer_type == 1) ? 'Join' : 'Private'; ?></b></td>
                                                    </tr>
                                                    <!-- Start Transfer -->
                                                    <?php if ($transfer_type == 1) {  ?>
                                                        <tr>
                                                            <td class="text-center">4</td>
                                                            <td>Adult</td>
                                                            <td class="text-center"><?php echo $bt_adult; ?></td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_adult) ? number_format($btr_rate_adult) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_adult) ? number_format($bt_adult * $btr_rate_adult) : 0; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">5</td>
                                                            <td>Children</td>
                                                            <td class="text-center"><?php echo $bt_child; ?></td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_child) ? number_format($btr_rate_child) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_child) ? number_format($bt_child * $btr_rate_child) : 0; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">6</td>
                                                            <td>Infant</td>
                                                            <td class="text-center"><?php echo $bt_infant; ?></td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_infant) ? number_format($btr_rate_infant) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_infant) ? number_format($bt_infant * $btr_rate_infant) : 0; ?></td>
                                                        </tr>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td class="text-center">4</td>
                                                            <td>Transfer Private</td>
                                                            <td class="text-center">1</td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_private) ? number_format($btr_rate_private) : 0; ?></td>
                                                            <td class="text-center"><?php echo !empty($btr_rate_private) ? number_format($btr_rate_private) : 0; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <!-- End Transfer -->
                                                    <!-- Start Extra charge -->
                                                    <?php if (!empty($extar['bec_id'])) {  ?>
                                                        <tr>
                                                            <td colspan="6">Extra Charge</td>
                                                        </tr>
                                                        <?php for ($e = 0; $e < count($extar['bec_id']); $e++) {
                                                            if (!empty($extar['bec_type']) && $extar['bec_type'][$e] == 1) { ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo ($transfer_type == 1) ? '7' : '5'; ?></td>
                                                                    <td><?php echo !empty($extar['extra_name'][$e]) ? $extar['extra_name'][$e] : $extar['bec_name'][$e]; ?> (Adult)</td>
                                                                    <td class="text-center"><?php echo $extar['bec_adult'][$e]; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_adult'][$e]) ? number_format($extar['bec_rate_adult'][$e]) : 0; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_adult'][$e]) ? number_format($extar['bec_adult'][$e] * $extar['bec_rate_adult'][$e]) : 0; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><?php echo ($transfer_type == 1) ? '8' : '6'; ?></td>
                                                                    <td><?php echo !empty($extar['extra_name'][$e]) ? $extar['extra_name'][$e] : $extar['bec_name'][$e]; ?> (Children)</td>
                                                                    <td class="text-center"><?php echo $extar['bec_child'][$e]; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_child'][$e]) ? number_format($extar['bec_rate_child'][$e]) : 0; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_child'][$e]) ? number_format($extar['bec_child'][$e] * $extar['bec_rate_child'][$e]) : 0; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><?php echo ($transfer_type == 1) ? '9' : '7'; ?></td>
                                                                    <td><?php echo !empty($extar['extra_name'][$e]) ? $extar['extra_name'][$e] : $extar['bec_name'][$e]; ?> (Infant)</td>
                                                                    <td class="text-center"><?php echo $extar['bec_infant'][$e]; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_infant'][$e]) ? number_format($extar['bec_rate_infant'][$e]) : 0; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_infant'][$e]) ? number_format($extar['bec_infant'][$e] * $extar['bec_rate_infant'][$e]) : 0; ?></td>
                                                                </tr>
                                                            <?php } elseif (!empty($extar['bec_type']) && $extar['bec_type'][$e] == 2) { ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo ($transfer_type == 1) ? '7' : '5'; ?></td>
                                                                    <td><?php echo !empty($extar['extra_name'][$e]) ? $extar['extra_name'][$e] : $extar['bec_name'][$e]; ?> (Private)</td>
                                                                    <td class="text-center"><?php echo $extar['bec_privates'][$e]; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_private'][$e]) ? number_format($extar['bec_rate_private'][$e]) : 0; ?></td>
                                                                    <td class="text-center"><?php echo !empty($extar['bec_rate_private'][$e]) ? number_format($extar['bec_privates'][$e] * $extar['bec_rate_private'][$e]) : 0; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <!-- End Extra charge -->
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td class="text-center"><b>รวมเป็นเงิน</b><br><small>(Total)</small></td>
                                                        <td class="text-center"><?php echo $book_type == 1 ? number_format($product_total + $transfer_total + $extar_total) : number_format($rate_total + $transfer_total + $extar_total); ?></td>
                                                    </tr>
                                                    <?php if ($discount > 0) { ?>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-center"><b>ส่วนลด </b><br><small>(Discount)</small></td>
                                                            <td class="text-center"><?php echo number_format($discount); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if ($payment_total > 0) { ?>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td class="text-center"><b>Cash on tour</b></td>
                                                            <td class="text-center"><?php echo number_format($payment_total); ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr id="tr-vat" hidden>
                                                        <td colspan="3"></td>
                                                        <td class="text-center"><b id="vat-text"></b><br><small>(Vat)</small></td>
                                                        <td class="text-center" id="price-vat">0</td>
                                                    </tr>
                                                    <tr id="tr-withholding" hidden>
                                                        <td colspan="3"></td>
                                                        <td class="text-center"><b id="withholding-text"></b><br><small>(Withholding Tax)</small></td>
                                                        <td class="text-center" id="price-withholding">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td class="text-center"><b>ยอดชำระ</b><br><small>(Payment Amount)</small></td>
                                                        <td class="text-center" id="price-amount"><?php echo $book_type == 1 ? number_format(($product_total + $transfer_total + $extar_total) - ($payment_total + $discount)) : number_format(($rate_total + $transfer_total + $extar_total) - ($payment_total + $discount)); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="price_total" name="price_total" value="<?php echo $book_type == 1 ? ($product_total + $transfer_total + $extar_total) - ($payment_total + $discount) : ($rate_total + $transfer_total + $extar_total) - ($payment_total + $discount); ?>">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="note">Note</label>
                                                    <textarea class="form-control" name="note" id="note" rows="3"><?php echo $inv_id > 0 ? $inv_note : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span></span>
                                            <button type="submit" class="btn btn-primary" id="btn-submit-inv" name="submit" value="Submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------------>
                    <!-- End Form Modal -->

                </div>

            </div>
            <!-- /Vertical Wizard -->
        </div>
    </div>
</div>
<?php
$close_conn = $bookObj->close();
?>