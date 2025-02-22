<?php
require_once __DIR__ . '/DB.php';

class Report extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist($status, $date_form, $date_to, $agent, $product)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT BO.*,
                    BONO.bo_full as book_full,
                    BSTA.id as booksta_id, BSTA.name as booksta_name, BSTA.name_class as booksta_class, BSTA.button_class as booksta_button,
                    BTYE.id as booktye_id, BTYE.name as booktye_name,
                    BOPA.id as bopa_id, BOPA.date_paid as date_paid, BOPA.total_paid as total_paid, BOPA.card_no as card_no, 
                    BOPA.photo as bopa_photo, BOPA.note as bopa_note, BOPA.payment_type_id as payment_type_id, BOPA.bank_account_id as bank_account_id, BOPA.updated_at as bopa_updated,
                    BOPAY.id as bopay_id, BOPAY.name as bopay_name, BOPAY.name_class as bopay_name_class, BOPAY.created_at as bopay_created,
                    COMP.id as comp_id, COMP.name as comp_name, COMP.logo as comp_logo,
                    BP.id as bp_id, BP.travel_date as travel_date,  BP.note as bp_note,
                    BP.private_type as bp_private_type,
                    BPR.id as bpr_id, BPR.adult as bpr_adult, BPR.child as bpr_child, BPR.infant as bpr_infant, BPR.foc as bpr_foc, 
                    BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_total as rate_total,  
                    PROD.id as product_id, PROD.name as product_name,
                    CATE.id as category_id, CATE.name as category_name, CATE.customer as category_cus, CATE.transfer as category_transfer, 
                    PARK.id as park_id, PARK.name as park_name, PARK.rate_adult_eng as adult_eng, PARK.rate_child_eng as child_eng, PARK.rate_adult_th as adult_th, PARK.rate_child_th as child_th,
                    CUS.id as cus_id, CUS.name as cus_name, CUS.age as cus_age, CUS.id_card as id_card, CUS.telephone as telephone, CUS.birth_date as birth_date, CUS.head as cus_head, CUS.nationality_id as nationality_id,
                    BT.id as bt_id, BT.adult as bt_adult, BT.child as bt_child, BT.infant as bt_infant, BT.foc as bt_foc, BT.start_pickup as start_pickup, BT.end_pickup as end_pickup,
                    BT.hotel_pickup as hotel_pickup, BT.hotel_dropoff as hotel_dropoff, BT.room_no as room_no, BT.note as bt_note, BT.transfer_type as transfer_type,
                    BT.pickup_type as pickup_type,
                    BEC.id as bec_id, BEC.name as bec_name, BEC.adult as bec_adult, BEC.child as bec_child, BEC.infant as bec_infant, BEC.privates as bec_privates, BEC.type as bec_type,
                    BEC.rate_adult as bec_rate_adult, BEC.rate_child as bec_rate_child, BEC.rate_infant as bec_rate_infant, BEC.rate_private as bec_rate_private, 
                    EXTRA.id as extra_id, EXTRA.name as extra_name, EXTRA.unit as extra_unit,
                    CARC.id as cars_category_id, CARC.name as cars_category,
                    BOT.id as BOT_id, BOT.arrange as arrange,
                    ORTRAN.id as ortran_id, ORTRAN.license as license, ORTRAN.telephone as ortran_telephone, ORTRAN.travel_date as ortran_travel,
                    CAR.id as car_id, CAR.name as car_name,
                    HOTPIK.id as hotel_pickup_id, HOTPIK.name as hotel_pickup_name,
                    HOTDRO.id as hotel_dropoff_id, HOTDRO.name as hotel_dropoff_name,
                    INV.id as inv_id, INV.rec_date as rec_date, INV.withholding as withholding,
                    INVCO.id as cover_id, INVCO.inv_date as inv_date, INVCO.inv_full as inv_full,
                    VAT.id as vat_id, VAT.name as vat_name,
                    REC.id as rec_id,
                    BOBOAT.id as boboat_id,
                    ORBOAT.id as orboat_id, ORBOAT.travel_date as orboat_travel, ORBOAT.note as orboat_note,
                    COLOR.id as color_id, COLOR.name as color_name, COLOR.name_th as color_name_th, COLOR.hex_code as color_hex, 
                    BOAT.id as boat_id, BOAT.name as boat_name, BOAT.refcode as boat_refcode
                FROM bookings BO
                LEFT JOIN bookings_no BONO
                    ON BO.id = BONO.booking_id
                LEFT JOIN booking_status BSTA
                    ON BO.booking_status_id = BSTA.id
                LEFT JOIN booking_type BTYE
                    ON BO.booking_type_id = BTYE.id
                LEFT JOIN booking_paid BOPA
                        ON BO.id = BOPA.booking_id
                LEFT JOIN booking_payment BOPAY
                    ON BOPA.booking_payment_id = BOPAY.id
                LEFT JOIN companies COMP
                    ON BO.company_id = COMP.id
                LEFT JOIN booking_products BP
                    ON BO.id = BP.booking_id
                LEFT JOIN booking_product_rates BPR
                    ON BP.id = BPR.booking_products_id
                LEFT JOIN booking_transfer BT
                    ON BP.id = BT.booking_products_id
                LEFT JOIN booking_transfer_rates BTR
                    ON BT.id = BTR.booking_transfer_id
                LEFT JOIN booking_extra_charge BEC
                    ON BO.id = BEC.booking_id
                LEFT JOIN extra_charges EXTRA
                    ON BEC.extra_charge_id = EXTRA.id
                LEFT JOIN cars_category CARC
                    ON BTR.cars_category_id = CARC.id 
                LEFT JOIN booking_order_transfer BOT
                    ON BT.id = BOT.booking_transfer_id
                LEFT JOIN order_transfer ORTRAN 
                    ON BOT.order_id = ORTRAN.id
                LEFT JOIN cars CAR 
                    ON ORTRAN.car_id = CAR.id
                LEFT JOIN hotel HOTPIK
                    ON BT.hotel_pickup_id = HOTPIK.id
                LEFT JOIN hotel HOTDRO
                    ON BT.hotel_dropoff_id = HOTDRO.id
                LEFT JOIN products PROD
                    ON BP.product_id = PROD.id
                LEFT JOIN product_category CATE
                    ON BPR.category_id = CATE.id
                LEFT JOIN park PARK
                    ON PROD.PARK_id = PARK.id
                LEFT JOIN customers CUS
                    ON BO.id = CUS.booking_id
                LEFT JOIN invoices INV
                    ON BO.id = INV.booking_id
                    AND INV.is_deleted = 0
                LEFT JOIN invoice_cover INVCO
                    ON INV.cover_id = INVCO.id    
                LEFT JOIN vat_type VAT
                    ON INV.vat_id = VAT.id
                LEFT JOIN receipts REC
                    ON INVCO.id = REC.cover_id
                LEFT JOIN booking_order_boat BOBOAT
                    ON BO.id = BOBOAT.booking_id
                LEFT JOIN order_boat ORBOAT
                    ON BOBOAT.manage_id = ORBOAT.id
                LEFT JOIN colors COLOR 
                    ON ORBOAT.color_id = COLOR.id
                LEFT JOIN boats BOAT
                    ON ORBOAT.boat_id = BOAT.id
                WHERE BO.is_deleted = 0
                AND PROD.id > 0
                AND BP.is_deleted = 0
        ";

        $query .= $date_form != '0000-00-00' ? $date_to != '0000-00-00' ? " AND BP.travel_date BETWEEN '$date_form' AND '$date_to' " : " AND BP.travel_date BETWEEN '$date_form' AND '$date_form' " : '';

        if (!empty($status)) {
            if ($status != 'all') {
                $query .= " AND (";
                for ($i = 0; $i < count($status); $i++) {
                    $query .= $i == 0 ? " BSTA.id = " . $status[$i] : " OR BSTA.id = " . $status[$i];
                }
                $query .= " )";
            } else {
                $query .= " AND BSTA.id = 1";
            }
        }

        if (isset($agent) && $agent != "all") {
            $query .= " AND COMP.id = ?";
            $bind_types .= "i";
            array_push($params, $agent);
        }

        if (isset($product) && $product != "all") {
            $query .= " AND PROD.id = ?";
            $bind_types .= "i";
            array_push($params, $product);
        }

        $query .= " ORDER BY BO.id DESC, BP.travel_date DESC, BOPA.id ASC";
        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showbookingstatus()
    {
        $query = "SELECT id, name, button_class
            FROM booking_status 
            WHERE id > 0
        ";
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showlistagent()
    {
        $query = "SELECT companies.*, 
            companies_type.id as comptypeId, companies_type.name as comptypeName
            FROM companies 
            LEFT JOIN companies_type
                ON companies.company_type_id = companies_type.id
            WHERE companies.is_deleted = 0 
            AND companies.company_type_id != 1
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showlistproduct()
    {
        $query = "SELECT *
            FROM products 
            WHERE is_deleted = 0
        ";
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function sumbtrprivate(int $bt_id)
    {
        $query = "SELECT SUM(rate_private) as sum_rate_private
            FROM booking_transfer_rates 
            WHERE booking_transfer_id = " . $bt_id;
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

        return $data;
    }

    public function sumbectotal(int $bo_id)
    {
        $query = "SELECT ((adult * rate_adult) + (child * rate_child) + (infant * rate_infant) + (privates * rate_private)) as sum_rate_total
            FROM booking_extra_charge 
            WHERE booking_id = " . $bo_id;
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

        return $data;
    }

    public function get_value(string $select, string $from, int $id)
    {
        $query = "SELECT $select
            FROM $from 
            WHERE id = ?
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            $data = false;
        }

        return $data;
    }
}
