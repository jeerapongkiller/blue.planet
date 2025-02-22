<?php
require_once 'controllers/Receipt.php';

$recObj = new Receipt();
$times = date("H:i:s");
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime(" +1 day"));
// $today = '2024-12-16';
// $tomorrow = '2024-12-16';
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic tabs start -->
            <section id="basic-tabs-components">
                <div class="row match-height">
                    <!-- Basic Tabs starts -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" aria-controls="today" role="tab" aria-selected="true">Today</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tomorrow-tab" data-toggle="tab" href="#tomorrow" aria-controls="tomorrow" role="tab" aria-selected="false">Tomorrow</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tab" data-toggle="tab" href="#custom" aria-controls="custom" role="tab" aria-selected="false">Custom</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="today" aria-labelledby="today-tab" role="tabpanel">
                                    </div>
                                    <div class="tab-pane" id="tomorrow" aria-labelledby="tomorrow-tab" role="tabpanel">
                                    </div>
                                    <div class="tab-pane" id="custom" aria-labelledby="custom-tab" role="tabpanel">

                                        <form id="receipt-search-form" name="receipt-search-form" method="get" enctype="multipart/form-data">
                                            <div class="d-flex align-items-center mx-50 row pt-0 pb-0">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="travel_date">วันที่เดินทาง (Travel Date)</label></br>
                                                        <input type="text" class="form-control flatpickr-range" id="travel_date" name="travel_date" value="<?php echo $today; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div id="div-receipt-custom">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Basic Tabs ends -->
                </div>
            </section>
            <!-- Basic Tabs end -->

            <!-- Modal start -->
            <div class="modal fade text-left" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content" id="div-modal-detail">
                        <div class="modal-header">
                            <h4 class="modal-title" id="h4-agent-name"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left" id="modal-receipt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content" id="div-modal-detail">
                        <div class="modal-header">
                            <h4 class="modal-title">สร้าง Receipt</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="receipt-form" name="receipt-form" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="cover_id" name="cover_id" value="">
                                <input type="hidden" id="today" name="today" value="<?php echo $today; ?>">
                                <input type="hidden" id="amount" name="amount" value="">
                                <div id="div-show"></div>
                                <div class="row">
                                    <div class="form-group col-md-3 col-12">
                                        <label class="form-label" for="is_approved"></label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" checked />
                                            <label class="custom-control-label" for="is_approved">ชำระเงินแล้ว</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" hidden>
                                    <div class="form-group col-md-3 col-12">
                                        <label for="rec_no">ใบเสร็จรับเงิน</label>
                                        <input type="hidden" id="rec_no" name="rec_no" value="">
                                        <input type="hidden" id="rec_full" name="rec_full" value="">
                                        <div class="input-group">
                                            <span id="rec_no_text"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3 col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="rec_date">วันที่ชำระ</label></br>
                                            <input type="text" class="form-control" id="rec_date" name="rec_date" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="content-header">
                                            <h5 class="mt-1">การชำระเงิน</h5>
                                        </div>
                                        <hr class="mt-0">
                                    </div>
                                    <div class="form-group col-md-3 col-12">
                                        <div class="form-group">
                                            <?php $payments = $recObj->showpayments(2); ?>
                                            <label for="payments_type">รูปแบบการชำระเงิน</label>
                                            <select class="form-control select2" id="payments_type" name="payments_type" onchange="check_payment();">
                                                <option value="">Please choose payments type ... </option>
                                                <?php
                                                foreach ($payments as $payment) {
                                                ?>
                                                    <option value="<?php echo $payment['id']; ?>" data-name="<?php echo $payment['name']; ?>"><?php echo $payment['name']; ?></option>
                                                <?php
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12" id="div-bank-account" hidden>
                                        <div class="form-group">
                                            <?php $banks_acc = $recObj->showbankaccount(); ?>
                                            <label for="bank_account">เข้าบัญชี</label>
                                            <select class="form-control select2" id="bank_account" name="bank_account">
                                                <option value="">Please choose bank account ... </option>
                                                <?php
                                                foreach ($banks_acc as $bank_acc) {
                                                ?>
                                                    <option value="<?php echo $bank_acc['id']; ?>" data-name="<?php echo $bank_acc['account_name']; ?>"><?php echo $bank_acc['banName'] . ' ' . $bank_acc['account_no'] . ' (' . $bank_acc['account_name'] . ')'; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12" id="div-bank" hidden>
                                        <div class="form-group">
                                            <?php $banks = $recObj->showbank(); ?>
                                            <label for="rec_bank">ธนาคาร</label>
                                            <select class="form-control select2" id="rec_bank" name="rec_bank">
                                                <option value="">Please choose bank ... </option>
                                                <?php
                                                foreach ($banks as $bank) {
                                                ?>
                                                    <option value="<?php echo $bank['id']; ?>" data-name="<?php echo $bank['name']; ?>"><?php echo $bank['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12" id="div-check-no" hidden>
                                        <div class="form-group">
                                            <label class="form-label" for="check_no">เลขที่เช็ค</label>
                                            <input type="text" id="check_no" name="check_no" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12" id="div-check-date" hidden>
                                        <div class="form-group">
                                            <label class="form-label" for="date_check">วันที่เช็ค</label></br>
                                            <input type="text" class="form-control" id="date_check" name="date_check" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12">
                                        <label>แนบรูปภาพ</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="file[]" />
                                            <label class="custom-file-label" for="file">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="div-multi-booking">
                                    <table class="table table-bordered">
                                        <tr class="table-content">
                                            <td width="50%" align="left" colspan="4">
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-4 text-right">
                                                        Company
                                                    </dt>
                                                    <dd class="col-sm-8" id="agent_name_text"></dd>
                                                </dl>
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-4 text-right">
                                                        Address
                                                    </dt>
                                                    <dd class="col-sm-8" id="agent_address_text"></dd>
                                                </dl>
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-4 text-right">
                                                        Tel
                                                    </dt>
                                                    <dd class="col-sm-8" id="agent_tel_text"></dd>
                                                </dl>
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-4 text-right">
                                                        Tax ID.
                                                    </dt>
                                                    <dd class="col-sm-8" id="agent_tax_text"></dd>
                                                </dl>
                                            </td>
                                            <td width="50%" align="left" colspan="2">
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-6 text-right">
                                                        Invoice No.
                                                    </dt>
                                                    <dd class="col-sm-6" id="inv_full_text"></dd>
                                                </dl>
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-6 text-right">
                                                        สำนักงาน
                                                    </dt>
                                                    <dd class="col-sm-6" id="branch_text"></dd>
                                                </dl>
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-6 text-right">
                                                        Departure Date
                                                    </dt>
                                                    <dd class="col-sm-6" id="inv_date_text"></dd>
                                                </dl>
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-6 text-right">
                                                        Due Date
                                                    </dt>
                                                    <dd class="col-sm-6" id="rec_date_text"></dd>
                                                </dl>
                                                <dl class="row" style="margin-bottom: 0;">
                                                    <dt class="col-sm-6 text-right">
                                                    </dt>
                                                    <dd class="col-sm-6" id="due_date_text"></dd>
                                                </dl>
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="table table-bordered">
                                        <thead class="bg-darken-2 text-white">
                                            <tr class="table-black">
                                                <td class="text-center" style="border-radius: 15px 0px 0px 0px; padding: 5px 0;" width="3%"><b>เลขที่</b></td>
                                                <td class="text-center"><b>วันที่เดินทาง</b></td>
                                                <td class="text-center"><b>ชื่อลูกค้า</b></td>
                                                <td class="text-center"><b>โปรแกรม</b></td>
                                                <td class="text-center"><b>หมายเลข</b></td>
                                                <td class="text-center" colspan="2"><b>จํานวน</b></td>
                                                <td class="text-center" colspan="2"><b>ราคาต่อหน่วย</b></td>
                                                <td class="text-center"><b>ส่วนลด</b></td>
                                                <td class="text-center"><b>จำนวนเงิน</b></td>
                                                <td class="text-center" style="border-radius: 0px 15px 0px 0px;"><b>Cash on tour</b></td>
                                            </tr>
                                            <tr class="table-black-2">
                                                <td class="text-center p-50"><small>Items</small></td>
                                                <td class="text-center p-50"><small>Date</small></td>
                                                <td class="text-center p-50"><small>Customer's name</small></td>
                                                <td class="text-center p-50"><small>Programe</small></td>
                                                <td class="text-center p-50"><small>Voucher No.</small></td>
                                                <td class="text-center p-50"><small>Adult</small></td>
                                                <td class="text-center p-50"><small>Child</small></td>
                                                <td class="text-center p-50"><small>Adult</small></td>
                                                <td class="text-center p-50"><small>Child</small></td>
                                                <td class="text-center p-50"><small>Discount</small></td>
                                                <td class="text-center p-50"><small>Amounth</small></td>
                                                <td class="text-center p-50"><small>เงินมัดจำ</small></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-multi-booking">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="note">Note</label>
                                            <textarea class="form-control" name="note" id="note" rows="3"></textarea>
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
            <!-- Modal end -->
        </div>
    </div>
</div>