<?php
require_once 'controllers/Order.php';

$manageObj = new Order();
$times = date("H:i:s");
$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime(" +1 day"));
// $today = '2024-11-01';
// $tomorrow = '2024-11-02';

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
                                        <form id="invoice-search-form" name="invoice-search-form" method="get" enctype="multipart/form-data">
                                            <div class="d-flex align-items-center mx-50 row pt-0 pb-0">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="travel_date">วันที่เที่ยว (Travel Date)</label></br>
                                                        <input type="text" class="form-control flatpickr-range" id="travel_date" name="travel_date" value="<?php echo $today; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div id="div-invoice-custom">

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
        </div>

        <!-- Start Form Modal -->
        <!------------------------------------------------------------------>
        <div class="modal-size-xl d-inline-block">
            <div class="modal fade text-left" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel17">Check-IN</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="div-checkin-image" style="background-color: #FFF !important;">
                            <div class="table-responsive">
                                <div class="text-center mb-50">
                                    <h4><b id="text-travel">Travel date</b></h4>
                                </div>
                                <div class="text-center mb-50">
                                    <h2>
                                        <div class="badge badge-pill badge-light-warning"><b class="text-danger" id="text-boat">เรือ</b></div>
                                    </h2>
                                </div>
                                <table class="table table-striped text-uppercase table-vouchure-t2">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" width="1%">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input dt-checkboxes" type="checkbox" id="checkall" onclick="checkbox();" />
                                                    <label class="custom-control-label" for="checkall"></label>
                                                </div>
                                            </th>
                                            <th width="5%">เวลารับ</th>
                                            <th width="5%">Driver</th>
                                            <th width="15%">เอเยนต์</th>
                                            <th width="15%">ชื่อลูกค้า</th>
                                            <th width="5%">V/C</th>
                                            <th width="50%">โรงแรม</th>
                                            <th width="9%">ห้อง</th>
                                            <th class="text-center" width="1%">A</th>
                                            <th class="text-center" width="1%">C</th>
                                            <th class="text-center" width="1%">Inf</th>
                                            <th class="text-center" width="1%">FOC</th>
                                            <th width="5%">COT</th>
                                            <!-- <th>Remark</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="table-tbody-booking">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <input type="hidden" id="park_img" value="ใบงานอุทยาน">
                            <div>
                                <button type="button" class="btn btn-info btn-page-block-spinner" onclick="download_image();">Image</button>
                                <a href='./?pages=order-boat/print&action=check_in' target="_blank" id="print-check"><button class="btn btn-info">Print</button></a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success btn-page-block-spinner" onclick="submit_check_in();">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------------------------>
        <!-- End Form Modal -->
    </div>
</div>