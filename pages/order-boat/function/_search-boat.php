<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Manage.php';

$manageObj = new Manage();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $date_travel_search = $_POST['date_travel_search'] != "" ? $_POST['date_travel_search'] : $tomorrow->format("Y-m-d");
    $search_boat = $_POST['search_boat'] != "" ? $_POST['search_boat'] : 'all';

    $first_manage = [];
    $first_bo = [];
    $first_trans = [];
    $first_paid = [];
    $first_ext = [];
    $sum_ad = 0;
    $sum_chd = 0;
    $sum_inf = 0;
    $sum_foc = 0;
    $name_img = '';
    # --- get data --- #
    $manages = $manageObj->showlistboats('list', 0, $date_travel_search, 'all', $search_boat);
    if (!empty($manages)) {
        foreach ($manages as $manage) {
            if (in_array($manage['mange_id'], $first_manage) == false) {
                $first_manage[] = $manage['mange_id'];
                $mange['id'][] = !empty($manage['mange_id']) ? $manage['mange_id'] : 0;
                $mange['color_id'][] = !empty($manage['color_id']) ? $manage['color_id'] : 0;
                $mange['color_name'][] = !empty($manage['color_name_th']) ? $manage['color_name_th'] : '';
                $mange['color_hex'][] = !empty($manage['color_hex']) ? $manage['color_hex'] : '';
                $mange['time'][] = !empty($manage['manage_time']) ? date('H:i', strtotime($manage['manage_time'])) : '00:00';
                $mange['boat_id'][] = !empty($manage['boat_id']) ? $manage['boat_id'] : 0;
                $mange['boat_name'][] = !empty($manage['boat_id']) ? !empty($manage['boat_name']) ? $manage['boat_name'] : '' : $manage['outside_boat'];
                $mange['guide_id'][] = !empty($manage['guide_id']) ? $manage['guide_id'] : 0;
                $mange['guide_name'][] = !empty($manage['guide_id']) ? !empty($manage['guide_name']) ? $manage['guide_name'] : '' : $manage['outside_guide'];
                $mange['captain_id'][] = !empty($manage['captain_id']) ? $manage['captain_id'] : 0;
                $mange['captain_name'][] = !empty($manage['captain_id']) ?  $manage['captain_name'] : $manage['outside_captain'];
                $mange['crewf_id'][] = !empty($manage['crewf_id']) ? $manage['crewf_id'] : 0;
                $mange['crews_id'][] = !empty($manage['crews_id']) ? $manage['crews_id'] : 0;
                $mange['crewf_name'][] = !empty($manage['crewf_id']) ? $manage['crewf_name'] : '';
                $mange['product_id'][] = !empty($manage['product_id']) ? $manage['product_id'] : 0;
                $mange['product_name'][] = !empty($manage['product_name']) ? $manage['product_name'] : '';
                $mange['booktye_name'][] = !empty($manage['booktye_name']) ? $manage['booktye_name'] : '';
                $mange['pier_name'][] = !empty($manage['pier_name']) ? $manage['pier_name'] : '';
                $mange['outside_boat'][] = !empty($manage['outside_boat']) ? $manage['outside_boat'] : '';
                $mange['outside_guide'][] = !empty($manage['outside_guide']) ? $manage['outside_guide'] : '';
                $mange['outside_captain'][] = !empty($manage['outside_captain']) ? $manage['outside_captain'] : '';
            }

            if (in_array($manage['id'], $first_bo) == false) {
                $first_bo[] = $manage['id'];
                $book['id'][$manage['mange_id']][] = !empty($manage['id']) ? $manage['id'] : 0;
                $book['voucher'][$manage['mange_id']][] = !empty($manage['voucher_no_agent']) ? $manage['voucher_no_agent'] : '';
                $book['book_full'][$manage['mange_id']][] = !empty($manage['book_full']) ? $manage['book_full'] : '';
                $book['sender'][$manage['mange_id']][] = !empty($manage['sender']) ? $manage['sender'] : '';
                $book['start_pickup'][$manage['mange_id']][] = !empty($manage['start_pickup']) ? date('H:i', strtotime($manage['start_pickup'])) : '';
                $book['hotel'][$manage['mange_id']][] = !empty($manage['hotel_name']) ? $manage['hotel_name'] : '';
                $book['room_no'][$manage['mange_id']][] = !empty($manage['room_no']) ? $manage['room_no'] : '';
                $book['cus_name'][$manage['mange_id']][] = !empty($manage['cus_name']) ? $manage['cus_name'] : '';
                $book['comp_name'][$manage['mange_id']][] = !empty($manage['comp_name']) ? $manage['comp_name'] : '';
                $book['adult'][$manage['mange_id']][] = !empty($manage['bpr_adult']) ? $manage['bpr_adult'] : 0;
                $book['child'][$manage['mange_id']][] = !empty($manage['bpr_child']) ? $manage['bpr_child'] : 0;
                $book['infant'][$manage['mange_id']][] = !empty($manage['bpr_infant']) ? $manage['bpr_infant'] : 0;
                $book['foc'][$manage['mange_id']][] = !empty($manage['bpr_foc']) ? $manage['bpr_foc'] : 0;
                $book['rate_adult'][$manage['mange_id']][] = !empty($manage['rate_adult']) ? $manage['rate_adult'] : 0;
                $book['rate_child'][$manage['mange_id']][] = !empty($manage['rate_child']) ? $manage['rate_child'] : 0;
                $book['rate_infant'][$manage['mange_id']][] = !empty($manage['rate_infant']) ? $manage['rate_infant'] : 0;
                $book['rate_private'][$manage['mange_id']][] = !empty($manage['rate_private']) ? $manage['rate_private'] : 0;
                $book['discount'][$manage['mange_id']][] = !empty(!empty($manage['bp_discount'])) ? $manage['bp_discount'] : 0;
                $book['note'][$manage['mange_id']][] = !empty($manage['bp_note']) ? $manage['bp_note'] : '';
                $book['total'][$manage['mange_id']][] = $manage['booktye_id'] == 1 ? ($manage['bpr_adult'] * $manage['rate_adult']) + ($manage['bpr_child'] * $manage['rate_child']) + ($manage['rate_infant'] * $manage['rate_infant']) : $manage['rate_private'];
            }

            if ((in_array($manage['bopa_id'], $first_paid) == false) && !empty($manage['bopa_id'])) {
                $first_paid[] = $manage['bopa_id'];
                $pay['id'][$manage['id']][] = !empty($manage['bopa_id']) ? $manage['bopa_id'] : 0;
                $pay['pay_id'][$manage['id']][] = !empty($manage['bopay_id']) ? $manage['bopay_id'] : 0;
                $pay['pay_name'][$manage['id']][] = !empty($manage['bopay_name']) ? $manage['bopay_name'] : '';
                $pay['total'][$manage['id']][] = !empty($manage['bopa_total']) ? $manage['bopa_total'] : 0;
            }

            if ((in_array($manage['bec_id'], $first_ext) == false) && !empty($manage['bec_id'])) {
                $first_ext[] = $manage['bec_id'];
                $extar['bec_id'][$manage['id']][] = !empty($manage['bec_id']) ? $manage['bec_id'] : 0;
                $extar['bec_name'][$manage['id']][] = !empty($manage['bec_name']) ? $manage['bec_name'] : $manage['extra_name'];
                $extar['bec_total'][$manage['id']][] = !empty($manage['bec_total']) ? $manage['bec_total'] : 0;
                $extar['expay_id'][$manage['id']][] = !empty($manage['expay_id']) ? $manage['expay_id'] : 0;
                $extar['expay_total'][$manage['id']][] = !empty($manage['bec_total_paid']) ? $manage['bec_total_paid'] : 0;
            }

            if (in_array($manage['bt_id'], $first_trans) == false) {
                $first_trans[] = $manage['bt_id'];
                $trans['id'][$manage['id']][] = !empty($manage['bt_id']) ? $manage['bt_id'] : 0;
                $trans['return'][$manage['id']][] = !empty($manage['return_type']) ? $manage['return_type'] : 0;
                $trans['hotel'][$manage['id']][] = !empty($manage['hotel_name']) ? $manage['hotel_name'] : '';

                $trans['manget_id'][$manage['id']][] = !empty($manage['manget_id']) ? $manage['manget_id'] : '';
                $trans['driver'][$manage['id']][] = !empty($manage['driver_id']) ? $manage['driver_name'] : $manage['outside_driver'];
            }
        }
?>
        <div class="content-header">
            <div class="pl-1">
                <a href="./?pages=manage-boat/print&action=print&date_travel=<?php echo $date_travel_search; ?>&boat=<?php echo $search_boat; ?>" target="_blank" class="btn btn-info">Print</a>
                <a href="javascript:void(0)" hidden><button type="button" class="btn btn-info" value="image" onclick="download_image();">Image</button></a>
                <a href="javascript:void(0);" class="btn btn-info disabled" hidden>Download as PDF</a>
            </div>
        </div>
        <hr class="pb-0 pt-0">
        <!-- Body START -->
        <div id="div-driver-job-image" style="background-color: #FFF;">
            <!-- Body start -->
            <div class="row" id="basic-table">
                <?php if (!empty($mange['id'])) {
                    for ($i = 0; $i < count($mange['id']); $i++) { ?>
                        <div class="col-12">
                            <table class="w-100">
                                <tr>
                                    <td width="200" height="190">
                                        <div class="logo-wowandaman"><img src="app-assets/images/logo/logo-500.png" alt="wow andaman">
                                        </div>
                                    </td>
                                    <td class="pr-1">
                                        <div class="badge-purple-big">
                                            <table class="w-100">
                                                <tr>
                                                    <td class="border-right-white-1">
                                                        <h2 class="text-white text-uppercase">Wow Andaman Co.,LTD</h2>
                                                        <h4 class="text-white"><?php echo date('j F Y', strtotime($date_travel_search)); ?></h4>
                                                    </td>
                                                    <td class="pl-1 pr-1">
                                                        <table class="w-100 text-nowrap">
                                                            <tr>
                                                                <td class="text-right">ไกด์ : &nbsp;</td>
                                                                <td><?php echo $mange['guide_name'][$i]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-right">สตาฟ : &nbsp;</td>
                                                                <td><?php echo $mange['crewf_name'][$i]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-right">กัปตัน : &nbsp;</td>
                                                                <td><?php echo $mange['captain_name'][$i]; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <div class="badge-white d-block mb-1"><?php echo $mange['product_name'][$i]; ?></div>
                                                        <div class="badge-light-green d-block" style="background-color: <?php echo $mange['color_hex'][$i]; ?>;"><?php echo $mange['boat_name'][$i]; ?></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-bordered table-striped text-uppercase table-vouchure-t2">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Car</th>
                                        <th>Time</th>
                                        <th>Hotel</th>
                                        <th>Room</th>
                                        <th>Client</th>
                                        <th class="text-center">A</th>
                                        <th class="text-center">C</th>
                                        <th class="text-center">Inf</th>
                                        <th class="text-center">FOC</th>
                                        <th>AGENT</th>
                                        <th>SENDER</th>
                                        <th>V/C</th>
                                        <th>COT</th>
                                        <th>Drop off</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($book['id'][$mange['id'][$i]])) {
                                        for ($a = 0; $a < count($book['id'][$mange['id'][$i]]); $a++) {
                                            $text_cot = '';
                                            $id_cot = 0;
                                            $cot_total = $book['total'][$mange['id'][$i]][$a];
                                            # --- Payment for Booking --- #
                                            if (!empty($pay['id'][$book['id'][$mange['id'][$i]][$a]])) {
                                                for ($b = 0; $b < count($pay['id'][$book['id'][$mange['id'][$i]][$a]]); $b++) {
                                                    if ($pay['pay_id'][$book['id'][$mange['id'][$i]][$a]][$b] == 4) {
                                                        $text_cot = 'CASH ON TOUR';
                                                        $cot_total = $pay['total'][$book['id'][$mange['id'][$i]][$a]][$b];
                                                        $id_cot = $pay['pay_id'][$book['id'][$mange['id'][$i]][$a]][$b];
                                                    } elseif ($pay['pay_id'][$book['id'][$mange['id'][$i]][$a]][$b] == 5) {
                                                        $text_cot = 'CASH ON TOUR';
                                                        $cot_total = $cot_total - $pay['total'][$book['id'][$mange['id'][$i]][$a]][$b];
                                                        $id_cot = $pay['pay_id'][$book['id'][$mange['id'][$i]][$a]][$b];
                                                    } else {
                                                        $id_cot = $pay['pay_id'][$book['id'][$mange['id'][$i]][$a]][$b];
                                                        $text_cot = $pay['pay_name'][$book['id'][$mange['id'][$i]][$a]][$b];
                                                        $cot_total = 0;
                                                    }
                                                }
                                            } else {
                                                $text_cot = '-';
                                                $cot_total = 0;
                                                $id_cot = 0;
                                            }
                                            # --- Payment for Extar Charge
                                            if (!empty($extar['bec_id'][$book['id'][$mange['id'][$i]][$a]])) {
                                                for ($c = 0; $c < count($extar['bec_id'][$book['id'][$mange['id'][$i]][$a]]); $c++) {
                                                    if ($extar['expay_id'][$book['id'][$mange['id'][$i]][$a]][$c] == 4) {
                                                        $text_cot = 'CASH ON TOUR';
                                                        $cot_total = $cot_total + $extar['expay_total'][$book['id'][$mange['id'][$i]][$a]][$c];
                                                    } elseif ($extar['expay_id'][$book['id'][$mange['id'][$i]][$a]][$c] == 5) {
                                                        $text_cot = 'CASH ON TOUR';
                                                        $cot_total = $cot_total + $extar['expay_total'][$book['id'][$mange['id'][$i]][$a]][$c];
                                                    } else {
                                                        $cot_total = $cot_total;
                                                        $text_cot = $text_cot;
                                                    }
                                                }
                                            } else {
                                                $cot_total = $cot_total;
                                                $id_cot = $id_cot;
                                                $text_cot = $text_cot;
                                            }
                                            $text_cot = $id_cot == 3 ? 'P' : '-';
                                    ?>
                                            <tr>
                                                <td><?php echo $trans['driver'][$book['id'][$mange['id'][$i]][$a]][0]; ?></td>
                                                <td><?php echo $book['start_pickup'][$mange['id'][$i]][$a] != '00:00' ? $book['start_pickup'][$mange['id'][$i]][$a] : ''; ?></td>
                                                <td><?php echo (!empty($trans['return'][$book['id'][$mange['id'][$i]][$a]][0]) && $trans['return'][$book['id'][$mange['id'][$i]][$a]][0] == 1) ? !empty($trans['hotel'][$book['id'][$mange['id'][$i]][$a]][0]) ? $trans['hotel'][$book['id'][$mange['id'][$i]][$a]][0] : 'No Transfer' : '-'; ?></td>
                                                <td><?php echo $book['room_no'][$mange['id'][$i]][$a]; ?></td>
                                                <td><?php echo $book['cus_name'][$mange['id'][$i]][$a]; ?></td>
                                                <td class="text-center"><?php echo $book['adult'][$mange['id'][$i]][$a]; ?></td>
                                                <td class="text-center"><?php echo $book['child'][$mange['id'][$i]][$a]; ?></td>
                                                <td class="text-center"><?php echo $book['infant'][$mange['id'][$i]][$a]; ?></td>
                                                <td class="text-center"><?php echo $book['foc'][$mange['id'][$i]][$a]; ?></td>
                                                <td><?php echo $book['comp_name'][$mange['id'][$i]][$a]; ?></td>
                                                <td><?php echo $book['sender'][$mange['id'][$i]][$a]; ?></td>
                                                <td><?php echo !empty($book['voucher'][$mange['id'][$i]][$a]) ? $book['voucher'][$mange['id'][$i]][$a] : $book['book_full'][$mange['id'][$i]][$a]; ?></td>
                                                <td class="text-nowrap"><b class="text-danger"><?php echo $cot_total > 0 ? number_format($cot_total) : $text_cot; ?></b></td>
                                                <td><?php echo (!empty($trans['return'][$book['id'][$mange['id'][$i]][$a]][1]) && $trans['return'][$book['id'][$mange['id'][$i]][$a]][1] == 2) ? !empty($trans['hotel'][$book['id'][$mange['id'][$i]][$a]][1]) ? $trans['hotel'][$book['id'][$mange['id'][$i]][$a]][1] : 'No Transfer' : '-'; ?></td>
                                                <td><b class="text-info"><?php echo $book['note'][$mange['id'][$i]][$a]; ?></b></td>
                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>

                            <div class="text-center mt-2 mb-5">
                                <div class="badge-light-purple"><b class="text-danger pr-1 border-right-white-1">TOTAL <?php echo array_sum($book['adult'][$mange['id'][$i]]) + array_sum($book['child'][$mange['id'][$i]]) + array_sum($book['infant'][$mange['id'][$i]]) + array_sum($book['foc'][$mange['id'][$i]]); ?></b> TOTAL <?php echo !empty($book['adult'][$mange['id'][$i]]) ? array_sum($book['adult'][$mange['id'][$i]]) : '-'; ?> <?php echo !empty($book['child'][$mange['id'][$i]]) ? array_sum($book['child'][$mange['id'][$i]]) : '-'; ?> <?php echo !empty($book['infant'][$mange['id'][$i]]) ? array_sum($book['infant'][$mange['id'][$i]]) : '-'; ?> <?php echo !empty($book['foc'][$mange['id'][$i]]) ? array_sum($book['foc'][$mange['id'][$i]]) : '-'; ?> </div>
                            </div>

                            <div class="bg-light-purple">
                                <h2 class="text-center pt-2 pb-2 mb-0 text-black text-uppercase"><?php echo $mange['product_name'][$i] . ' (' . $mange['booktye_name'][$i] . ') ขึ้น' . $mange['pier_name'][$i] . ' ' . $mange['time'][$i] . ' น.'; ?></h2>
                            </div>

                            <div class="invoice-border">
                                <table class="table m-0">
                                    <tr>
                                        <td class="text-center">
                                            <h4>กรุณาแจกเสื้อชูชีพให้แขกทุกคนและเช็คจำนวนตีนกบทุกครั้งหากมีการสูญหาย ปรับ 500 บาท</h4>
                                        </td>
                                        <td class="text-center" style="background-color: <?php echo $mange['color_hex'][$i]; ?>;">
                                            <h4 class="text-black"><?php echo $mange['color_name'][$i]; ?></h4>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <hr class="m-0 text-black">

                        </div>
                <?php }
                } ?>
            </div>

            <!-- Body ends -->
            <input type="hidden" id="name_img" name="name_img" value="<?php echo $name_img; ?>">
        </div>
        <!-- Body END -->
<?php }
} ?>