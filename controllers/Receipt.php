<?php
require_once __DIR__ . '/DB.php';

class Receipt extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist($type, $travel_date, $agent, $rec_id)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT BO.*,
                    BONO.bo_full as book_full,
                    BSTA.id as booksta_id, BSTA.name as booksta_name, BSTA.name_class as booksta_class, BSTA.button_class as booksta_button,
                    BTYE.id as booktye_id, BTYE.name as booktye_name,
                    COMP.id as comp_id, COMP.name as comp_name, COMP.tat_license as tat_license, COMP.telephone as comp_telephone, COMP.address as comp_address,
                    BOPA.id as bopa_id, BOPA.date_paid as date_paid, BOPA.total_paid as total_paid, BOPA.card_no as card_no, BOPA.photo as bopa_photo, BOPA.note as bopa_note, BOPA.payment_type_id as payment_type_id,
                    BOPAY.id as bopay_id, BOPAY.name as bopay_name, BOPAY.name_class as bopay_name_class, BOPAY.created_at as bopay_created,
                    BP.id as bp_id, BP.travel_date as travel_date,  BP.note as bp_note,
                    BP.private_type as bp_private_type,
                    BPR.id as bpr_id, BPR.adult as bpr_adult, BPR.child as bpr_child, BPR.infant as bpr_infant, BPR.foc as bpr_foc, 
                    BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_total as rate_total,  
                    PROD.id as product_id, PROD.name as product_name,
                    CATE.id as category_id, CATE.name as category_name, CATE.customer as category_cus, CATE.transfer as category_transfer,  
                    CUS.id as cus_id, CUS.name as cus_name, CUS.head as cus_head,
                    BT.id as bt_id, BT.adult as bt_adult, BT.child as bt_child, BT.infant as bt_infant, BT.foc as bt_foc, BT.start_pickup as start_pickup, BT.end_pickup as end_pickup,
                    BT.pickup_type, pickup_type, BT.room_no as room_no, BT.note as bt_note, BT.hotel_pickup as outside, BT.hotel_dropoff as outside_dropoff,
                    PICKUP.id as pickup_id, PICKUP.name_th as pickup_name,
                    DROPOFF.id as dropoff_id, DROPOFF.name_th as dropoff_name,
                    ZONE_P.id as zonep_id, ZONE_P.name_th as zonep_name,
                    ZONE_D.id as zoned_id, ZONE_D.name_th as zoned_name,
                    CARC.id as cars_category_id, CARC.name as cars_category,
                    BEC.id as bec_id, BEC.name as bec_name, BEC.adult as bec_adult, BEC.child as bec_child, BEC.infant as bec_infant, BEC.privates as bec_privates, BEC.type as bec_type,
                    BEC.rate_adult as bec_rate_adult, BEC.rate_child as bec_rate_child, BEC.rate_infant as bec_rate_infant, BEC.rate_private as bec_rate_private, 
                    EXTRA.id as extra_id, EXTRA.name as extra_name, EXTRA.unit as extra_unit,
                    BOMANGE.id as bomanage_id,
                    MANGET.id as manget_id, MANGET.pickup as pickup, MANGET.dropoff as dropoff,
                    CAR.id as car_id, CAR.name as car_name,
                    BOOKER.id as booker_id, BOOKER.firstname as booker_fname, BOOKER.lastname as booker_lname,
                    BORDB.id as boman_id, BORDB.arrange as boman_arrange, 
                    MANGE.id as mange_id, MANGE.time as manage_time,
                    COLOR.id as color_id, COLOR.name as color_name, COLOR.name_th as color_name_th, COLOR.hex_code as color_hex, 
                    GUIDE.id as guide_id, GUIDE.name as guide_name,
                    BOAT.id as boat_id, BOAT.name as boat_name, BOAT.refcode as boat_refcode,
                    INV.id as inv_id, INV.rec_date as rec_date, INV.withholding as withholding, INV.vat_id as vat, INV.no as inv_no, INV.note as inv_note, INV.is_deleted as inv_deleted,
                    COVER.id as cover_id, COVER.inv_date as inv_date, COVER.inv_full as inv_full,
                    BRCH.id as brch_id, BRCH.name as brch_name,
                    BANACC.id as banacc_id, BANACC.account_name as account_name, BANACC.account_no as account_no,
                    BANK.id as bank_id, BANK.name as bank_name,
                    REC.id as rec_id, REC.rec_full as rec_full, REC.rec_date as date_rec, REC.cheque_no as cheque_no, REC.cheque_date as cheque_date, REC.file as rec_file, REC.note as rec_note,
                    PAYT.id as payt_id, PAYT.name as payt_name
                FROM bookings BO
                LEFT JOIN bookings_no BONO
                    ON BO.id = BONO.booking_id
                LEFT JOIN booking_status BSTA
                    ON BO.booking_status_id = BSTA.id
                LEFT JOIN booking_type BTYE
                    ON BO.booking_type_id = BTYE.id
                LEFT JOIN companies COMP
                    ON BO.company_id = COMP.id
                LEFT JOIN booking_paid BOPA
                    ON BO.id = BOPA.booking_id
                    AND BOPA.booking_payment_id	= 4
                LEFT JOIN booking_payment BOPAY
                    ON BOPA.booking_payment_id = BOPAY.id
                LEFT JOIN booking_products BP
                    ON BO.id = BP.booking_id
                LEFT JOIN booking_product_rates BPR
                    ON BP.id = BPR.booking_products_id
                LEFT JOIN booking_transfer BT
                    ON BP.id = BT.booking_products_id
                LEFT JOIN hotel PICKUP
                    ON BT.hotel_pickup_id = PICKUP.id
                LEFT JOIN hotel DROPOFF
                    ON BT.hotel_dropoff_id = DROPOFF.id
                LEFT JOIN zones ZONE_P
                    ON BT.pickup_id = ZONE_P.id
                LEFT JOIN zones ZONE_D
                    ON BT.dropoff_id = ZONE_D.id
                LEFT JOIN booking_transfer_rates BTR
                    ON BT.id = BTR.booking_transfer_id
                LEFT JOIN cars_category CARC
                    ON BTR.cars_category_id = CARC.id 
                LEFT JOIN booking_extra_charge BEC
                    ON BO.id = BEC.booking_id
                LEFT JOIN products PROD
                    ON BP.product_id = PROD.id
                LEFT JOIN product_category CATE
                    ON BPR.category_id = CATE.id
                LEFT JOIN customers CUS
                    ON BO.id = CUS.booking_id
                LEFT JOIN extra_charges EXTRA
                    ON BEC.extra_charge_id = EXTRA.id
                LEFT JOIN booking_order_transfer BOMANGE
                    ON BT.id = BOMANGE.booking_transfer_id
                LEFT JOIN order_transfer MANGET 
                    ON BOMANGE.order_id = MANGET.id
                    AND MANGET.pickup = 1
                LEFT JOIN cars CAR 
                    ON MANGET.car_id = CAR.id
                LEFT JOIN booking_order_boat BORDB
                    ON BO.id = BORDB.booking_id
                LEFT JOIN order_boat MANGE 
                    ON BORDB.manage_id = MANGE.id
                LEFT JOIN colors COLOR 
                    ON MANGE.color_id = COLOR.id
                LEFT JOIN guides GUIDE
                    ON MANGE.guide_id = GUIDE.id
                LEFT JOIN boats BOAT
                    ON MANGE.boat_id = BOAT.id
                LEFT JOIN users BOOKER 
                    ON BO.booker_id = BOOKER.id
                LEFT JOIN invoices INV
                    ON BO.id = INV.booking_id
                LEFT JOIN invoice_cover COVER
                    ON INV.cover_id = COVER.id
                LEFT JOIN branches BRCH
                    ON INV.branche_id = BRCH.id
                LEFT JOIN bank_account BANACC
                    ON INV.bank_account_id = BANACC.id
                LEFT JOIN banks BANK
                    ON BANACC.bank_id = BANK.id
                LEFT JOIN receipts REC
                    ON COVER.id = REC.cover_id
                LEFT JOIN payments_type PAYT
                    ON REC.payment_id = PAYT.id
                WHERE BO.is_deleted = 0
                AND BP.id > 0
                AND BSTA.id != 3
        ";

        if (isset($travel_date) && $travel_date != '0000-00-00') { // 11, 20
            $query .= !empty(substr($travel_date, 14, 24)) ? " AND BP.travel_date BETWEEN '" . substr($travel_date, 0, 10) . "' AND '" . substr($travel_date, 14, 24) . "'" : " AND BP.travel_date = '" . $travel_date . "' ";
        }

        if (isset($type) && $type == "invoices") {
            $query .= " AND COVER.id IS NOT NULL AND REC.id IS NULL ";

            if (isset($agent) && $agent != "all") {
                $query .= " AND COMP.id = ?";
                $bind_types .= "i";
                array_push($params, $agent);
            }

            $query .= " ORDER BY COMP.name ASC, BP.travel_date ASC, INV.no ASC, BT.pickup_type DESC, CATE.name DESC";
        }

        if (isset($type) && $type == "receipts") {
            $query .= " AND COVER.id IS NOT NULL AND REC.id IS NOT NULL ";

            if (isset($agent) && $agent != "all") {
                $query .= " AND COMP.id = ?";
                $bind_types .= "i";
                array_push($params, $agent);
            }

            if (isset($rec_id) && $rec_id > 0) {
                $query .= " AND REC.id = ?";
                $bind_types .= "i";
                array_push($params, $rec_id);
            }

            $query .= " ORDER BY COMP.name ASC, INV.no ASC, BP.travel_date ASC, BT.pickup_type DESC, CATE.name DESC";
        }

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showlistreceipt($period, $date_form, $date_to, $agent, $type, $rec_id)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT REC.*,
                    COVER.id as cover_id, COVER.inv_full as inv_full,
                    INV.id as inv_id, INV.no as inv_no, INV.withholding as withholding,
                    VAT.id as vat_id, VAT.name as vat_name,
                    PAYT.id as payt_id, PAYT.name as payt_name,
                    BANACC.id as banacc_id, BANACC.account_name as account_name, BANACC.account_no as account_no,
                    BANK.id as bank_id, BANK.name as bank_name, 
                    BRCH.id as brch_id, BRCH.name as brch_name,
                    BO.id as bo_id, BO.voucher_no_agent as voucher_no_agent, BO.discount as discount,
                    BONO.bo_full as book_full,
                    BSTA.id as booksta_id, BSTA.name as booksta_name, BSTA.name_class as booksta_class, BSTA.button_class as booksta_button,
                    BTYE.id as booktye_id, BTYE.name as booktye_name,
                    COMP.id as comp_id, COMP.name as comp_name, COMP.address as comp_address, COMP.telephone as comp_telephone, COMP.tat_license as comp_tat,
                    BOPA.id as bopa_id,
                    BOPAY.id as bopay_id, BOPAY.name as bopay_name, BOPAY.name_class as bopay_name_class, BOPAY.created_at as bopay_created,
                    BOPAE.id as bopae_id, BOPAE.date_paid as date_paid, BOPAE.total_paid as total_paid, BOPAE.card_no as card_no, BOPAE.photo as bopae_photo, BOPAE.note as bopae_note, BOPAE.payment_type_id as payment_type_id, 
                    BP.id as bp_id, BP.travel_date as travel_date, BP.adult as bpr_adult, BP.child as bpr_child, BP.infant as bpr_infant, BP.note as bp_note,
                    BP.private_type as bp_private_type,
                    BPR.id as bpr_id, BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_total as rate_total, 
                    PROD.id as product_id, PROD.name as product_name,
                    CUS.id as cus_id, CUS.name as cus_name, CUS.head as cus_head,
                    BT.id as bt_id, BT.adult as bt_adult, BT.child as bt_child, BT.infant as bt_infant, BT.start_pickup as start_pickup, BT.end_pickup as end_pickup,
                    BT.hotel_pickup as hotel_pickup, BT.hotel_dropoff as hotel_dropoff, BT.room_no as room_no, BT.note as bt_note, BT.transfer_type as transfer_type,
                    BT.pickup_type as pickup_type,
                    BPR.id as bpr_id, BPR.adult as bpr_adult, BPR.child as bpr_child, BPR.infant as bpr_infant, BPR.foc as bpr_foc, 
                        BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_total as rate_total,  
                    CARC.id as cars_category_id, CARC.name as cars_category,
                    BEC.id as bec_id, BEC.name as bec_name, BEC.adult as bec_adult, BEC.child as bec_child, BEC.infant as bec_infant, BEC.privates as bec_privates, BEC.type as bec_type,
                    BEC.rate_adult as bec_rate_adult, BEC.rate_child as bec_rate_child, BEC.rate_infant as bec_rate_infant, BEC.rate_private as bec_rate_private, 
                    EXTRA.id as extra_id, EXTRA.name as extra_name,
                    PICK.id as pickup_id, PICK.name as pickup_name
                FROM receipts REC
                LEFT JOIN invoice_cover COVER
                    ON REC.cover_id = COVER.id
                LEFT JOIN invoices INV
                    ON COVER.id = INV.cover_id
                LEFT JOIN vat_type VAT
                    ON INV.vat_id = VAT.id
                LEFT JOIN payments_type PAYT
                    ON REC.payment_id = PAYT.id
                LEFT JOIN bank_account BANACC
                    ON REC.bank_account_id = BANACC.id
                LEFT JOIN banks BANK
                    ON REC.bank_cheque_id = BANK.id
                LEFT JOIN branches BRCH
                    ON INV.branche_id = BRCH.id
                LEFT JOIN bookings BO
                    ON INV.booking_id = BO.id
                LEFT JOIN bookings_no BONO
                    ON BO.id = BONO.booking_id
                LEFT JOIN booking_status BSTA
                    ON BO.booking_status_id = BSTA.id
                LEFT JOIN booking_type BTYE
                    ON BO.booking_type_id = BTYE.id
                LEFT JOIN companies COMP
                    ON BO.company_id = COMP.id
                LEFT JOIN booking_paid BOPA
                    ON BO.id = BOPA.booking_id
                LEFT JOIN booking_payment BOPAY
                    ON BOPA.booking_payment_id = BOPAY.id
                LEFT JOIN booking_paid_detail BOPAE
                    ON BOPA.id = BOPAE.booking_paid_id
                LEFT JOIN booking_products BP
                    ON BO.id = BP.booking_id
                LEFT JOIN booking_product_rates BPR
                    ON BP.id = BPR.booking_products_id
                LEFT JOIN booking_transfer BT
                    ON BP.id = BT.booking_products_id
                LEFT JOIN booking_transfer_rates BTR
                    ON BT.id = BTR.booking_transfer_id
                LEFT JOIN cars_category CARC
                    ON BTR.cars_category_id = CARC.id 
                LEFT JOIN booking_extra_charge BEC
                    ON BO.id = BEC.booking_id
                LEFT JOIN extra_charges EXTRA
                    ON BEC.extra_charge_id = EXTRA.id
                LEFT JOIN products PROD
                    ON BP.product_id = PROD.id
                LEFT JOIN customers CUS
                    ON BO.id = CUS.booking_id
                LEFT JOIN place PICK
                    ON BT.pickup_id = PICK.id
                WHERE REC.is_deleted = 0
        ";

        if ($type == 'list') {
            if (isset($period) && $period != "all") {
                $query .= " AND REC.rec_date BETWEEN ? AND ?";
                $bind_types .= "ss";
                array_push($params, $date_form, $date_to);
            }

            if (isset($agent) && $agent != "all") {
                $query .= " AND COMP.id = ?";
                $bind_types .= "i";
                array_push($params, $agent);
            }
        }

        if ($type == 'preview') {
            if (isset($rec_id) && $rec_id > 0) {
                $query .= " AND REC.id = ?";
                $bind_types .= "i";
                array_push($params, $rec_id);
            }
        }

        $query .= " ORDER BY rec_full ASC";
        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showlistinvoice($period, $date_form, $date_to, $agent)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT INV.*,
                    COVER.id as cover_id, COVER.inv_full as inv_full, COVER.inv_date as inv_date,
                    VAT.id as vat_id, VAT.name as vat_name,
                    PAYT.id as payt_id, PAYT.name as payt_name,
                    BANACC.id as banacc_id, BANACC.account_name as account_name, BANACC.account_no as account_no,
                    BANK.id as bank_id, BANK.name as bank_name, 
                    BRCH.id as brch_id, BRCH.name as brch_name,
                    BO.id as bo_id, BO.voucher_no_agent as voucher_no_agent, BO.discount as discount,
                    BONO.bo_full as book_full,
                    BSTA.id as booksta_id, BSTA.name as booksta_name, BSTA.name_class as booksta_class, BSTA.button_class as booksta_button,
                    BTYE.id as booktye_id, BTYE.name as booktye_name,
                    COMP.id as comp_id, COMP.name as comp_name, COMP.address as comp_address, COMP.telephone as comp_telephone, COMP.tat_license as comp_tat,
                    BOPA.id as bopa_id,
                    BOPAY.id as bopay_id, BOPAY.name as bopay_name, BOPAY.name_class as bopay_name_class, BOPAY.created_at as bopay_created,
                    BOPAE.id as bopae_id, BOPAE.date_paid as date_paid, BOPAE.total_paid as total_paid, BOPAE.card_no as card_no, BOPAE.photo as bopae_photo, BOPAE.note as bopae_note, BOPAE.payment_type_id as payment_type_id, 
                    BP.id as bp_id, BP.travel_date as travel_date, BP.adult as bpr_adult, BP.child as bpr_child, BP.infant as bpr_infant, BP.note as bp_note,
                    BP.private_type as bp_private_type,
                    BPR.id as bpr_id, BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_total as rate_total, 
                    PROD.id as product_id, PROD.name as product_name,
                    CUS.id as cus_id, CUS.name as cus_name, CUS.head as cus_head,
                    BT.id as bt_id, BT.adult as bt_adult, BT.child as bt_child, BT.infant as bt_infant, BT.start_pickup as start_pickup, BT.end_pickup as end_pickup,
                    BT.hotel_pickup as hotel_pickup, BT.hotel_dropoff as hotel_dropoff, BT.room_no as room_no, BT.note as bt_note, BT.transfer_type as transfer_type,
                    BT.pickup_type as pickup_type,
                    BPR.id as bpr_id, BPR.adult as bpr_adult, BPR.child as bpr_child, BPR.infant as bpr_infant, BPR.foc as bpr_foc, 
                        BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_total as rate_total,  
                    CARC.id as cars_category_id, CARC.name as cars_category,
                    BEC.id as bec_id, BEC.name as bec_name, BEC.adult as bec_adult, BEC.child as bec_child, BEC.infant as bec_infant, BEC.privates as bec_privates, BEC.type as bec_type,
                    BEC.rate_adult as bec_rate_adult, BEC.rate_child as bec_rate_child, BEC.rate_infant as bec_rate_infant, BEC.rate_private as bec_rate_private, 
                    EXTRA.id as extra_id, EXTRA.name as extra_name,
                    PICK.id as pickup_id, PICK.name as pickup_name,
                    REC.id as rec_id
                FROM invoices INV
                LEFT JOIN invoice_cover COVER
                    ON INV.cover_id = COVER.id
                LEFT JOIN vat_type VAT
                    ON INV.vat_id = VAT.id
                LEFT JOIN payments_type PAYT
                    ON INV.payment_id = PAYT.id
                LEFT JOIN bank_account BANACC
                    ON INV.bank_account_id = BANACC.id
                LEFT JOIN banks BANK
                    ON BANACC.bank_id = BANK.id
                LEFT JOIN branches BRCH
                    ON INV.branche_id = BRCH.id
                LEFT JOIN bookings BO
                    ON INV.booking_id = BO.id
                LEFT JOIN bookings_no BONO
                    ON BO.id = BONO.booking_id
                LEFT JOIN booking_status BSTA
                    ON BO.booking_status_id = BSTA.id
                LEFT JOIN booking_type BTYE
                    ON BO.booking_type_id = BTYE.id
                LEFT JOIN companies COMP
                    ON BO.company_id = COMP.id
                LEFT JOIN booking_paid BOPA
                    ON BO.id = BOPA.booking_id
                LEFT JOIN booking_payment BOPAY
                    ON BOPA.booking_payment_id = BOPAY.id
                LEFT JOIN booking_paid_detail BOPAE
                    ON BOPA.id = BOPAE.booking_paid_id
                LEFT JOIN booking_products BP
                    ON BO.id = BP.booking_id
                LEFT JOIN booking_product_rates BPR
                    ON BP.id = BPR.booking_products_id
                LEFT JOIN booking_transfer BT
                    ON BP.id = BT.booking_products_id
                LEFT JOIN booking_transfer_rates BTR
                    ON BT.id = BTR.booking_transfer_id
                LEFT JOIN cars_category CARC
                    ON BTR.cars_category_id = CARC.id 
                LEFT JOIN booking_extra_charge BEC
                    ON BO.id = BEC.booking_id
                LEFT JOIN extra_charges EXTRA
                    ON BEC.extra_charge_id = EXTRA.id
                LEFT JOIN products PROD
                    ON BP.product_id = PROD.id
                LEFT JOIN customers CUS
                    ON BO.id = CUS.booking_id
                LEFT JOIN place PICK
                    ON BT.pickup_id = PICK.id
                LEFT JOIN receipts REC
                    ON COVER.id = REC.cover_id
                WHERE INV.is_deleted = 0
                AND (REC.id IS NULL OR REC.is_deleted = 1)
        ";

        if (isset($period) && $period != "all") {
            $query .= " AND INV.rec_date BETWEEN ? AND ?";
            $bind_types .= "ss";
            array_push($params, $date_form, $date_to);
        }

        if (isset($agent) && $agent != "all") {
            $query .= " AND COMP.id = ?";
            $bind_types .= "i";
            array_push($params, $agent);
        }

        $query .= " ORDER BY COVER.inv_full ASC";
        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
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
            WHERE companies.is_deleted = 0 AND companies.company_type_id = 2
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showpaymentstype(int $num)
    {
        $query = "SELECT id, name, type
            FROM payments_type 
            WHERE id > 0
        ";
        $query .= $num > 0 ? " AND type = " . $num : "";
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showbank()
    {
        $query = "SELECT id, name
            FROM banks 
            WHERE id > 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showvat()
    {
        $query = "SELECT id, name
            FROM vat_type 
            WHERE id > 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showbranch()
    {
        $query = "SELECT id, name
            FROM branches 
            WHERE id > 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showpayments(int $num)
    {
        $query = "SELECT id, name, type
            FROM payments_type 
            WHERE id > 0
        ";
        $query .= $num > 0 ? " AND type = " . $num : "";
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showbankaccount()
    {
        $query = "SELECT BAA.*,
            BAN.id as banID, BAN.name as banName 
            FROM bank_account BAA
            LEFT JOIN banks BAN
                ON BAA.bank_id = BAN.id
            WHERE BAA.id > 0
        ";
        $query .= " ORDER BY BAA.account_name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function checkrecno()
    {
        $query = "SELECT *,
            MAX(rec_no) as max_rec_no
            FROM receipts 
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

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

    public function insert_data(int $rec_no, string $rec_full, string $rec_date, int $cheque_no, string $cheque_date, int $bank_account_id, int $bank_cheque_id, int $cover_id, int $payment_id, int $is_approved, string $note, array $fileimg)
    {
        // upload logo file
        $logoResponse = $this->uploadFile($fileimg);
        $countlogo = count($logoResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO  receipts (rec_no, rec_full, rec_date, price, cheque_no, cheque_date, file, note, bank_account_id, bank_cheque_id, cover_id, payment_id, receipts_by, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $rec_no);

        $bind_types .= "s";
        array_push($params, $rec_full);

        $bind_types .= "s";
        array_push($params, $rec_date);

        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "i";
        array_push($params, $cheque_no);

        $bind_types .= "s";
        array_push($params, $cheque_date);

        for ($i = 0; $i < $countlogo; $i++) {
            $bind_types .= "s";
            array_push($params, $logoResponse['filename'][$i]);
        }

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, $bank_account_id);

        $bind_types .= "i";
        array_push($params, $bank_cheque_id);

        $bind_types .= "i";
        array_push($params, $cover_id);

        $bind_types .= "i";
        array_push($params, $payment_id);

        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(string $rec_date, int $cheque_no, string $cheque_date, int $bank_account_id, int $bank_cheque_id, int $payment_id, int $is_approved, string $note, int $id, array $fileimg)
    {
        // upload logo file
        $logoResponse = $this->uploadFile($fileimg);
        $countlogo = count($logoResponse);

        $bind_types = "";
        $params = array();

        $query = "UPDATE receipts SET";

        $query .= " rec_date = ?,";
        $bind_types .= "s";
        array_push($params, $rec_date);

        $query .= " cheque_no = ?,";
        $bind_types .= "i";
        array_push($params, $cheque_no);

        $query .= " cheque_date = ?,";
        $bind_types .= "s";
        array_push($params, $cheque_date);

        $query .= " bank_account_id = ?,";
        $bind_types .= "s";
        array_push($params, $bank_account_id);

        $query .= " bank_cheque_id = ?,";
        $bind_types .= "s";
        array_push($params, $bank_cheque_id);

        $query .= " payment_id = ?,";
        $bind_types .= "s";
        array_push($params, $payment_id);

        for ($i = 0; $i < $countlogo; $i++) {
            $query .= " file = ?,";
            $bind_types .= "s";
            array_push($params, $logoResponse['filename'][$i]);
        }

        $query .= " note = ?,";
        $bind_types .= "s";
        array_push($params, $note);

        $query .= " receipts_by = ?,";
        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);

        $query .= " updated_at = now()";

        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_data(int $id)
    {
        $query = "DELETE FROM receipts WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function insert_booking_paid(int $bo_id, int $book_payment)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_paid (booking_payment_id, booking_id, user_id, updated_at, created_at)
        VALUES (?, ?, ?, now(), now())";

        $bind_types .= "i";
        array_push($params, $book_payment);

        $bind_types .= "i";
        array_push($params, $bo_id);

        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_booking_paid(int $bo_id, int $book_payment)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_paid SET";

        $query .= " booking_payment_id = ?,";
        $bind_types .= "i";
        array_push($params, $book_payment);

        $query .= " updated_at = now()";

        $query .= " WHERE booking_id = ?";
        $bind_types .= "i";
        array_push($params, $bo_id);

        $query .= " AND booking_payment_id = 6";

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_booking_paid(int $id)
    {

        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_paid SET";

        $query .= " booking_payment_id = ?,";
        $bind_types .= "i";
        array_push($params, 6);

        $query .= " updated_at = now()";

        $query .= " WHERE booking_id = ?";
        $bind_types .= "i";
        array_push($params, $id);

        $query .= " AND booking_payment_id = 3";

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;

        // $query = "DELETE FROM booking_paid WHERE booking_id = ? AND booking_payment_id = 3";
        // $statement = $this->connection->prepare($query);
        // $statement->bind_param("i", $id);
        // $statement->execute();
        // if ($statement->execute()) {
        //     $this->response = true;
        // }

        // return $this->response;
    }

    public function uploadFile(array $fileArray)
    {
        $responseFilename = array();
        $countfiles = count($fileArray);
        for ($i = 0; $i < $countfiles; $i++) {
            $fileTmpPath = !empty($fileArray['fileTmpPath'][$i]) ? $fileArray['fileTmpPath'][$i] : '';
            $fileName = !empty($fileArray['fileName'][$i]) ? $fileArray['fileName'][$i] : '';
            $fileSize = !empty($fileArray['fileSize'][$i]) ? $fileArray['fileSize'][$i] : '';
            $fileBefore = !empty($fileArray['fileBefore'][$i]) ? $fileArray['fileBefore'][$i] : '';
            $fileDelete = !empty($fileArray['fileDelete'][$i]) ? $fileArray['fileDelete'][$i] : '';
            $uploadFileDir = !empty($fileArray['uploadFileDir'][$i]) ? $fileArray['uploadFileDir'][$i] : '../../../storage/uploads/receipt/';

            if (!empty($fileName)) {
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $allowedfileExtensions = array('jpg', 'jpeg', 'png');
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                    // directory in which the uploaded file will be moved
                    $targetPath = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $targetPath)) {
                        $responseFilename['filename'][$i] = $newFileName;
                        !empty($fileBefore) ? unlink($uploadFileDir . $fileBefore) : '';
                    }
                }
            } elseif ($fileDelete == 1) {
                !empty($fileBefore) ? unlink($uploadFileDir . $fileBefore) : '';
                $responseFilename['filename'][$i] = "";
            } else {
                $responseFilename['filename'][$i] = $fileBefore;
            }
        }

        return $responseFilename;
    }
}
