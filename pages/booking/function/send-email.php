<?php
include_once('../../../config/env.php');
include_once('../../../controllers/Booking.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../../app-assets/vendors/phpmailer/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

define('PHPMAILERHOST', 'smtp.gmail.com');
define('USERNAME', 'morn@phuketsolution.com');
define('PASSWORD', 'morn#mail22');
define('PORT', 587);
define('SMTPSecure', 'tls'); //ssl or tls

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
// $mail->isSMTP();
$mail->SMTPDebug  = 2;
$mail->Host       = PHPMAILERHOST;
$mail->SMTPAuth   = true;
$mail->Username   = USERNAME;
$mail->Password   = PASSWORD;
$mail->SMTPSecure = SMTPSecure;
$mail->Port       = PORT;
$mail->CharSet = "utf-8";

// Recipients
$mail->From = 'monzero753@gmail.com';
$mail->FromName = 'TMS Shambhala';
$mail->addAddress('morn@phuketsolution.com', 'Send');
// $mail->addAddress('jeerapong.sarak@gmail.com', 'Send');

$bookObj = new Booking();

if (isset($_POST['action']) && $_POST['action'] == "check" && isset($_POST['id'])) {

    $bookings = $bookObj->get_data($_POST['id']);
    $first_btr = array();
    $total_sum = 0;
    $total_product = 0;
    $total_sum = $total_sum + $bookings[0]['rate_total'];
    $total_product = $total_product + $bookings[0]['rate_total'];
    $total_sum = $total_sum + ($bookings[0]['bt_adult'] * $bookings[0]['btr_rate_adult']) + ($bookings[0]['bt_child'] * $bookings[0]['btr_rate_child']) + ($bookings[0]['bt_infant'] * $bookings[0]['btr_rate_infant']);
    $total_product = $total_product + ($bookings[0]['bt_adult'] * $bookings[0]['btr_rate_adult']) + ($bookings[0]['bt_child'] * $bookings[0]['btr_rate_child']) + ($bookings[0]['bt_infant'] * $bookings[0]['btr_rate_infant']);
    $total_sum = $total_sum + $bookings[0]['bec_total'];

    $data['booking_type_id'] = !empty(!empty($bookings[0]['booking_type_id'])) ? $bookings[0]['booking_type_id'] : 0;;
    $data['book_full'] = !empty($bookings[0]['book_full']) ? $bookings[0]['book_full'] : '';
    $data['created_at'] = date('j F Y', strtotime($bookings[0]['created_at']));
    $data['agent_name'] = !empty($bookings[0]['comp_name']) ? $bookings[0]['comp_name'] : 0;
    $data['booker_name'] = !empty($bookings[0]['booker_id']) ? $bookings[0]['booker_fname'] . ' ' . $bookings[0]['booker_lname'] : '';
    $data['product_name'] = !empty($bookings[0]['product_name']) ? $bookings[0]['product_name'] : 0;
    $data['category_name'] = !empty($bookings[0]['category_id']) ? $bookings[0]['category_id'] : 0;
    $data['travel_date'] = !empty($bookings[0]['travel_date']) ? $bookings[0]['travel_date'] : '0000-00-00';
    $data['bp_note'] = !empty($bookings[0]['bp_note']) ? $bookings[0]['bp_note'] : '';
    $data['pickup_name'] = !empty($bookings[0]['pickup_name']) ? $bookings[0]['pickup_name'] : '';
    $data['hotel_pickup'] = !empty($bookings[0]['hotel_pickup']) ? $bookings[0]['hotel_pickup'] : '';
    $data['room_no'] = !empty($bookings[0]['room_no']) ? $bookings[0]['room_no'] : '';
    $data['dropoff_name'] = !empty($bookings[0]['dropoff_name']) ? $bookings[0]['dropoff_name'] : '';
    $data['hotel_dropoff'] = !empty($bookings[0]['hotel_dropoff']) ? $bookings[0]['hotel_dropoff'] : '';
    $data['bt_note'] = !empty($bookings[0]['bt_note']) ? $bookings[0]['bt_note'] : '';
    $data['adult'] = !empty($bookings[0]['bpr_adult']) ? $bookings[0]['bpr_adult'] : 0;
    $data['child'] = !empty($bookings[0]['bpr_child']) ? $bookings[0]['bpr_child'] : 0;
    $data['infant'] = !empty($bookings[0]['bpr_infant']) ? $bookings[0]['bpr_infant'] : 0;
    $data['rate_adult'] = !empty($bookings[0]['rate_adult']) ? $bookings[0]['rate_adult'] : 0;
    $data['rate_child'] = !empty($bookings[0]['rate_child']) ? $bookings[0]['rate_child'] : 0;
    $data['rate_infant'] = !empty($bookings[0]['rate_infant']) ? $bookings[0]['rate_infant'] : 0;
    $data['bt_adult'] = !empty($bookings[0]['bt_adult']) ? $bookings[0]['bt_adult'] : 0;
    $data['bt_child'] = !empty($bookings[0]['bt_child']) ? $bookings[0]['bt_child'] : 0;
    $data['bt_infant'] = !empty($bookings[0]['bt_infant']) ? $bookings[0]['bt_infant'] : 0;
    $data['transfer_type'] = !empty($bookings[0]['transfer_type']) ? $bookings[0]['transfer_type'] : 0;;
    $data['btr_rate_adult'] = ($bookings[0]['transfer_type'] == 1) ? !empty($bookings[0]['btr_rate_adult']) ? $bookings[0]['btr_rate_adult'] : 0 : 0;
    $data['btr_rate_child'] = ($bookings[0]['transfer_type'] == 1) ? !empty($bookings[0]['btr_rate_child']) ? $bookings[0]['btr_rate_child'] : 0 : 0;
    $data['btr_rate_infant'] = ($bookings[0]['transfer_type'] == 1) ? !empty($bookings[0]['btr_rate_infant']) ? $bookings[0]['btr_rate_infant'] : 0 : 0;
    $data['discount'] = !empty($bookings[0]['discount']) ? $bookings[0]['discount'] : 0;

    $data['bec_name'] = !empty($bookings[0]['bec_name']) ? $bookings[0]['bec_name'] : '';
    $data['bec_total'] = !empty($bookings[0]['bec_total']) ? $bookings[0]['bec_total'] : 0;

    $data['cus_name'] = !empty($bookings[0]['cus_name']) ? $bookings[0]['cus_name'] : '';
    $data['cus_email'] = !empty($bookings[0]['email']) ? $bookings[0]['email'] : '';
    $data['cus_telephone'] = !empty($bookings[0]['telephone']) ? $bookings[0]['telephone'] : '';
    $data['cus_whatsapp'] = !empty($bookings[0]['whatsapp']) ? $bookings[0]['whatsapp'] : '';
    $data['cus_nation_name'] = !empty($bookings[0]['nation_name']) ? $bookings[0]['nation_name'] : '';
    $data['cus_address'] = !empty($bookings[0]['address']) ? $bookings[0]['address'] : '';

    foreach ($bookings as $booking) {
        if ((in_array($booking['btr_id'], $first_btr) == false) && ($bookings[0]['transfer_type'] == 2) && !empty($booking['btr_id'])) {
            $first_btr[] = $booking['btr_id'];
            $transfer['btr_id'][] = !empty($booking['btr_id']) ? $booking['btr_id'] : 0;
            $transfer['cars_category'][] = !empty($booking['cars_category']) ? $booking['cars_category'] : 0;
            $transfer['carc_name'][] = !empty($booking['carc_name']) ? $booking['carc_name'] : 0;
            $transfer['qty'][] = !empty($booking['qty']) ? $booking['qty'] : 0;
            $transfer['rate_private'][] = !empty($booking['rate_private']) ? $booking['rate_private'] : 0;
            $total_sum = ($booking['qty'] * $booking['rate_private']) + $total_sum;
            $total_product = ($booking['qty'] * $booking['rate_private']) + $total_product;
        }
    }

    $data['total_product'] = $total_product;
    $data['total_sum'] = $total_sum;
    // $transfers = !empty($_POST['transfers']) ? $_POST['transfers'] : '';
    // $datas = !empty($_POST['datas']) ? $_POST['datas'] : '';
    // $transfer = json_decode($transfers, true);
    // $data = json_decode($datas, true);
    // print_r($customers['name']);
    # --- get booking product, transfer, rate --- #

    $message = '<html>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Prompt&display=swap");
            body {
                -- font-family: "Prompt", sans-serif;
                font-family: Arial, Helvetica, sans-serif;
                color : #000;
            }
            .mail-table {
                width : 100%;
                margin-bottom : 1rem;
            }
            .mail-table th, .mail-table td {
                padding : 0.72rem;
                vertical-align : top;
                border : 1px solid #EBE9F1;
              }
            .mail-table thead th {
                vertical-align : bottom;
                border-bottom : 2px solid #EBE9F1;
              }
            .mail-table tbody + tbody {
                border-top : 2px solid #EBE9F1;
              }
        </style>
        <body>';
    $message .= '<table width="100%">
        <tr>
            <td width="70%" align="left">
                <h3>Booking : ' . $data['book_full'] . '</h3>';
    $message .= !empty($data['cus_name']) ? 'Name : ' . $data['cus_name'] . ' <br>' : 'Name : - <br>';
    $message .= !empty($data['cus_email']) ? 'Email : ' . $data["cus_email"] . ' <br>' : 'Email : - <br>';
    $message .= !empty($data['cus_telephone']) ? 'Telephone : ' . $data["cus_telephone"] . ' <br>' : 'Telephone : - <br>';
    $message .= !empty($data['cus_whatsapp']) ? 'Whatsapp : ' . $data["cus_whatsapp"] . ' <br>'  : 'Whatsapp : - <br>';
    $message .= !empty($data['cus_nation_name']) ? 'Nationality : ' . $data["cus_nation_name"] . ' <br>'  : 'Nationality : - <br>';
    $message .= !empty($data['cus_address']) ? 'Address : ' . $data["cus_address"] : 'Address : - <br>';
    $message .= '</td>
            <td width="30%">
                ' . $_SESSION["supplier"]["fullname"] . '
                <table width="100%" style="border: 1px solid #ddd;" cellspacing="0" cellpadding="6" align="right">
                    <tr>
                        <td bgcolor="#d9d9d9">
                            Booking ID:
                        </td>
                        <td align="right">' . $data['book_full'] . '</td>
                    </tr>
                    <tr>
                        <td bgcolor="#d9d9d9">
                            Created:
                        </td>
                        <td align="right">' . date('j F Y', strtotime($data['created_at'])) . '</td>
                    </tr>
                    <tr>
                        <td bgcolor="#d9d9d9">
                            Booking Date:
                        </td>
                        <td align="right">';
    $message .= date('j F Y', strtotime($data['travel_date'])) . '<br>';
    $message .= '</td>
                    </tr>
                    <tr>
                        <td bgcolor="#d9d9d9">
                            Total (THB):
                        </td>
                        <td align="right">฿ ' . number_format($data['total_sum']) . '</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%" style="border: 1px solid #ddd;" cellspacing="0" cellpadding="10">
        <tr bgcolor="#d9d9d9">
            <th align="left">Item</th>
            <th align="left">Rate</th>
            <th align="right">Amount</th>
        </tr>';
    $message .= '<tr>
                            <td style="border-bottom: 1px solid #ddd;">
                                <b>' . $data['product_name'] . '</b><br>
                                <b>' . $data['category_name'] . '</b><br>
                                ' . $data['travel_date'] . '<br>
                                ***REMARK***<br>';
    $message .= !empty($data['bp_note']) ? 'Note (Tour Detail) : ' . $data['bp_note'] : '';
    $message .= !empty($data['pickup_name']) ? 'Pickup : ' . $data['pickup_name'] . '<br>' : '';
    $message .= !empty($data['hotel_pickup']) ? 'Hotel Name (Pickup) : ' . $data['hotel_pickup'] . '<br>' : '';
    $message .= !empty($data['room_no']) ? 'Room Name : ' . $data['room_no'] . '<br>' : '';
    $message .= !empty($data['dropoff_name']) ? 'Dropoff : ' . $data['dropoff_name'] . '<br>' : '';
    $message .= !empty($data['hotel_dropoff']) ? 'Hotel Name (Dropoff) : ' . $data['hotel_dropoff'] . '<br>' : '';
    $message .= !empty($data['bt_note']) ? 'Note (Transfer) : ' . $data['bt_note'] : '';
    $message .= '</td>
            <td style="border-bottom: 1px solid #ddd;">
                <table width="100%" cellspacing="0" class="mail-table">
                    <tr bgcolor="#d9d9d9">
                        <th colspan="4" class="text-center"><b>Tour</b></th>
                    </tr>
                    <tr>
                        <td width="30%">Adult(s):</td>
                        <td width="20%" align="right" class="text-nowrap">' . $data['adult'] . ' x</td>
                        <td width="20%">1</td>
                        <td width="30%" class="text-nowrap text-right"><b>฿ ' . number_format($data['rate_adult']) . '</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Child(s):</td>
                        <td width="20%" align="right" class="text-nowrap">' . $data['child'] . ' x</td>
                        <td width="20%">2</td>
                        <td width="30%" class="text-nowrap text-right"><b>฿ ' . number_format($data['rate_child']) . '</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Infant(s):</td>
                        <td width="20%" align="right" class="text-nowrap">' . $data['infant'] . ' x</td>
                        <td width="02%">3</td>
                        <td width="30%" class="text-nowrap text-right"><b>฿ ' . number_format($data['rate_infant']) . '</b></td>
                    </tr>
                </table>';

    if ($data['transfer_type'] == 1) {
        $message .= '<table width="100%" cellspacing="0" class="mail-table">
                                            <tr bgcolor="#d9d9d9">
                                                <th colspan="4" class="text-center"><b>Transfer Join';
        $message .= ' </b></th>
                                            </tr>
                                            <tr>
                                                <td width="30%">Adult(s):</td>
                                                <td width="20%" align="right" class="text-nowrap">' . $data['bt_adult'] . ' x</td>
                                                <td width="20%">';
        $message .= number_format($data['btr_rate_adult']);
        $rate_adult = ($data['bt_adult'] * $data['btr_rate_adult']) > 0 ? number_format($data['bt_adult'] * $data['btr_rate_adult']) : 'Free';
        $message .= '</td>
                                                <td width="30%" class="text-nowrap text-right"><b>฿ ' . $rate_adult . '</b></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Child(s):</td>
                                                <td width="20%" align="right" class="text-nowrap">' . $data['bt_child'] . ' x</td>
                                                <td width="20%">';
        $message .= number_format($data['btr_rate_child']);
        $rate_child = ($data['bt_child'] * $data['btr_rate_child']) > 0 ? number_format($data['bt_child'] * $data['btr_rate_child']) : 'Free';
        $message .= '</td>
                                                <td width="30%" class="text-nowrap text-right"><b>฿ ' . $rate_child . '</b></td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Infant(s):</td>
                                                <td width="20%" align="right" class="text-nowrap">' . $data['bt_infant'] . ' x</td>
                                                <td width="20%">';
        $message .= number_format($data['btr_rate_infant']);
        $rate_infant = ($data['bt_infant'] * $data['btr_rate_infant']) > 0 ? number_format($data['bt_infant'] * $data['btr_rate_infant']) : 'Free';
        $message .= '</td>
                                                <td width="30%" class="text-nowrap text-right"><b>฿ ' . $rate_infant . '</b></td>
                                            </tr>
                                        </table>';
    }
    if ($data['transfer_type'] == 2) {
        $message .= '<table width="100%" cellspacing="0" class="mail-table">
                                            <tr bgcolor="#d9d9d9">
                                                <th colspan="4" class="text-center"><b>Transfer : Private</b></th>
                                            </tr>';
        for ($b = 0; $b < count($transfer['btr_id']); $b++) {
            $message .= '<tr>
                                                    <td width="30%">' . $transfer['carc_name'][$b] . ' : </td>
                                                    <td width="20%" align="right" class="text-nowrap">' . $transfer['qty'][$b] . ' x</td>
                                                    <td width="20%">' . $transfer['rate_private'][$b] . '</td>
                                                    <td width="30%" class="text-nowrap text-right"><b>฿ ' . number_format($transfer['qty'][$b] * $transfer['rate_private'][$b]) . '</b></td>
                                                </tr>';
        }
        $message .= '</table>';
    }
    $message .= '</td>
                                    <td align="right" class="text-danger" style="border-bottom: 1px solid #ddd;"><b>฿ ' . number_format($data['total_product']) . '</b></td>
                                </tr>';

    if (!empty($data['bec_name'])) {
        $message .= '<tr>
                                    <td style="border-bottom: 1px solid #ddd;"><b>' . $data['bec_name'] . '</b></td>
                                    <td style="border-bottom: 1px solid #ddd;"></td>
                                    <td style="border-bottom: 1px solid #ddd;" align="right" class="text-danger"><b>฿ ' . number_format($data['bec_total']) . '</b></td>
                                </tr>';
    }

    $message .= '<tr>
                <td colspan="3" align="right" style="border-bottom: 1px solid #ddd;"><b>Total:</b> ฿ ' . number_format($data['total_sum']) . '</td>
            </tr>
            <tr>
                <td colspan="3" align="right" style="border-bottom: 1px solid #ddd;"><b>Discount:</b> ฿ ' . number_format($data['discount']) . '</td>
            </tr>
            <tr>
                <td colspan="3" align="right" style="border-bottom: 1px solid #ddd;"> <b>Amount Paid:</b> ฿ ' . number_format($data['total_sum'] - $data['discount']) . '</td>
            </tr>
        </table>
        </body>
        <html>';

    // echo $message;

    // //Content
    // $mail->isHTML(true);                                  //Set email format to HTML
    // $mail->Subject = $subject;
    // $mail->Body    = $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // if (!$mail->send()) {
    //     echo 'Message could not be sent.';
    //     echo 'Mailer Error: ' . $mail->ErrorInfo;
    // } else {
    //     echo 'Message has been sent';
    // }
    echo $response = true;
} else {
    echo $response = FALSE;
}
