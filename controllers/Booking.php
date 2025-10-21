<?php
require_once __DIR__ . '/DB.php';

class Booking extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_age(string $date)
    {
        $then = strtotime($date);
        return (floor((time() - $then) / 31556926));
    }

    public function showlist(int $id, $search_status, string $payment, string $search_agent, string $search_product, string $search_travel, string $voucher_no, string $refcode, string $name)
    {
        $query = "SELECT BO.*,
                        BONO.bo_full as book_full,
                        BSTA.id as booksta_id, BSTA.name as booksta_name, BSTA.name_class as booksta_class, BSTA.button_class as booksta_button,
                        BTYE.id as booktye_id, BTYE.name as booktye_name,
                        BOPA.id as bopa_id, BOPA.date_paid as date_paid, BOPA.total_paid as total_paid, BOPA.card_no as card_no, 
                        BOPA.photo as bopa_photo, BOPA.note as bopa_note, BOPA.payment_type_id as payment_type_id, BOPA.bank_account_id as bank_account_id, BOPA.updated_at as bopa_updated,
                        BOPAY.id as bopay_id, BOPAY.name as bopay_name, BOPAY.name_class as bopay_name_class, BOPAY.created_at as bopay_created,
                        COMP.id as comp_id, COMP.name as comp_name,
                        CUS.id as cus_id, CUS.name as cus_name, CUS.birth_date as birth_date, CUS.id_card as id_card, CUS.telephone as telephone, CUS.address as cus_address, CUS.head as cus_head, CUS.nationality_id as nationality_id,
                        NATION.id as nation_id, NATION.name as nation_name,
                        BP.id as bp_id, BP.travel_date as travel_date,  BP.note as bp_note, BP.private_type as bp_private_type,
                        PROD.id as product_id, PROD.name as product_name,
                        CATE.id as category_id, CATE.name as category_name, CATE.transfer as category_transfer,
                        BPR.id as bpr_id, BPR.adult as bpr_adult, BPR.child as bpr_child, BPR.infant as bpr_infant, BPR.foc as bpr_foc, 
                        BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_private as rate_private, BPR.rate_total as rate_total,  
                        BT.id as bt_id, BT.adult as bt_adult, BT.child as bt_child, BT.infant as bt_infant, BT.foc as bt_foc, BT.start_pickup as start_pickup, BT.end_pickup as end_pickup,
                        BT.hotel_pickup as hotel_pickup, BT.hotel_dropoff as hotel_dropoff, BT.room_no as room_no, BT.note as bt_note, BT.transfer_type as transfer_type,
                        BT.pickup_type as pickup_type,
                        BTR.id as btr_id, BTR.rate_adult as btr_rate_adult, BTR.rate_child as btr_rate_child, BTR.rate_infant as btr_rate_infant, BTR.cars_category_id as cars_category,
                        BTR.rate_private as btr_rate_private,
                        PICKUP.id as pickup_id, PICKUP.name_th as hotel_pickup_name,
                        DROPOFF.id as dropoff_id, DROPOFF.name_th as hotel_dropoff_name,
                        CARC.id as carc_id, CARC.name as carc_name,
                        BEC.id as bec_id, BEC.name as bec_name, BEC.adult as bec_adult, BEC.child as bec_child, BEC.infant as bec_infant, BEC.privates as bec_privates, BEC.type as bec_type,
                        BEC.rate_adult as bec_rate_adult, BEC.rate_child as bec_rate_child, BEC.rate_infant as bec_rate_infant, BEC.rate_private as bec_rate_private, 
                        EXTRA.id as extra_id, EXTRA.name as extra_name,
                        BOOKER.id as booker_id, BOOKER.firstname as booker_fname, BOOKER.lastname as booker_lname,
                        PICK.id as pickup_id, PICK.name as pickup_name, 
                        DROF.id as dropoff_id, DROF.name as dropoff_name,
                        BOMANGE.id as bomange_id,
                        MANGET.id as manget_id, MANGET.license as license, MANGET.seat as seat,
                        CAR.id as car_id, CAR.name as car_name, CAR.name as car_name,
                        BORDB.id as boman_id, BORDB.arrange as boman_arrange, 
                        MANGE.id as mange_id, MANGE.time as manage_time,
                        COLOR.id as color_id, COLOR.name as color_name, COLOR.name_th as color_name_th, COLOR.hex_code as color_hex,
                        GUIDE.id as guide_id, GUIDE.name as guide_name,
                        BOAT.id as boat_id, BOAT.name as boat_name, BOAT.refcode as boat_refcode,
                        CONFIRM.id as confirm_id
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
                    LEFT JOIN customers CUS
                        ON BO.id = CUS.booking_id
                    LEFT JOIN nationalitys NATION
                        ON CUS.nationality_id = NATION.id
                    LEFT JOIN booking_products BP
                        ON BO.id = BP.booking_id
                    LEFT JOIN products PROD
                        ON BP.product_id = PROD.id
                    LEFT JOIN booking_product_rates BPR
                        ON BP.id = BPR.booking_products_id
                    LEFT JOIN product_category CATE
                        ON BPR.category_id = CATE.id
                    LEFT JOIN booking_transfer BT
                        ON BP.id = BT.booking_products_id
                    LEFT JOIN booking_transfer_rates BTR
                        ON BT.id = BTR.booking_transfer_id
                    LEFT JOIN hotel PICKUP
                        ON BT.hotel_pickup_id = PICKUP.id
                    LEFT JOIN hotel DROPOFF
                        ON BT.hotel_dropoff_id = DROPOFF.id
                    LEFT JOIN cars_category CARC
                        ON BTR.cars_category_id = CARC.id    
                    LEFT JOIN booking_extra_charge BEC
                        ON BO.id = BEC.booking_id
                    LEFT JOIN extra_charges EXTRA
                        ON BEC.extra_charge_id = EXTRA.id
                    LEFT JOIN zones PICK
                        ON BT.pickup_id = PICK.id
                    LEFT JOIN zones DROF
                        ON BT.dropoff_id = DROF.id
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
                    LEFT JOIN confirm_agent CONFIRM
                        ON COMP.id = CONFIRM.agent_id
                    LEFT JOIN users BOOKER 
                        ON BO.booker_id = BOOKER.id
                    WHERE BO.id > 0
                    AND BP.is_deleted = 0
        ";

        if (!empty($search_status) && $search_status != 'all') {
            $query .= " AND BSTA.id = " . $search_status;
        }

        if (!empty($payment) && $payment != 'all') {
            $query .= " AND BOPAY.id = " . $payment;
        }

        if (!empty($search_agent) && $search_agent != 'all') {
            $query .= " AND BO.company_id = " . $search_agent;
        }

        if (!empty($search_product) && $search_product != 'all') {
            $query .= " AND BP.product_id = " . $search_product;
        }

        if (!empty($search_travel) && $search_travel != '0000-00-00') {
            $query .= " AND BP.travel_date = '" . $search_travel . "'";
        }

        if (!empty($voucher_no)) {
            $query .= " AND BO.voucher_no_agent LIKE '%" . $voucher_no . "%' ";
        }

        if (!empty($refcode)) {
            $query .= " AND BONO.bo_full LIKE '%" . $refcode . "%' ";
        }

        if (!empty($name)) {
            $query .= " AND CUS.name LIKE '%" . $name . "%' ";
        }

        $query .= " ORDER BY BO.id DESC, BP.travel_date ASC, BOPA.id ASC, CUS.id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_agent()
    {
        $query = "SELECT id, name, company_type_id, is_approved
            FROM companies 
            WHERE is_approved = 1 AND company_type_id != 1
            AND is_approved = 1 AND is_deleted = 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function shownation()
    {
        $query = "SELECT id, name, is_approved
            FROM nationalitys 
            WHERE is_approved = 1
        ";

        $query .= " ORDER BY 
                CASE
                    WHEN id = 182 THEN 1
                    WHEN id = 39 THEN 2
                    WHEN id = 92 THEN 3
                    WHEN id = 231 THEN 4
                    WHEN id = 71 THEN 5
                    ELSE 6
                END,
                name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_booking_type()
    {
        $query = "SELECT id, name
            FROM booking_type 
            WHERE id > 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_extra_charge()
    {
        $query = "SELECT *
            FROM extra_charges 
            WHERE is_approved = 1
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_booking_status()
    {
        $query = "SELECT id, name, button_class
            FROM booking_status 
            WHERE id > 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_cars_category()
    {
        $query = "SELECT * FROM cars_category
            WHERE id > 0 
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_hotel()
    {
        $query = "SELECT hotel.*,
                zones.id as zone_id, zones.start_pickup as start_pickup, zones.end_pickup as end_pickup
                FROM hotel
                LEFT JOIN zones
                    ON hotel.zone_id = zones.id
                WHERE hotel.is_deleted = 0
        ";
        $query .= " ORDER BY hotel.name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_zone()
    {
        $query = "SELECT *
            FROM zones
            WHERE is_deleted = 0
        ";

        // $query .= " ORDER BY                 
        //     CASE
        //         WHEN id = 17 THEN 1
        //         WHEN id = 13 THEN 2
        //         WHEN id = 14 THEN 3
        //         WHEN id = 2 THEN 4
        //         ELSE 5
        //     END,
        //     id ASC";

        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showlanguages()
    {
        $query = "SELECT *
            FROM languages
        ";

        // $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function search_time_zone(int $product_id, int $zone_id)
    {
        $query = "SELECT zones.*,
                    TZ.id as tz_id, TZ.start_pickup as start_pickup, TZ.end_pickup as end_pickup
                    FROM zones
                    LEFT JOIN time_zone TZ
                        ON zones.id = TZ.zone_id
                    WHERE zones.id = $zone_id
                    AND TZ.product_id = $product_id
                    ";
        $query .= " ORDER BY zones.id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
       
        return $data;
    }

    public function show_products_type()
    {
        $query = "SELECT id, name, slug
            FROM products_type 
            WHERE id > 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_payments_type(int $num)
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

    public function show_bank_account()
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

    public function show_bank()
    {
        $query = "SELECT *
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

    public function show_currency()
    {
        $query = "SELECT id, name
            FROM currencys 
            WHERE id > 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_vat()
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

    public function show_booking_payment()
    {
        $query = "SELECT *
            FROM booking_payment 
            WHERE id > 0
            AND type != 2
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function search_hotel(int $zone_id)
    {
        $query = "SELECT *
                FROM hotel
                WHERE is_deleted = 0
                AND zone_id = $zone_id
                OR zone_id = 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showcurrency()
    {
        $query = "SELECT id, name
            FROM currencys 
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

    public function showlog(int $booking_id)
    {
        $query = "SELECT log_booking.*,
            users.firstname as firstname, users.lastname as lastname
            FROM log_booking 
            LEFT JOIN users
                ON log_booking.user_id = users.id
            WHERE log_booking.id > 0
            AND log_booking.booking_id = $booking_id
        ";
        $query .= " ORDER BY log_booking.id ASC";
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

    public function search_program(int $agent_id, string $travel_date, int $bp_id, int $book_type)
    {
        $query = "SELECT PROD.*,
                PRODC.id as categoryid, PRODC.name as categoryname,
                PRODP.id as periodid,
                PRODR.id as prodrid, PRODR.rate_adult as rate_adult, PRODR.rate_child as rate_child, PRODR.rate_infant as rate_infant, PRODR.rate_private as rate_private
                FROM products PROD
                LEFT JOIN product_category PRODC
                    ON PROD.id = PRODC.product_id
                LEFT JOIN product_periods PRODP
                    ON PRODC.id = PRODP.product_category_id
                LEFT JOIN company_rate COMR
                    ON PRODP.id = COMR.product_period_id
                LEFT JOIN product_rates PRODR
                    ON COMR.product_rate_id = PRODR.id
                WHERE PROD.is_approved = 1 
                AND PROD.is_deleted = 0
                AND PRODC.is_approved = 1
                AND PRODC.is_deleted = 0
                AND PRODP.is_approved = 1
                AND PRODP.is_deleted = 0
                AND COMR.company_id = ?
                ";

        if ($book_type == 1) {
            $query .= " AND PRODP.period_from <= '" . $travel_date . "'";
            $query .= " AND PRODP.period_to >= '" . $travel_date . "'";
        }

        $query .= " ORDER BY PROD.name DESC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $agent_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function get_data(int $id)
    {
        $query = "SELECT BO.*,
                BONO.bo_full as book_full,
                BSTA.id as booksta_id, BSTA.name as booksta_name, BSTA.name_class as booksta_class, BSTA.button_class as booksta_button,
                BTYE.id as booktye_id, BTYE.name as booktye_name,
                BOPA.id as bopa_id, BOPA.date_paid as date_paid, BOPA.total_paid as total_paid, BOPA.card_no as card_no, 
                BOPA.photo as bopa_photo, BOPA.note as bopa_note, BOPA.payment_type_id as payment_type_id, BOPA.bank_account_id as bank_account_id, BOPA.updated_at as bopa_updated,
                BOPAY.id as bopay_id, BOPAY.name as bopay_name, BOPAY.created_at as bopay_created,
                USPAD.id as uspad_id, USPAD.firstname as uspad_firstname, USPAD.lastname as uspad_lastname,
                COMP.id as comp_id, COMP.name as comp_name, COMP.tat_license as tat_license, COMP.telephone as comp_telephone, COMP.address as comp_address,
                CUS.id as cus_id, CUS.name as cus_name, CUS.birth_date as birth_date, CUS.id_card as id_card, CUS.telephone as telephone, CUS.address as cus_address, CUS.age as cus_age, CUS.type as cus_type, CUS.head as cus_head, CUS.nationality_id as nationality_id,
                NATION.id as nation_id, NATION.name as nation_name,
                BP.id as bp_id, BP.travel_date as travel_date, BP.note as bp_note, BP.private_type as bp_private_type,
                PROD.id as product_id, PROD.name as product_name,
                CATE.id as category_id, CATE.name as category_name, CATE.customer as category_cus,
                languages.id as lang_id, languages.name_thai as lang_name,
                BPR.id as bpr_id, BPR.adult as bpr_adult, BPR.child as bpr_child, BPR.infant as bpr_infant, BPR.foc as bpr_foc, 
                BPR.rate_adult as rate_adult, BPR.rate_child as rate_child, BPR.rate_infant as rate_infant, BPR.rate_private as rate_private, BPR.rate_total as rate_total, BPR.product_rates_id as pror_id, 
                BT.id as bt_id, BT.adult as bt_adult, BT.child as bt_child, BT.infant as bt_infant, BT.foc as bt_foc, BT.start_pickup as start_pickup, BT.end_pickup as end_pickup,
                BT.hotel_pickup as hotel_pickup, BT.hotel_dropoff as hotel_dropoff, BT.room_no as room_no, BT.note as bt_note, BT.transfer_type as transfer_type,
                BT.pickup_type as pickup_type,
                HOTPIK.id as hotel_pickup_id, HOTPIK.name as hotel_pickup_name,
                HOTDRO.id as hotel_dropoff_id, HOTDRO.name as hotel_dropoff_name,
                BTR.id as btr_id, BTR.rate_adult as btr_rate_adult, BTR.rate_child as btr_rate_child, BTR.rate_infant as btr_rate_infant, BTR.cars_category_id as cars_category,
                BTR.rate_private as btr_rate_private,
                CARC.id as carc_id, CARC.name as carc_name,
                BEC.id as bec_id, BEC.name as bec_name, BEC.adult as bec_adult, BEC.child as bec_child, BEC.infant as bec_infant, BEC.privates as bec_privates, BEC.type as bec_type,
                BEC.rate_adult as bec_rate_adult, BEC.rate_child as bec_rate_child, BEC.rate_infant as bec_rate_infant, BEC.rate_private as bec_rate_private, 
                EXTRA.id as extra_id, EXTRA.name as extra_name,
                BOOKER.id as booker_id, BOOKER.firstname as booker_fname, BOOKER.lastname as booker_lname,
                PICK.id as pickup_id, PICK.name as pickup_name, 
                DROF.id as dropoff_id, DROF.name as dropoff_name,
                INV.id as inv_id, INV.rec_date as rec_date, INV.withholding as withholding, INV.branche_id as branche_id, INV.vat_id as vat_id, 
                INV.currency_id as currency_id, INV.bank_account_id as inv_bank_account, INV.note as inv_note, 
                COVER.id as cover_id, COVER.inv_date as inv_date, COVER.inv_full as inv_full,
                BOMANGE.id as bomange_id,
                MANGET.id as manget_id,
                BORDB.id as boman_id, 
                MANGE.id as mange_id,
                CONFIRM.id as confirm_id
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
            LEFT JOIN users USPAD 
                ON BOPA.user_id = USPAD.id
            LEFT JOIN companies COMP
                ON BO.company_id = COMP.id
            LEFT JOIN customers CUS
                ON BO.id = CUS.booking_id
            LEFT JOIN nationalitys NATION
                ON CUS.nationality_id = NATION.id
            LEFT JOIN booking_products BP
                ON BO.id = BP.booking_id
            LEFT JOIN products PROD
                ON BP.product_id = PROD.id
            LEFT JOIN booking_product_rates BPR
                ON BP.id = BPR.booking_products_id
            LEFT JOIN product_category CATE
                ON BPR.category_id = CATE.id
            LEFT JOIN languages
                ON BP.language_id = languages.id
            LEFT JOIN booking_transfer BT
                ON BP.id = BT.booking_products_id
            LEFT JOIN booking_transfer_rates BTR
                ON BT.id = BTR.booking_transfer_id
            LEFT JOIN hotel HOTPIK
                ON BT.hotel_pickup_id = HOTPIK.id
            LEFT JOIN hotel HOTDRO
                ON BT.hotel_dropoff_id = HOTDRO.id
            LEFT JOIN cars_category CARC
                ON BTR.cars_category_id = CARC.id    
            LEFT JOIN booking_extra_charge BEC
                ON BO.id = BEC.booking_id
            LEFT JOIN extra_charges EXTRA
                ON BEC.extra_charge_id = EXTRA.id
            LEFT JOIN zones PICK
                ON BT.pickup_id = PICK.id
            LEFT JOIN zones DROF
                ON BT.dropoff_id = DROF.id
            LEFT JOIN users BOOKER 
                ON BO.booker_id = BOOKER.id
            LEFT JOIN invoices INV
                ON INV.booking_id = BO.id
            LEFT JOIN invoice_cover COVER
                ON INV.cover_id = COVER.id
            LEFT JOIN booking_order_transfer BOMANGE
                ON BT.id = BOMANGE.booking_transfer_id
            LEFT JOIN order_transfer MANGET 
                ON BOMANGE.order_id = MANGET.id
                AND MANGET.pickup = 1
            LEFT JOIN booking_order_boat BORDB
                ON BO.id = BORDB.booking_id
            LEFT JOIN order_boat MANGE 
                ON BORDB.manage_id = MANGE.id
            LEFT JOIN confirm_agent CONFIRM
                ON COMP.id = CONFIRM.agent_id
                AND CONFIRM.travel_date = BP.travel_date
            WHERE BO.id = ? AND BO.is_deleted = 0
        ";

        $query .= " ORDER BY CUS.id ASC, BOPA.id ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            // $data = $result->fetch_assoc();
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = false;
        }

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

    public function get_values(string $select, string $from, string $where)
    {
        $query = "SELECT $select
            FROM $from 
            WHERE $where
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

        return $data;
    }

    public function search(string $refcode, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT BO.*,
                    BP.id as bpID, BP.travel_date as bpTravelDate, BP.adult as bpAdult, BP.child as bpChild, BP.infant as bpInfant, 
                    BONO.id as bonoID, BONO.bo_full as bonoFull,
                    BTY.id as btyID, BTY.name as btyName, 
                    COMP.id as compID, COMP.name as compName, 
                    BOSTA.id as bostaID, BOSTA.name as bostaName, BOSTA.name_class as bostaNameClass, 
                    PRO.id as proID, PRO.name as proName,
                    CATE.id as cateID, CATE.name as cateName,
                    BPR.id as bprID, BPR.rate_adult as bprRateAdult, BPR.rate_child as bprRateChild, BPR.rate_infant as bprRateInfant, 
                    BPR.rate_group as bprRateGroup, BPR.pax_group as bprPaxGroup, BPR.rate_total as bprRateTotal,
                    BT.id as btID, BT.adult as btAdult, BT.child as btChild, BT.infant as btInfant, BT.hotel_name as btHotelName,
                    BT.room_no as btRoomNo, BT.note as btNote, BT.private_type as btPrivateType,
                    BTR.id as btrID, BTR.rate_adult as btrRateAdult, BTR.rate_child as btrRateChild, BTR.rate_infant as btrRateInfant, 
                    BTR.rate_private as btrRatePrivate,
                    PLA.id as plaID, PLA.name as plaName,
                    CAR.id as carID, CAR.name as carName,
                    CUS.id as cusID
                FROM bookings BO  
                LEFT JOIN booking_products BP
                    ON BO.id = BP.booking_id
                LEFT JOIN bookings_no BONO
                    ON BO.id = BONO.booking_id
                LEFT JOIN booking_type BTY
                    ON BO.booking_type_id = BTY.id
                LEFT JOIN companies COMP
                    ON BO.company_id = COMP.id
                LEFT JOIN booking_status BOSTA
                    ON BO.booking_status_id = BOSTA.id
                LEFT JOIN products PRO
                    ON BP.product_id = PRO.id
                LEFT JOIN product_category CATE
                    ON BP.category_id = CATE.id
                LEFT JOIN booking_product_rates BPR
                    ON BP.id = BPR.booking_products_id
                LEFT JOIN booking_transfer BT
                    ON BP.id = BT.booking_products_id
                LEFT JOIN booking_transfer_rates BTR
                    ON BT.id = BTR.booking_transfer_id
                LEFT JOIN place PLA
                    ON BT.pickup_id = PLA.id
                LEFT JOIN cars_category CAR
                    ON BTR.cars_category_id = CAR.id
                LEFT JOIN customers CUS
                    ON BO.id = CUS.booking_id
                WHERE BO.id > 0
                    ";

        if (!empty($refcode)) {
            $query .= " AND BONO.bo_full LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $refcode . '%');
        }
        if (!empty($name)) {
            $query .= " AND CUS.firstname LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $name . '%');
        }
        $query .= " ORDER BY BO.id DESC";

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_customer(int $id)
    {
        $query = "SELECT CUS.*,
            NATI.id as natiID, NATI.name as natiName
            FROM customers CUS
            LEFT JOIN nationalitys NATI
                ON CUS.nationality_id = NATI.id
            WHERE CUS.booking_id = ?
        ";
        $query .= " ORDER BY CUS.head DESC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = false;
        }

        return $data;
    }

    public function check_doubly_agent(int $agent, string $voucher_no_agent)
    {
        $query = "SELECT id, company_id, voucher_no_agent
                FROM bookings 
                WHERE company_id = $agent
                AND voucher_no_agent = $voucher_no_agent
                AND booking_status_id != 3 
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();

        return $result->num_rows;
    }

    public function show_private_transfer(int $bp_id, int $period_id, int $pickup, int $cars_id)
    {
        if ($bp_id > 0) {
            $query = "SELECT BTR.*,
                CAR.id as carID, CAR.name as carName
                FROM booking_transfer_rates BTR
                LEFT JOIN cars_category CAR
                    ON BTR.cars_category_id = CAR.id
                WHERE BTR.booking_products_id = ?
            ";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("i", $bp_id);
            $statement->execute();
            $result = $statement->get_result();
            if ($result->num_rows > 0) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $data = false;
            }
        } else {
            $query = "SELECT LR.*,
                PRT.id as prtID, PRT.rate_private as prtRatePrivate
                FROM location_rates LR 
                LEFT JOIN product_rates_transfer PRT
                    ON LR.rates_transfer_id = PRT.id
                WHERE LR.product_period_id = ?
                AND LR.place_id = ?
                AND PRT.cars_category_id = ?
            ";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("iii", $period_id, $pickup, $cars_id);
            $statement->execute();
            $result = $statement->get_result();
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
            } else {
                $data = false;
            }
        }

        return $data;
    }

    public function show_booking_extra(int $booking_id)
    {
        $query = "SELECT BEC.*,
            EC.id as ecID, EC.name as ecName
            FROM booking_extra_charge BEC 
            LEFT JOIN extra_charges EC
                ON BEC.extra_charge_id = EC.id
            WHERE BEC.booking_id = ? AND BEC.is_deleted = 0
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $booking_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_booking_products(int $id)
    {
        $query = "SELECT BPRO.*,
            PROD.id as prodID, PROD.name as prodName,
            PROCA.id as procaID, PROCA.name as procaName, PROCA.transfer as procaTransfer,
            DROF.id as drofID, DROF.name as drofName 
            FROM booking_products BPRO
            LEFT JOIN products PROD
                ON BPRO.product_id = PROD.id
            LEFT JOIN product_category PROCA
                ON BPRO.category_id = PROCA.id
            LEFT JOIN place DROF
                ON PROD.dropoff_id = DROF.id
            WHERE booking_id = ? AND BPRO.is_deleted = 0
        ";
        $query .= " ORDER BY id DESC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_booking_products_rate(int $id)
    {
        $query = "SELECT booking_products.*,
            products.id as prodID, products.name as prodName,
            booking_product_rates.id as bookingProdRateID, booking_product_rates.rate_adult as bookingProdRateAdult,
            booking_product_rates.rate_child as bookingProdRateChild, booking_product_rates.rate_infant as bookingProdRateInfant
            FROM booking_products 
            LEFT JOIN products
                    ON booking_products.product_id = products.id
            LEFT JOIN booking_product_rates
                    ON booking_products.id = booking_product_rates.booking_products_id
            WHERE booking_id = ?
        ";
        // $query .= " ORDER BY head DESC, firstname ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_products(int $bp_id, int $product_id, int $agent_id, string $travel_date, int $booking_type)
    {
        $day_no = 0;
        switch (date("l", strtotime($travel_date))) {
            case 'Sunday':
                $day_no = 1;
                break;
            case 'Monday':
                $day_no = 2;
                break;
            case 'Tuesday':
                $day_no = 3;
                break;
            case 'Wednesday':
                $day_no = 4;
                break;
            case 'Thursday':
                $day_no = 5;
                break;
            case 'Friday':
                $day_no = 6;
                break;
            case 'Saturday':
                $day_no = 7;
                break;
        }
        // Check Agent or Customer, Period - is_approved or Edit
        if ($product_id > 0) {
            $query = "SELECT BPR.*,
                    PROR.id as prorID, PROR.product_period_id as prorPeriodID,
                    BP.id as bpID,
                    PD.id as prodID, PD.name as prodName,
                    PROCA.id as procaID, PROCA.name as procaName
                    FROM booking_product_rates BPR
                    LEFT JOIN product_rates PROR
                        ON BPR.product_rates_id = PROR.id
                    LEFT JOIN booking_products BP
                        ON BPR.booking_products_id = BP.id
                    LEFT JOIN products PD
                        ON BP.product_id = PD.id
                    LEFT JOIN product_category PROCA
                        ON BP.category_id = PROCA.id
                    WHERE BPR.booking_products_id = ?
                ";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("i", $bp_id);
            $statement->execute();
            $result = $statement->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            if (($agent_id > 0) && ($booking_type != 2)) {
                $query = "SELECT COMR.*,
                    PROP.id as propID,
                    PROCA.id as procaID, PROCA.name as procaName,
                    PROD.id as prodID, PROD.name as prodName,
                    PRODAY.id as prodatID
                    FROM company_rate COMR
                    LEFT JOIN product_periods PROP
                        ON COMR.product_period_id = PROP.id
                    LEFT JOIN product_category PROCA
                        ON PROP.product_category_id = PROCA.id
                    LEFT JOIN products PROD
                        ON PROCA.product_id = PROD.id
                    LEFT JOIN products_day PRODAY
                        ON PROD.id = PRODAY.product_id
                    WHERE PROP.is_approved = 1
                    AND PROP.is_deleted = 0
                    AND PROD.is_approved = 1
                    AND PROD.is_deleted = 0
                    AND PROCA.is_approved = 1
                    AND PROCA.is_deleted = 0
                    AND COMR.company_id = ?
                    AND PROP.period_from <= ? 
                    AND PROP.period_to >= ?
                    AND PRODAY.day_id = ?
                ";
                $query .= !empty($product_id) ? " AND PROD.id = " . $product_id : "";
                $query .= " ORDER BY PROD.name DESC";
                $statement = $this->connection->prepare($query);
                $statement->bind_param("issi", $agent_id, $travel_date, $travel_date, $day_no);
                $statement->execute();
                $result = $statement->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $query = "SELECT DISTINCT PROCA.id, 
                        PROP.*,
                        PROCA.id as procaID, PROCA.name as procaName,
                        PROD.id as prodID, PROD.name as prodName
                        FROM product_periods PROP
                        LEFT JOIN product_category PROCA
                            ON PROP.product_category_id = PROCA.id
                        LEFT JOIN products PROD
                            ON PROCA.product_id = PROD.id
                        LEFT JOIN products_day PRODAY
                            ON PROD.id = PRODAY.product_id
                        WHERE PROP.is_approved = 1
                        AND PROP.is_deleted = 0
                        AND PROD.is_approved = 1
                        AND PROD.is_deleted = 0
                    ";
                $query .= !empty($travel_date) && ($booking_type != 2) ? " AND PROP.period_from <= " . $travel_date : "";
                $query .= !empty($travel_date) && ($booking_type != 2) ? " AND PROP.period_to >= " . $travel_date : "";
                $query .= !empty($day_no) && ($booking_type != 2) ? " AND PRODAY.day_id = " . $day_no : "";
                $query .= !empty($product_id) && ($booking_type != 2) ? " AND PROD.id = " . $product_id : "";
                $query .= " ORDER BY PROCA.id ASC, PROD.name DESC";
                $statement = $this->connection->prepare($query);
                $statement->execute();
                $result = $statement->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
            }
        }

        return $data;
    }

    public function show_product()
    {
        $query = "SELECT * FROM products WHERE id > 0
            AND is_approved = 1
            AND is_deleted = 0
        ";
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_product_category(int $prod_id)
    {
        $query = "SELECT * FROM product_category 
            WHERE id > 0
            AND product_id = ?
            AND is_approved = 1
            AND is_deleted = 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $prod_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_category_rate($agent_id, int $category_id, string $travel_date)
    {
        $query = "SELECT PRODC.*,
                PRODP.id as periodid,
                PRODR.id as prodrid, PRODR.rate_adult as rate_adult, PRODR.rate_child as rate_child, PRODR.rate_infant as rate_infant, PRODR.rate_private as rate_private
                FROM product_category PRODC
                LEFT JOIN product_periods PRODP
                    ON PRODC.id = PRODP.product_category_id
                LEFT JOIN company_rate COMR
                    ON PRODP.id = COMR.product_period_id
                LEFT JOIN product_rates PRODR
                    ON COMR.product_rate_id = PRODR.id
                WHERE PRODC.id = ? 
                AND PRODP.is_approved = 1
                AND PRODP.is_deleted = 0
                ";

        $query .= " AND PRODP.period_from <= '" . $travel_date . "'";
        $query .= " AND PRODP.period_to >= '" . $travel_date . "'";
        $query .= (isset($agent_id) && $agent_id > 0) ? " AND COMR.company_id = " . $agent_id : "";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $category_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_booking_transfer(int $bp_id)
    {
        $query = "SELECT BTR.*,
                BT.id as btID, BT.adult as btAdult, BT.child as btChild, BT.infant as btInfant, BT.start_pickup as btStartPickup, BT.end_pickup as btEndPickup, BT.hotel_name as btHotelName,
                BT.room_no as btRoomNo, BT.note as btNote, BT.pickup_id as btPickupID, BT.private_type as btPrivateType,
                CARS.id as carsID, CARS.name as carsName,
                PLAC.id as placID, PLAC.name as placName
                FROM booking_transfer_rates BTR
                LEFT JOIN booking_transfer BT
                    ON BTR.booking_transfer_id = BT.id
                LEFT JOIN cars_category CARS
                    ON BTR.cars_category_id = CARS.id
                LEFT JOIN place PLAC
                    ON BT.pickup_id = PLAC.id
                WHERE BT.booking_products_id = ?
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $bp_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_products_detail(int $bp_id, int $bpr_id, int $products_id, int $category_id, int $period_id, int $agent_id)
    {
        if ($bp_id > 0) {
            $query = "SELECT BPR.*
                FROM booking_product_rates BPR
                WHERE BPR.id = ?
            ";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("i", $bpr_id);
            $statement->execute();
            $result = $statement->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            if ($agent_id > 0) {
                $query = "SELECT COMR.*,
                    PROP.id as propID,
                    PROCA.id as procaID, PROCA.name as procaName,
                    PROD.id as prodID, PROD.name as prodName,
                    PROR.id as prorID, PROR.rate_adult as prorRateAdult, PROR.rate_child as prorRateChild, PROR.rate_infant as prorRateInfant 
                    FROM company_rate COMR
                    LEFT JOIN product_periods PROP
                        ON COMR.product_period_id = PROP.id
                    LEFT JOIN product_category PROCA
                        ON PROP.product_category_id = PROCA.id
                    LEFT JOIN products PROD
                        ON PROCA.product_id = PROD.id
                    LEFT JOIN product_rates PROR
                        ON COMR.product_rate_id = PROR.id
                    WHERE PROR.is_approved = 1
                    AND PROR.is_deleted = 0
                    AND COMR.company_id = ?
                    AND COMR.product_period_id = ?
                ";
                $statement = $this->connection->prepare($query);
                $statement->bind_param("ii", $agent_id, $period_id);
                $statement->execute();
                $result = $statement->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $query = "SELECT PROR.*,
                    COMR.id as comrID
                    FROM product_rates PROR
                    LEFT JOIN product_periods PROP
                        ON PROR.product_period_id = PROP.id
                    LEFT JOIN company_rate COMR
                        ON PROR.id = COMR.product_rate_id
                    WHERE PROR.is_approved = 1
                    AND PROR.is_deleted = 0
                    AND PROP.id = ?
                ";
                $query .= " ORDER BY PROR.id ASC";
                $statement = $this->connection->prepare($query);
                $statement->bind_param("i", $period_id);
                $statement->execute();
                $result = $statement->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
            }
        }

        return $data;
    }

    public function show_period(int $products_id, string $travel_date)
    {
        $query = "SELECT *
        FROM product_periods 
        WHERE id > 0 
        AND product_id = ? 
        AND period_from <= ? 
        AND period_to >= ?
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("iss", $products_id, $travel_date, $travel_date);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_rates_transfer(int $bp_id, int $period_id, string $transfer_type, int $pickup, int $default_pickup, string $default_transfer_type)
    {
        if ($bp_id > 0 && $default_pickup == $pickup && $transfer_type == $default_transfer_type) {
            $query = "SELECT *
                    FROM booking_transfer_rates  
                    WHERE booking_products_id = ?
                ";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("i", $bp_id);
        } else {
            $query = "SELECT LOR.*,
                    PRT.id as prtID, PRT.rate_adult as rate_adult, PRT.rate_child as rate_child, 
                    PRT.rate_infant as rate_infant, PRT.rate_private as rate_private,
                    CC.id as ccID, CC.name as ccName
                    FROM location_rates LOR 
                    LEFT JOIN product_rates_transfer PRT
                        ON LOR.rates_transfer_id = PRT.id
                    LEFT JOIN cars_category CC
                        ON PRT.cars_category_id = CC.id
                    WHERE LOR.id > 0
                    AND LOR.place_id = ?
                    AND LOR.product_period_id = ?
                ";
            $query .= $transfer_type == 'join' ? " AND PRT.cars_category_id = 0 " : " AND PRT.cars_category_id = 0 ";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("ii", $pickup, $period_id);
        }
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function book_prod_data(int $bp_id, int $product_id, string $travel_date)
    {
        $query = "SELECT * 
                FROM booking_products
                WHERE product_id = ? 
                AND travel_date = ?
                AND is_deleted = 0
        ";
        $query .= $bp_id > 0 ? " AND id != " . $bp_id : "";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("is", $product_id, $travel_date);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = 0;
        }

        return $data;
    }

    public function insert_booking_paid(int $bo_id, string $date_paid, string $total_paid, string $card_no, string $note, int $payment_type_id, int $bank_account_id, int $book_payment, array $fileArray)
    {
        // upload photo file
        $photoResponse = $this->uploadFile($fileArray);
        $photo = !empty($photoResponse['filename'][0]) ? $photoResponse['filename'][0] : '';

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_paid (date_paid, total_paid, card_no, photo, note, payment_type_id, bank_account_id, booking_payment_id, booking_id, user_id, updated_at, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())";

        $bind_types .= "s";
        array_push($params, $date_paid);

        $bind_types .= "d";
        array_push($params, $total_paid);

        $bind_types .= "s";
        array_push($params, $card_no);

        $bind_types .= "s";
        array_push($params, $photo);

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, $payment_type_id);

        $bind_types .= "i";
        array_push($params, $bank_account_id);

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

    public function update_booking_paid(int $id, string $date_paid, string $total_paid, string $card_no, string $note, int $payment_type_id, int $bank_account_id, int $book_payment, array $fileArray)
    {
        // upload photo file
        $photoResponse = $this->uploadFile($fileArray);
        $photo = !empty($photoResponse['filename'][0]) ? $photoResponse['filename'][0] : '';

        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_paid SET";

        $query .= " date_paid = ?,";
        $bind_types .= "s";
        array_push($params, $date_paid);

        $query .= " total_paid = ?,";
        $bind_types .= "d";
        array_push($params, $total_paid);

        $query .= " card_no = ?,";
        $bind_types .= "s";
        array_push($params, $card_no);

        $query .= " photo = ?,";
        $bind_types .= "s";
        array_push($params, $photo);

        $query .= " note = ?,";
        $bind_types .= "s";
        array_push($params, $note);

        $query .= " payment_type_id = ?,";
        $bind_types .= "i";
        array_push($params, $payment_type_id);

        $query .= " bank_account_id = ?,";
        $bind_types .= "i";
        array_push($params, $bank_account_id);

        $query .= " booking_payment_id = ?,";
        $bind_types .= "i";
        array_push($params, $book_payment);

        $query .= " user_id = ?,";
        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

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

    public function insert_data(int $booking_status_id, int $booking_type_id, string $booking_date, string $booking_time, int $company_id, string $voucher_no_agent, string $sender)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO bookings (booking_date, booking_time, voucher_no_agent, discount_type, discount, sender, booker_id, company_id, booking_status_id, booking_type_id, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $booking_date);

        $bind_types .= "s";
        array_push($params, $booking_time);

        $bind_types .= "s";
        array_push($params, $voucher_no_agent);

        // discount_type
        $bind_types .= "i";
        array_push($params, 1);

        // discount
        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "s";
        array_push($params, $sender);

        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $bind_types .= "i";
        array_push($params, $company_id);

        $bind_types .= "i";
        array_push($params, $booking_status_id);

        $bind_types .= "i";
        array_push($params, $booking_type_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $id, int  $book_status, string $voucher_no_agent, string $sender, int $company_id, int $booking_type_id, string $discount)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE bookings SET";

        $query .= " voucher_no_agent = ?,";
        $bind_types .= "s";
        array_push($params, $voucher_no_agent);

        $query .= " sender = ?,";
        $bind_types .= "s";
        array_push($params, $sender);

        $query .= " booking_status_id = ?,";
        $bind_types .= "i";
        array_push($params, $book_status);

        $query .= " booking_type_id = ?,";
        $bind_types .= "i";
        array_push($params, $booking_type_id);

        $query .= " company_id = ?,";
        $bind_types .= "i";
        array_push($params, $company_id);

        $query .= " discount = ?,";
        $bind_types .= "d";
        array_push($params, $discount);

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

    public function update_booking_discount(int $id, string $discount)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE bookings SET";

        $query .= " discount = ?,";
        $bind_types .= "d";
        array_push($params, $discount);

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

    public function update_booking_payment(int $id, int $book_payment, string $payment_paid)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE bookings SET";

        $query .= " payment_paid = ?,";
        $bind_types .= "d";
        array_push($params, $payment_paid);

        $query .= " payment_id = ?,";
        $bind_types .= "i";
        array_push($params, $book_payment);

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

    public function insert_customer(string $name, string $birth_date, string $id_card, string $telephone, string $address, int $age, int $type, string $email, int $head, int $booking_id, int $nationality_id)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO customers (name, birth_date, id_card, telephone, address, age, type, email, head, booking_id, nationality_id, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $birth_date);

        $bind_types .= "s";
        array_push($params, $id_card);

        $bind_types .= "s";
        array_push($params, $telephone);

        $bind_types .= "s";
        array_push($params, $address);

        $bind_types .= "i";
        array_push($params, $age);

        $bind_types .= "i";
        array_push($params, $type);

        $bind_types .= "s";
        array_push($params, $email);

        $bind_types .= "i";
        array_push($params, $head);

        $bind_types .= "i";
        array_push($params, $booking_id);

        $bind_types .= "i";
        array_push($params, $nationality_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function update_customer(int $id, string $name, string $birth_date, string $id_card, string $telephone, int $age, int $type, int $nationality_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE customers SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " birth_date = ?,";
        $bind_types .= "s";
        array_push($params, $birth_date);

        $query .= " id_card = ?,";
        $bind_types .= "s";
        array_push($params, $id_card);

        $query .= " telephone = ?,";
        $bind_types .= "s";
        array_push($params, $telephone);

        $query .= " age = ?,";
        $bind_types .= "i";
        array_push($params, $age);

        $query .= " type = ?,";
        $bind_types .= "i";
        array_push($params, $type);

        $query .= " nationality_id = ?,";
        $bind_types .= "i";
        array_push($params, $nationality_id);

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

    public function delete_customer(int $id)
    {
        $query = "DELETE FROM customers 
                WHERE id = ?
                ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function insert_booking_product(string $travel_date, string $note, int $private_type, int $language_id, int $booking_type_id, int $booking_id, int $product_id)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO  booking_products (travel_date, note, private_type, language_id, booking_type_id, booking_id, product_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $travel_date);

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, $private_type);

        $bind_types .= "i";
        array_push($params, $language_id);

        $bind_types .= "i";
        array_push($params, $booking_type_id);

        $bind_types .= "i";
        array_push($params, $booking_id);

        $bind_types .= "i";
        array_push($params, $product_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_booking_product(int $id, string $travel_date, string $note, int $language_id, int $product_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_products SET";

        $query .= " travel_date = ?,";
        $bind_types .= "s";
        array_push($params, $travel_date);

        $query .= " note = ?,";
        $bind_types .= "s";
        array_push($params, $note);

        $query .= " language_id = ?,";
        $bind_types .= "i";
        array_push($params, $language_id);

        $query .= " product_id = ?,";
        $bind_types .= "i";
        array_push($params, $product_id);

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

    public function insert_booking_rate(int $adult, int $child, int $infant, int $foc, string $rate_adult, string $rate_child, string $rate_infant, string $rate_private, string $rate_total, int $category_id, int $booking_products_id, int $product_rates_id)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO `booking_product_rates`(`adult`, `child`, `infant`, `foc`, `rate_adult`, `rate_child`, `rate_infant`, `rate_private`, `rate_total`, `category_id`, `booking_products_id`, `product_rates_id`, `created_at`, `updated_at`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $bind_types .= "i";
        array_push($params, $adult);

        $bind_types .= "i";
        array_push($params, $child);

        $bind_types .= "i";
        array_push($params, $infant);

        $bind_types .= "i";
        array_push($params, $foc);

        $bind_types .= "d";
        array_push($params, $rate_adult);

        $bind_types .= "d";
        array_push($params, $rate_child);

        $bind_types .= "d";
        array_push($params, $rate_infant);

        $bind_types .= "d";
        array_push($params, $rate_private);

        $bind_types .= "d";
        array_push($params, $rate_total);

        $bind_types .= "i";
        array_push($params, $category_id);

        $bind_types .= "i";
        array_push($params, $booking_products_id);

        $bind_types .= "i";
        array_push($params, $product_rates_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function update_booking_rate(int $id, int $adult, int $child, int $infant, int $foc, string $rate_adult, string $rate_child, string $rate_infant, string $rate_private, string $rate_total, int $pror_id, int $category_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_product_rates SET";

        $query .= " adult = ?,";
        $bind_types .= "i";
        array_push($params, $adult);

        $query .= " child = ?,";
        $bind_types .= "i";
        array_push($params, $child);

        $query .= " infant = ?,";
        $bind_types .= "i";
        array_push($params, $infant);

        $query .= " foc = ?,";
        $bind_types .= "i";
        array_push($params, $foc);

        $query .= " rate_adult = ?,";
        $bind_types .= "d";
        array_push($params, $rate_adult);

        $query .= " rate_child = ?,";
        $bind_types .= "d";
        array_push($params, $rate_child);

        $query .= " rate_infant = ?,";
        $bind_types .= "d";
        array_push($params, $rate_infant);

        $query .= " rate_private = ?,";
        $bind_types .= "d";
        array_push($params, $rate_private);

        $query .= " rate_total = ?,";
        $bind_types .= "d";
        array_push($params, $rate_total);

        $query .= " product_rates_id = ?,";
        $bind_types .= "i";
        array_push($params, $pror_id);

        $query .= " category_id = ?,";
        $bind_types .= "i";
        array_push($params, $category_id);

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

    public function insert_booking_transfer(int $adult, int $child, int $infant, int $foc, string $start_pickup, string $end_pickup, string $hotel_pickup, string $hotel_dropoff, string $room_no, string $note, int $pickup_id, int $dropoff_id, int $hotel_pickup_id, int $hotel_dropoff_id, int $transfer_type, int $pickup_type, int $booking_products_id, int $category_id)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_transfer (adult, child, infant, foc, start_pickup, end_pickup, hotel_pickup, hotel_dropoff, room_no, note, pickup_id, dropoff_id, hotel_pickup_id, hotel_dropoff_id, transfer_type, pickup_type, booking_products_id, category_id, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $bind_types .= "i";
        array_push($params, $adult);

        $bind_types .= "i";
        array_push($params, $child);

        $bind_types .= "i";
        array_push($params, $infant);

        $bind_types .= "i";
        array_push($params, $foc);

        $bind_types .= "s";
        array_push($params, $start_pickup);

        $bind_types .= "s";
        array_push($params, $end_pickup);

        $bind_types .= "s";
        array_push($params, $hotel_pickup);

        $bind_types .= "s";
        array_push($params, $hotel_dropoff);

        $bind_types .= "s";
        array_push($params, $room_no);

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, $pickup_id);

        $bind_types .= "i";
        array_push($params, $dropoff_id);

        $bind_types .= "i";
        array_push($params, $hotel_pickup_id);

        $bind_types .= "i";
        array_push($params, $hotel_dropoff_id);

        $bind_types .= "i";
        array_push($params, $transfer_type);

        $bind_types .= "i";
        array_push($params, $pickup_type);

        $bind_types .= "i";
        array_push($params, $booking_products_id);

        $bind_types .= "i";
        array_push($params, $category_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_booking_transfer(int $id, int $adult, int $child, int $infant, int $foc, string $start_pickup, string $end_pickup, string $hotel_pickup_outside, string $hotel_dropoff_outside, string $room_no, string $note, int $pickup, int $dropoff, int $hotel_pickup, int $hotel_dropoff, int $transfer_type, int $pickup_type, int $category_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_transfer SET";

        $query .= " adult = ?,";
        $bind_types .= "i";
        array_push($params, $adult);

        $query .= " child = ?,";
        $bind_types .= "i";
        array_push($params, $child);

        $query .= " infant = ?,";
        $bind_types .= "i";
        array_push($params, $infant);

        $query .= " foc = ?,";
        $bind_types .= "i";
        array_push($params, $foc);

        $query .= " start_pickup = ?,";
        $bind_types .= "s";
        array_push($params, $start_pickup);

        $query .= " end_pickup = ?,";
        $bind_types .= "s";
        array_push($params, $end_pickup);

        $query .= " hotel_pickup = ?,";
        $bind_types .= "s";
        array_push($params, $hotel_pickup_outside);

        $query .= " hotel_dropoff = ?,";
        $bind_types .= "s";
        array_push($params, $hotel_dropoff_outside);

        $query .= " room_no = ?,";
        $bind_types .= "s";
        array_push($params, $room_no);

        $query .= " note = ?,";
        $bind_types .= "s";
        array_push($params, $note);

        $query .= " pickup_id = ?,";
        $bind_types .= "i";
        array_push($params, $pickup);

        $query .= " dropoff_id = ?,";
        $bind_types .= "i";
        array_push($params, $dropoff);

        $query .= " hotel_pickup_id = ?,";
        $bind_types .= "i";
        array_push($params, $hotel_pickup);

        $query .= " hotel_dropoff_id = ?,";
        $bind_types .= "i";
        array_push($params, $hotel_dropoff);

        $query .= " transfer_type = ?,";
        $bind_types .= "i";
        array_push($params, $transfer_type);

        $query .= " pickup_type = ?,";
        $bind_types .= "i";
        array_push($params, $pickup_type);

        $query .= " category_id = ?,";
        $bind_types .= "i";
        array_push($params, $category_id);

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

    public function insert_transfer_rate(string $rate_adult, string $rate_child, string $rate_infant, string $rate_private, int $booking_transfer_id, int $cars_category_id)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_transfer_rates (`rate_adult`, `rate_child`, `rate_infant`, `rate_private`, `booking_transfer_id`, `cars_category_id`, `created_at`, `updated_at`)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $bind_types .= "d";
        array_push($params, $rate_adult);

        $bind_types .= "d";
        array_push($params, $rate_child);

        $bind_types .= "d";
        array_push($params, $rate_infant);

        $bind_types .= "d";
        array_push($params, $rate_private);

        $bind_types .= "i";
        array_push($params, $booking_transfer_id);

        $bind_types .= "i";
        array_push($params, $cars_category_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function update_transfer_rate(int $id, int $rate_adult, int $rate_child, int $rate_infant, string $rate_private, int $cars_category)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_transfer_rates SET";

        $query .= " rate_adult = ?,";
        $bind_types .= "i";
        array_push($params, $rate_adult);

        $query .= " rate_child = ?,";
        $bind_types .= "i";
        array_push($params, $rate_child);

        $query .= " rate_infant = ?,";
        $bind_types .= "i";
        array_push($params, $rate_infant);

        $query .= " rate_private = ?,";
        $bind_types .= "d";
        array_push($params, $rate_private);

        $query .= " cars_category_id = ?,";
        $bind_types .= "i";
        array_push($params, $cars_category);

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

    public function delete_transfer_rate(int $id)
    {
        $query = "DELETE FROM booking_transfer_rates 
                WHERE id = ?
                ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function insert_booking_no(int $booking_id, string $bo_date, int $bo_year, int $bo_year_th, int $bo_month, int $bo_no, string $bo_full)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO bookings_no (bo_date, bo_year, bo_year_th, bo_month, bo_no, bo_full, booking_id, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $bind_types .= "s";
        array_push($params, $bo_date);

        $bind_types .= "i";
        array_push($params, $bo_year);

        $bind_types .= "i";
        array_push($params, $bo_year_th);

        $bind_types .= "i";
        array_push($params, $bo_month);

        $bind_types .= "i";
        array_push($params, $bo_no);

        $bind_types .= "s";
        array_push($params, $bo_full);

        $bind_types .= "i";
        array_push($params, $booking_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function insert_booking_extra(int $bo_id, int $extra, string $extra_name, int $extra_type, int $extra_adult, string $extra_rate_adult, int $extra_child, string $extra_rate_child, int $extra_infant, string $extra_rate_infant, int $extra_num_private, string $extra_rate_private)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_extra_charge (name, adult, child, infant, privates, rate_adult, rate_child, rate_infant, rate_private, booking_id, extra_charge_id, type, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $extra_name);

        $bind_types .= "i";
        array_push($params, $extra_adult);

        $bind_types .= "i";
        array_push($params, $extra_child);

        $bind_types .= "i";
        array_push($params, $extra_infant);

        $bind_types .= "i";
        array_push($params, $extra_num_private);

        $bind_types .= "d";
        array_push($params, $extra_rate_adult);

        $bind_types .= "d";
        array_push($params, $extra_rate_child);

        $bind_types .= "d";
        array_push($params, $extra_rate_infant);

        $bind_types .= "d";
        array_push($params, $extra_rate_private);

        $bind_types .= "i";
        array_push($params, $bo_id);

        $bind_types .= "i";
        array_push($params, $extra);

        $bind_types .= "i";
        array_push($params, $extra_type);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function update_booking_extra(int $id, int $extra, string $extra_name, int $extra_type, int $extra_adult, string $extra_rate_adult, int $extra_child, string $extra_rate_child, int $extra_infant, string $extra_rate_infant, int $extra_num_private, string $extra_rate_private)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_extra_charge SET";

        $query .= " extra_charge_id = ?,";
        $bind_types .= "i";
        array_push($params, $extra);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $extra_name);

        $query .= " adult = ?,";
        $bind_types .= "i";
        array_push($params, $extra_adult);

        $query .= " child = ?,";
        $bind_types .= "i";
        array_push($params, $extra_child);

        $query .= " infant = ?,";
        $bind_types .= "i";
        array_push($params, $extra_infant);

        $query .= " privates = ?,";
        $bind_types .= "i";
        array_push($params, $extra_num_private);

        $query .= " rate_adult = ?,";
        $bind_types .= "d";
        array_push($params, $extra_rate_adult);

        $query .= " rate_child = ?,";
        $bind_types .= "d";
        array_push($params, $extra_rate_child);

        $query .= " rate_infant = ?,";
        $bind_types .= "d";
        array_push($params, $extra_rate_infant);

        $query .= " rate_private = ?,";
        $bind_types .= "d";
        array_push($params, $extra_rate_private);

        $query .= " type = ?,";
        $bind_types .= "i";
        array_push($params, $extra_type);

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

    public function create_booking_no(string $today)
    {
        function setNumberLength($num, $length)
        {
            $sumstr = strlen($num);
            $zero = str_repeat("0", $length - $sumstr);
            $results = $zero . $num;

            return $results;
        }

        // #--- GET VALUE ---#
        $booing_arr = array();
        $bo_title = "BO";
        $today_str = explode("-", $today);
        $bo_year = $today_str[0];
        $bo_year_th_full = $today_str[0] + 543;
        $bo_year_th = substr($bo_year_th_full, -2);
        $bo_month = $today_str[1];
        $bo_no = 0;

        #--- CHECK TB : booking ---#
        $query = "SELECT *
            FROM bookings_no 
            WHERE id > 0
        ";
        $query .= " ORDER BY bo_date DESC, bo_no DESC LIMIT 0,1";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $data_bo = $result->fetch_assoc();
            $bo_month_sql = setNumberLength($data_bo["bo_month"], 2);
            if ($bo_month_sql == $bo_month) {
                if ($data_bo["bo_year"] != $bo_year) {
                    $bo_no = 1;
                } else {
                    $bo_no = $data_bo["bo_no"] + 1;
                }
            } else {
                $bo_no = 1;
            }
        } else {
            $bo_no = 1;
        }

        $bo_full = $bo_title . $bo_year_th . $bo_month . setNumberLength($bo_no, 4);

        $booing_arr['bo_title'] = $bo_title;
        $booing_arr['bo_date'] = $today;
        $booing_arr['bo_year'] = $bo_year;
        $booing_arr['bo_year_th'] = $bo_year_th;
        $booing_arr['bo_month'] = $bo_month;
        $booing_arr['bo_no'] = $bo_no;
        $booing_arr['bo_full'] = $bo_full;

        return $booing_arr;
    }

    public function delete_booking_rate(int $id)
    {
        $query = "DELETE FROM booking_product_rates WHERE id = ? ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function insert_log(string $name, string $detail, int $booking_id, int $type_id, string $created_at)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO `log_booking`(`name`, `detail`, `booking_id`, `user_id`, `type_id`, `created_at`)
        VALUES (?, ?, ?, ?, ?, ?)";

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $detail);

        $bind_types .= "i";
        array_push($params, $booking_id);

        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $bind_types .= "i";
        array_push($params, $type_id);

        $bind_types .= "s";
        array_push($params, $created_at);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function delete_booking_extra(int $booking_extra_id)
    {
        $query = "DELETE FROM booking_extra_charge WHERE id = ? ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $booking_extra_id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function insert_hotel(string $name, int $zone_id)
    {
        $query = "SELECT id, name FROM hotel WHERE name = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("s", $name);
        $statement->execute();
        $result = $statement->get_result();
        $data = ($result->num_rows > 0) ? $result->fetch_assoc() : 0;

        if ($data == 0) {
            $bind_types = "";
            $params = array();

            $query = "INSERT INTO hotel (name, name_th, address, telephone, email, zone_id, is_approved, is_deleted, created_at, updated_at)
            VALUES (?, ?, '', '', '', ?, 1, 0, NOW(), NOW())";

            $bind_types .= "s";
            array_push($params, $name);

            $bind_types .= "s";
            array_push($params, $name);

            $bind_types .= "i";
            array_push($params, $zone_id);

            $statement = $this->connection->prepare($query);
            !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

            if ($statement->execute()) {
                $this->response = $this->connection->insert_id;
            }

            $data = $this->response;
        }

        return !empty($data['id']) ? $data['id'] : $data;
    }

    function insert_agent(string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO `companies`(`name`, `company_type_id`, `is_approved`, `is_deleted`, `created_at`, `updated_at`)
            VALUES (?, 2, 1, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $name);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function delete_data_prod(int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_products SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, 0);

        $query .= " is_deleted = ?,";
        $bind_types .= "i";
        array_push($params, 1);

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

    public function delete_data_cus(int $id)
    {
        $query = "DELETE FROM customers WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_data_trans(int $bt_id)
    {
        $query = "DELETE FROM booking_transfer_rates WHERE booking_transfer_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $bt_id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        if ($this->response == true) {
            $query = "DELETE FROM booking_transfer WHERE id = ?";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("i", $bt_id);
            $statement->execute();
            if ($statement->execute()) {
                $this->response = true;
            }

            return $this->response;
        }
    }

    public function delete_data_extra(int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_extra_charge SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, 0);

        $query .= " is_deleted = ?,";
        $bind_types .= "i";
        array_push($params, 1);

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

    public function delete_booking_paid(int $id)
    {
        $query = "DELETE FROM booking_paid WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_booking_paid_detail(int $id)
    {
        $query = "DELETE FROM booking_paid_detail WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_booking_manage_transfer(int $mange_id, int $bt_id, int $id)
    {
        $query = "DELETE FROM booking_order_transfer WHERE order_id = ? AND booking_transfer_id = ? AND id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("iii", $mange_id, $bt_id, $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_booking_manage_boat(int $mange_id, int $bo_id, int $id)
    {
        $query = "DELETE FROM booking_order_boat WHERE manage_id = ? AND booking_id = ? AND id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("iii", $mange_id, $bo_id, $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_confirm(int $id)
    {
        $query = "DELETE FROM `confirm_agent` WHERE `id` = ? ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function checkinvno()
    {
        $query = "SELECT *,
            MAX(inv_no) as max_inv_no
            FROM invoice_cover 
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_assoc();

        return $data;
    }

    public function insert_cover_inv(string $inv_date, int $inv_no, string $inv_full)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO invoice_cover (inv_date, inv_no, inv_full, created_at)
        VALUES (?, ?, ?, NOW())";

        $bind_types .= "s";
        array_push($params, $inv_date);

        $bind_types .= "i";
        array_push($params, $inv_no);

        $bind_types .= "s";
        array_push($params, $inv_full);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function insert_data_invoice(int $no, string $rec_date, int $withholding, string $note, int $branche_id, int $booking_id, int $payment_id, int $vat_id, int $currency_id, int $cover_id, int $bank_account_id, int $is_approved)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO  invoices (no, rec_date, withholding, note, branche_id, booking_id, payment_id, vat_id, currency_id, cover_id, bank_account_id, user_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "i";
        array_push($params, $no);

        $bind_types .= "s";
        array_push($params, $rec_date);

        $bind_types .= "i";
        array_push($params, $withholding);

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, $branche_id);

        $bind_types .= "i";
        array_push($params, $booking_id);

        $bind_types .= "i";
        array_push($params, $payment_id);

        $bind_types .= "i";
        array_push($params, $vat_id);

        $bind_types .= "i";
        array_push($params, $currency_id);

        $bind_types .= "i";
        array_push($params, $cover_id);

        $bind_types .= "i";
        array_push($params, $bank_account_id);

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

    public function insert_paid(int $bo_id, int $book_payment)
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
            $uploadFileDir = !empty($fileArray['fileDir'][$i]) ? $fileArray['fileDir'][$i] : '../../../storage/uploads/companies/logo/';

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
