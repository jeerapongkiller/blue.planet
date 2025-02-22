<?php
require_once 'controllers/Order.php';

$orderObj = new Order();

$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime(" +1 day"));
// $today = '2024-09-29';
// $tomorrow = '2024-09-30';
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

                                        <form id="agent-search-form" name="agent-search-form" method="get" enctype="multipart/form-data">
                                            <div class="d-flex align-items-center mx-50 row pt-0 pb-0">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="travel_date">วันที่เที่ยว (Travel Date)</label></br>
                                                        <input type="text" class="form-control date-picker" id="travel_date" name="travel_date" value="<?php echo $today; ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-12">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div id="div-agent-custom">

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
            <!-- Modal end -->

        </div>
    </div>
</div>