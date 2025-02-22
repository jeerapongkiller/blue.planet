<?php
include_once('controllers/Booking.php');

$bookObj = new Booking();
$today = date("Y-m-d");
$times = date("H:i:s");
?>

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
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Validation -->
            <section class="bs-validation">
                <div class="row">
                    <!-- jQuery Validation -->
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="booking-create-form" name="booking-create-form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="open-rates" name="open_rates" value="<?php echo $open_rates; ?>" />
                                    <!-- Start Form Booking Detail -->
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Booking Detail</h5>
                                        </div>
                                        <div class="card-body mt-2">
                                            <div id="show-response"></div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="book_status">Booking Status (สถานะ)</label>
                                                    <div class="input-group">
                                                        <input type="hidden" id="book_status" name="book_status" value="1" />
                                                        <p>New Booking</p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="book_date">Booking Date (วันที่สร้าง)</label>
                                                    <div class="input-group">
                                                        <input type="hidden" id="book_date" name="book_date" value="<?php echo $today; ?>" />
                                                        <input type="hidden" id="book_time" name="book_time" value="<?php echo $times; ?>" />
                                                        <p><?php echo date('j F Y', strtotime($today)); ?></p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="booktype">Booking Type (ประเภท)</label>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="booktype_join" name="booking_type" class="custom-control-input customer_type" value="1" checked onchange="check_date();" />
                                                        <label class="custom-control-label" for="booktype_join">Join</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="booktype_private" name="booking_type" class="custom-control-input customer_type" value="2" onchange="check_date();" />
                                                        <label class="custom-control-label" for="booktype_private">Private</label>
                                                    </div>
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
                                                            ?>
                                                                <option value="<?php echo $agent['id']; ?>"><?php echo $agent['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="frm-agent-outside" hidden>
                                                        <label for="agent_outside">Agent</label>
                                                        <input type="text" class="form-control" id="agent_outside" name="agent_outside" value="" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="voucher_no">Voucher Agent No.</label>
                                                    <input type="text" id="voucher_no" name="voucher_no" class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label" for="sender">Sender</label>
                                                    <input type="text" id="sender" name="sender" class="form-control" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="cus_name">Customer Name</label>
                                                    <input type="text" class="form-control" id="cus_name" name="cus_name" value="" />
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="cus_telephone">Telephone</label>
                                                    <input type="text" class="form-control" id="cus_telephone" name="cus_telephone" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Detail -->
                                    <!-- Start Form Booking Product Detail -->
                                    <div id="div-show"></div>
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5">
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Program Detail</h5>
                                            <input type="hidden" id="bp_id" value="0">
                                            <input type="hidden" id="pror_id" name="pror_id" value="">
                                        </div>
                                        <div class="card-body mt-2">
                                            <div class="row">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="travel_date">Travel Date (วันที่เที่ยว)</label><br>
                                                        <input type="text" class="form-control" id="travel_date" name="travel_date" value="<?php echo $today; ?>" onchange="search_program();" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="product_id">Programe (สินค้าหลัก)</label>
                                                        <select class="form-control select2" id="product_id" name="product_id" onchange="search_program();">
                                                            <?php
                                                            $prods = $bookObj->show_product();
                                                            foreach ($prods as $prod) {
                                                            ?>
                                                                <option value="<?php echo $prod['id']; ?>"><?php echo $prod['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="category_id">Categorys (สินค้ารอง)</label>
                                                        <select class="form-control select2" id="category_id" name="category_id" onchange="check_category();">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="form-group col-md-3 col-12">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="adult">Adult (ผู้ใหญ่)</label>
                                                                    <input type="text" class="form-control numeral-mask" id="adult" name="adult" oninput="duplicate_pax('adult');" value="0" />
                                                                </div>
                                                            </td>
                                                            <td class="td-x"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td id="td-adult">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_adult">Rate Adult (ราคาผู้ใหญ่)</label>
                                                                    <input type="text" id="rate_adult" name="rate_adult" class="form-control numeral-mask" value="" oninput="check_rate();">
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
                                                                    <input type="text" class="form-control numeral-mask" id="child" name="child" oninput="duplicate_pax('child');" value="0" />
                                                                </div>
                                                            </td>
                                                            <td class="td-x"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td id="td-child">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_child">Rate Children (ราคาเด็ก)</label>
                                                                    <input type="text" id="rate_child" name="rate_child" class="form-control numeral-mask" value="" oninput="check_rate();">
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
                                                                    <input type="text" class="form-control numeral-mask" id="infant" name="infant" oninput="duplicate_pax('infant');" value="0" />
                                                                </div>
                                                            </td>
                                                            <td class="td-x"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td id="td-infant">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_infant">Rate Infant (ราคาทารก)</label>
                                                                    <input type="text" id="rate_infant" name="rate_infant" class="form-control numeral-mask" value="" oninput="check_rate();">
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
                                                                    <input type="text" class="form-control numeral-mask" id="foc" name="foc" oninput="duplicate_pax('infant');" value="0" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="form-group col-md-2 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="cot">COT</label>
                                                        <input type="text" class="form-control numeral-mask" id="cot" name="cot" value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="bp_note">Note (หมายเหตุ)</label>
                                                        <textarea class="form-control" name="bp_note" id="bp_note" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="div-total">
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="rate_total">Total (รวมทั้งหมด)</label>
                                                        <input type="text" class="form-control numeral-mask" id="rate_total" name="rate_total" onchange="check_rate('input');" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Product Detail -->
                                    <!-- Start Form Customer Detail -->
                                    <div class="card shadow-none bg-transparent border-secondary border-lighten-5" hidden>
                                        <div class="card-header bg-light-secondary pt-1 pb-50 pl-1">
                                            <h5>Customers Detail</h5>
                                        </div>
                                        <div class="card-body mt-2">
                                            <div class="itinerary-repeater">
                                                <div data-repeater-list="itinerary">
                                                    <div data-repeater-item>
                                                        <div class="row d-flex align-items-start">
                                                            <div class="col-md-1 col-12">
                                                                <div class="form-group">
                                                                    <label for="age">ผู้ใหญ่/เด็ก/ทารก</label>
                                                                    <select class="form-control" name="cus_age">
                                                                        <option value=""></option>
                                                                        <option value="1">Adult (ผู้ใหญ่)</option>
                                                                        <option value="2">Child (เด็ก)</option>
                                                                        <option value="3">Infant (ทารก)</option>
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
                                                                    <label for="name">Name (ชื่อ)</label>
                                                                    <input type="text" class="form-control" name="cus_name" aria-describedby="name" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-12">
                                                                <div class="form-group">
                                                                    <label for="birth_date">Birth Date (ว/ด/ป เกิด)</label>
                                                                    <input type="date" class="form-control birth-date" name="cus_birth_date" aria-describedby="birth_date" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-12">
                                                                <div class="form-group">
                                                                    <label for="telephone">Telephone/WhatsApp (เบอร์โทร)</label>
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
                                                                    <label for="cus_type">Thai/Foreigner (ไทย/ต่างชาติ)</label>
                                                                    <select class="form-control" name="cus_type">
                                                                        <option value=""></option>
                                                                        <option value="1">Thai (ไทย)</option>
                                                                        <option value="2">Foreigner (ต่างชาติ)</option>
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                                            <div class="col-md-1 col-12 mb-50 mt-2">
                                                                <div class="form-group">
                                                                    <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                        <i data-feather="x"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr />
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-outline-primary mr-50" type="button" id="data-repeater-create" data-repeater-create>
                                                            <i data-feather="plus" class="mr-25"></i>
                                                            <span>เพิ่มข้อมูลลูกค้า</span>
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
                                                        <input type="radio" id="pickup_type_1" name="pickup_type" class="custom-control-input" value="1" onclick="check_pickup_type();" checked />
                                                        <label class="custom-control-label" for="pickup_type_1">เอารถรับส่ง</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="pickup_type_2" name="pickup_type" class="custom-control-input" value="2" onclick="check_pickup_type();" />
                                                        <label class="custom-control-label" for="pickup_type_2">เดินทางมาเอง</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 col-12">
                                                    <label class="form-label">Transfer Type </label>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="transfer_type_join" name="transfer_type" class="custom-control-input" value="1" checked onchange="check_transfer_type();" />
                                                        <label class="custom-control-label" for="transfer_type_join">Join</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="transfer_type_private" name="transfer_type" class="custom-control-input" value="2" onchange="check_transfer_type();" />
                                                        <label class="custom-control-label" for="transfer_type_private">Private</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3 col-12">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="30%">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="tran_adult_pax">Adult (ผู้ใหญ่)</label>
                                                                    <input type="text" class="form-control numeral-mask" id="tran_adult_pax" name="tran_adult_pax" oninput="check_rate_transfer();" value="" />
                                                                </div>
                                                            </td>
                                                            <td width="1%" name="td-transfer"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td width="69%" name="td-transfer">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="tran_adult">Rate Adult (ราคาผู้ใหญ่)</label>
                                                                    <input type="text" id="tran_adult" name="tran_adult" class="form-control numeral-mask" value="" oninput="check_rate_transfer();">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="form-group col-md-3 col-12">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="30%">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="tran_child_pax">Children (เด็ก)</label>
                                                                    <input type="text" class="form-control numeral-mask" id="tran_child_pax" name="tran_child_pax" oninput="check_rate_transfer();" value="" />
                                                                </div>
                                                            </td>
                                                            <td width="1%" name="td-transfer"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td width="69%" name="td-transfer">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="tran_child">Rate Children (ราคาเด็ก)</label>
                                                                    <input type="text" id="tran_child" name="tran_child" class="form-control numeral-mask" value="" oninput="check_rate_transfer();">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="form-group col-md-3 col-12">
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="30%">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="tran_infant_pax">Infant (ทารก)</label>
                                                                    <input type="text" class="form-control numeral-mask" id="tran_infant_pax" name="tran_infant_pax" oninput="check_rate_transfer();" value="" />
                                                                </div>
                                                            </td>
                                                            <td width="1%" name="td-transfer"><i data-feather='x' class="m-1 font-medium-4"></i></td>
                                                            <td width="69%" name="td-transfer">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="tran_infant">Rate Infant (ราคาทารก)</label>
                                                                    <input type="text" id="tran_infant" name="tran_infant" class="form-control numeral-mask" value="" oninput="check_rate_transfer();">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="form-group col-md-1 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="tran_foc_pax">FOC</label>
                                                        <input type="text" class="form-control numeral-mask" id="tran_foc_pax" name="tran_foc_pax" value="" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <table>
                                                        <tr>
                                                            <td width="100%" colspan="3"><label for="start_pickup">Pickup Time (เวลารับ)</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="45%">
                                                                <input type="text" id="start_pickup" name="start_pickup" class="form-control time-mask text-left" placeholder="HH:MM" value="" />
                                                            </td>
                                                            <td width="10%" align="center"> - </td>
                                                            <td width="45%">
                                                                <input type="text" id="end_pickup" name="end_pickup" class="form-control time-mask text-left" placeholder="HH:MM" value="" />
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
                                                            ?>
                                                                <option value="<?php echo $zone['id']; ?>" data-start-pickup="<?php echo date("H:i", strtotime($zone['start_pickup'])); ?>" data-end-pickup="<?php echo date("H:i", strtotime($zone['end_pickup'])); ?>"><?php echo $zone['name']; ?></option>
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
                                                            ?>
                                                                <option value="<?php echo $hotel['id']; ?>" data-zone="<?php echo $hotel['zone_id']; ?>"><?php echo $hotel['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="hotel_pickup_outside">Pickup Outside (ระบุสถานที่นอก)</label>
                                                        <input type="text" id="hotel_pickup_outside" name="hotel_pickup_outside" class="form-control" value="" />
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
                                                            ?>
                                                                <option value="<?php echo $dropoff['id']; ?>"><?php echo $dropoff['name']; ?></option>
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
                                                            ?>
                                                                <option value="<?php echo $hotel['id']; ?>" data-zone="<?php echo $hotel['zone_id']; ?>"><?php echo $hotel['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="hotel_dropoff_outside">Dropoff Outside (ระบุสถานที่นอก)</label>
                                                        <input type="text" id="hotel_dropoff_outside" name="hotel_dropoff_outside" class="form-control" placeholder="ที่เดียวกับสถานที่รับ" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="trans_note">Note (Transfer Detail)</label>
                                                        <textarea class="form-control" name="trans_note" id="trans_note" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" <?php echo $account; ?>>
                                                <div class="form-group col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label" for="tran_total_price">Total Transfer (รวมทั้งหมด)</label>
                                                        <input type="text" id="tran_total_price" name="tran_total_price" class="form-control numeral-mask" value="0" readonly />
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
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <button class="btn btn-outline-primary mr-50" type="button" data-repeater-create>
                                                            <i data-feather="plus" class="mr-25"></i>
                                                            <span>เพิ่มข้อมูลค่าใช้จ่ายเพิ่มเติม</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Booking Extra Charge Detail -->
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <span></span>
                                        <button class="btn btn-primary btn-submit">
                                            <span class="align-middle d-sm-inline-block d-none btn-page-block-spinner">Submit</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /jQuery Validation -->
                </div>
            </section>
            <!-- /Validation -->
        </div>
    </div>
</div>

<?php
$close_conn = $bookObj->close();
?>