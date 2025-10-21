<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "search" && !empty($_POST['category_id']) && !empty($_POST['dataCustomer']) && !empty($_POST['book_type'])) {
    # --- get value --- #
    $agent_id = !empty($_POST['agent_id']) && $_POST['agent_id'] != 'outside' ? $_POST['agent_id'] : 0;
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : 0;
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : 0;
    $travel_date = !empty($_POST['travel_date']) ? $_POST['travel_date'] : '0000-00-00';
    $book_type = !empty($_POST['book_type']) ? $_POST['book_type'] : 0;
    $dataCustomer = !empty($_POST['dataCustomer']) ? $_POST['dataCustomer'] : 0;

    $rate_arr = array();
    $rates = $bookObj->show_category_rate($agent_id, $category_id, $travel_date);
    if (!empty($rates)) {
        $rate_arr['periodid'] = !empty($rates[0]['periodid']) ? $rates[0]['periodid'] : 0;
        $rate_arr['prodrid'] = !empty($rates[0]['prodrid']) ? $rates[0]['prodrid'] : 0;
        $rate_arr['transfer'] = !empty($rates[0]['transfer']) ? $rates[0]['transfer'] : 1;
        $rate_arr['rate_adult'] = !empty($rates[0]['rate_adult']) ? $rates[0]['rate_adult'] : 0;
        $rate_arr['rate_child'] = !empty($rates[0]['rate_child']) ? $rates[0]['rate_child'] : 0;
        $rate_arr['rate_infant'] = !empty($rates[0]['rate_infant']) ? $rates[0]['rate_infant'] : 0;
        $rate_arr['rate_private'] = !empty($rates[0]['rate_private']) ? $rates[0]['rate_private'] : 0;
    } else {
        switch ($product_id) {
            case 1:
                $rate_arr['periodid'] = 0;
                $rate_arr['prodrid'] = 0;
                $rate_arr['transfer'] = 1;
                $rate_arr['rate_adult'] = 0;
                $rate_arr['rate_child'] = 0;
                $rate_arr['rate_infant'] = 0;
                $rate_arr['rate_private'] = 0;
                break;
            case 2:
                $rate_arr['periodid'] = 0;
                $rate_arr['prodrid'] = 0;
                $rate_arr['transfer'] = 1;
                $rate_arr['rate_adult'] = 0;
                $rate_arr['rate_child'] = 0;
                $rate_arr['rate_infant'] = 0;
                $rate_arr['rate_private'] = 0;
                break;
            case 3:
                $rate_arr['periodid'] = 0;
                $rate_arr['prodrid'] = 0;
                $rate_arr['transfer'] = 1;
                $rate_arr['rate_adult'] = 0;
                $rate_arr['rate_child'] = 0;
                $rate_arr['rate_infant'] = 0;
                $rate_arr['rate_private'] = 0;
                break;
            case 4:
                $rate_arr['periodid'] = 0;
                $rate_arr['prodrid'] = 0;
                $rate_arr['transfer'] = 1;
                $rate_arr['rate_adult'] = 0;
                $rate_arr['rate_child'] = 0;
                $rate_arr['rate_infant'] = 0;
                $rate_arr['rate_private'] = 0;
                break;
        }
    }
?>
    <?php if ($dataCustomer == 1) { ?> <!--  Thai -->
        <input type="hidden" id="bpr_thai_id" name="bpr_thai_id" value="" />
        <input type="hidden" id="category_id_thai" name="category_id_thai" value="<?php echo $category_id; ?>" />
        <input type="hidden" id="pror_id_thai" name="pror_id_thai" value="<?php echo !empty($rate_arr['prodrid']) ? $rate_arr['prodrid'] : 0; ?>" />
        <?php if ($book_type == 1) { ?> <!--  Join -->
            <div class="form-group col-md-3 col-12">
                <table width="100%" id="table-adult-thai">
                    <tr>
                        <td width="30%">
                            <div class="form-group">
                                <label class="form-label" for="adult_thai">Adult (Thai)</label>
                                <input type="number" class="form-control" id="adult_thai" name="adult_thai" value="0" oninput="rows_customer();" />
                            </div>
                        </td>
                        <td width="1%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x m-1 font-medium-4">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </td>
                        <td width="69%">
                            <div class="form-group">
                                <label class="form-label" for="rate_adult_thai">Rate Adult (Thai)</label>
                                <input type="number" id="rate_adult_thai" name="rate_adult_thai" class="form-control numeral-mask" value="<?php echo !empty($rate_arr['rate_adult']) ? $rate_arr['rate_adult'] : 0; ?>" oninput="check_rate();">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group col-md-3 col-12">
                <table width="100%" id="table-child-thai">
                    <tr>
                        <td width="30%">
                            <div class="form-group">
                                <label class="form-label" for="child_thai">Children (Thai)</label>
                                <input type="number" class="form-control numeral-mask" id="child_thai" name="child_thai" value="0" oninput="rows_customer();" />
                            </div>
                        </td>
                        <td width="1%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x m-1 font-medium-4">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </td>
                        <td width="69%">
                            <div class="form-group">
                                <label class="form-label" for="rate_child_thai">Rate Children (Thai)</label>
                                <input type="number" id="rate_child_thai" name="rate_child_thai" class="form-control numeral-mask" value="<?php echo !empty($rate_arr['rate_child']) ? $rate_arr['rate_child'] : 0; ?>" oninput="check_rate();">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group col-md-3 col-12">
                <table width="100%" id="table-infant-thai">
                    <tr>
                        <td width="30%">
                            <div class="form-group">
                                <label class="form-label" for="infant_thai">Infant (Thai)</label>
                                <input type="number" class="form-control numeral-mask" id="infant_thai" name="infant_thai" value="0" oninput="rows_customer();" />
                            </div>
                        </td>
                        <td width="1%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x m-1 font-medium-4">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </td>
                        <td width="69%">
                            <div class="form-group">
                                <label class="form-label" for="rate_infant_thai">Rate Infant (Thai)</label>
                                <input type="number" id="rate_infant_thai" name="rate_infant_thai" class="form-control numeral-mask" value="<?php echo !empty($rate_arr['rate_infant']) ? $rate_arr['rate_infant'] : 0; ?>" oninput="check_rate();">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group col-md-2 col-12">
                <label class="form-label" for="foc_thai">FOC (Thai)</label>
                <input type="number" class="form-control numeral-mask" id="foc_thai" name="foc_thai" value="0" oninput="rows_customer();" />
            </div>
            <input type="hidden" id="rate_total_thai" name="rate_total_thai" value="0">
        <?php } elseif ($book_type == 2) { ?> <!--  Private -->
            <div class="form-group col-md-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="adult_thai">Adult (Thai)</label>
                    <input type="number" class="form-control numeral-mask" id="adult_thai" name="adult_thai" value="0" oninput="rows_customer();" />
                </div>
            </div>
            <div class="form-group col-md-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="child_thai">Children (Thai)</label>
                    <input type="number" class="form-control numeral-mask" id="child_thai" name="child_thai" value="0" oninput="rows_customer();" />
                </div>
            </div>
            <div class="form-group col-md-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="infant_thai">Infant (Thai)</label>
                    <input type="number" class="form-control numeral-mask" id="infant_thai" name="infant_thai" value="0" oninput="rows_customer();" />
                </div>
            </div>
            <div class="form-group col-md-2 col-12">
                <label class="form-label" for="foc_thai">FOC (Thai)</label>
                <input type="number" class="form-control numeral-mask" id="foc_thai" name="foc_thai" value="0" oninput="rows_customer();" />
            </div>
            <div class="form-group col-md-2 col-12">
                <label class="form-label" for="private_rates_thai">Private Rate (Thai)</label>
                <input type="number" class="form-control numeral-mask" id="private_rates_thai" name="private_rates_thai" value="0" oninput="rows_customer();" />
            </div>
        <?php } ?>
    <?php } elseif ($dataCustomer == 2) { ?> <!--  foreign -->
        <input type="hidden" id="bpr_foreign_id" name="bpr_foreign_id" value="" />
        <input type="hidden" id="category_id_foreign" name="category_id_foreign" value="<?php echo $category_id; ?>" />
        <input type="hidden" id="pror_id_foreign" name="pror_id_foreign" value="<?php echo !empty($rate_arr['prodrid']) ? $rate_arr['prodrid'] : 0; ?>" />
        <?php if ($book_type == 1) { ?> <!--  Join -->
            <div class="form-group col-md-3 col-12">
                <table width="100%" id="table-adult-foreign">
                    <tr>
                        <td width="30%">
                            <div class="form-group">
                                <label class="form-label" for="adult_foreign">Adult (Foreign)</label>
                                <input type="number" class="form-control numeral-mask" id="adult_foreign" name="adult_foreign" value="0" oninput="rows_customer();" />
                            </div>
                        </td>
                        <td width="1%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x m-1 font-medium-4">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </td>
                        <td width="69%">
                            <div class="form-group">
                                <label class="form-label" for="rate_adult_foreign">Rate Adult (Foreign)</label>
                                <input type="number" id="rate_adult_foreign" name="rate_adult_foreign" class="form-control numeral-mask" value="<?php echo !empty($rate_arr['rate_adult']) ? $rate_arr['rate_adult'] : 0; ?>" oninput="check_rate();">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group col-md-3 col-12">
                <table width="100%" id="table-child-foreign">
                    <tr>
                        <td width="30%">
                            <div class="form-group">
                                <label class="form-label" for="child_foreign">Children (Foreign)</label>
                                <input type="number" class="form-control numeral-mask" id="child_foreign" name="child_foreign" value="0" oninput="rows_customer();" />
                            </div>
                        </td>
                        <td width="1%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x m-1 font-medium-4">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </td>
                        <td width="69%">
                            <div class="form-group">
                                <label class="form-label" for="rate_child_foreign">Rate Children (Foreign)</label>
                                <input type="number" id="rate_child_foreign" name="rate_child_foreign" class="form-control numeral-mask" value="<?php echo !empty($rate_arr['rate_child']) ? $rate_arr['rate_child'] : 0; ?>" oninput="check_rate();">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group col-md-3 col-12">
                <table width="100%" id="table-infant-foreign">
                    <tr>
                        <td width="30%">
                            <div class="form-group">
                                <label class="form-label" for="infant_foreign">Infant (Foreign)</label>
                                <input type="number" class="form-control numeral-mask" id="infant_foreign" name="infant_foreign" value="0" oninput="rows_customer();" />
                            </div>
                        </td>
                        <td width="1%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x m-1 font-medium-4">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </td>
                        <td width="69%">
                            <div class="form-group">
                                <label class="form-label" for="rate_infant_foreign">Rate Infant (Foreign)</label>
                                <input type="number" id="rate_infant_foreign" name="rate_infant_foreign" class="form-control numeral-mask" value="<?php echo !empty($rate_arr['rate_infant']) ? $rate_arr['rate_infant'] : 0; ?>" oninput="check_rate();">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group col-md-2 col-12">
                <label class="form-label" for="foc_foreign">FOC (Foreign)</label>
                <input type="number" class="form-control numeral-mask" id="foc_foreign" name="foc_foreign" value="0" oninput="rows_customer();" />
            </div>
            <input type="hidden" id="rate_total_foreign" name="rate_total_foreign" value="0">
        <?php } elseif ($book_type == 2) { ?> <!--  Private -->
            <div class="form-group col-md-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="adult_foreign">Adult (Foreign)</label>
                    <input type="number" class="form-control numeral-mask" id="adult_foreign" name="adult_foreign" value="0" oninput="rows_customer();" />
                </div>
            </div>
            <div class="form-group col-md-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="child_foreign">Children (Foreign)</label>
                    <input type="number" class="form-control numeral-mask" id="child_foreign" name="child_foreign" value="0" oninput="rows_customer();" />
                </div>
            </div>
            <div class="form-group col-md-2 col-12">
                <div class="form-group">
                    <label class="form-label" for="infant_foreign">Infant (Foreign)</label>
                    <input type="number" class="form-control numeral-mask" id="infant_foreign" name="infant_foreign" value="0" oninput="rows_customer();" />
                </div>
            </div>
            <div class="form-group col-md-2 col-12">
                <label class="form-label" for="foc_foreign">FOC (Foreign)</label>
                <input type="number" class="form-control numeral-mask" id="foc_foreign" name="foc_foreign" value="0" oninput="rows_customer();" />
            </div>
            <div class="form-group col-md-2 col-12">
                <label class="form-label" for="private_rates_foreign">Private Rate (Foreign)</label>
                <input type="number" class="form-control numeral-mask" id="private_rates_foreign" name="private_rates_foreign" value="0" oninput="rows_customer();" />
            </div>
        <?php } ?>
    <?php } ?>
<?php
} else {
    echo $response = false;
}
