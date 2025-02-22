<?php
require_once __DIR__ . '/DB.php';

class Land extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist(int $id, int $department_id)
    {
        $query = "SELECT BO.*,
                    BP.id as bpID, BP.travel_date as bpTravelDate, BP.adult as bpAdult, BP.child as bpChild, BP.infant as bpInfant, 
                    BONO.id as bonoID, BONO.bo_full as bonoFull,
                    BTY.id as btyID, BTY.name as btyName, 
                    COMP.id as compID, COMP.name as compName, 
                    BOSTA.id as bostaID, BOSTA.name as bostaName, BOSTA.name_class as bostaNameClass, 
                    PRO.id as proID, PRO.name as proName,
                    CATE.id as cateID, CATE.name as cateName, CATE.transfer as cateTrans,
                    BPR.id as bprID, BPR.rate_adult as bprRateAdult, BPR.rate_child as bprRateChild, BPR.rate_infant as bprRateInfant, 
                    BPR.rate_group as bprRateGroup, BPR.pax_group as bprPaxGroup, BPR.rate_total as bprRateTotal,
                    BT.id as btID, BT.adult as btAdult, BT.child as btChild, BT.infant as btInfant, BT.hotel_name as btHotelName,
                    BT.room_no as btRoomNo, BT.note as btNote, BT.private_type as btPrivateType, BT.pickup_id as btPickupID, 
                    BTR.id as btrID, BTR.rate_adult as btrRateAdult, BTR.rate_child as btrRateChild, BTR.rate_infant as btrRateInfant, 
                    BTR.rate_private as btrRatePrivate, BTR.qty_private as btrQtyPrivate,
                    PLA.id as plaID, PLA.name as plaName,
                    CAR.id as carID, CAR.name as carName,
                    CUS.id as cusID,
                    BOOKER.id as bookerID, BOOKER.firstname as bookerFname, BOOKER.lastname as bookerLname,
                    BOPAY.id as bopayID, BOPAY.name as bopayName, BOPAY.name_class as bopayNameClass, BOPAY.button_class as bopayBtnClass,
                    DRIV.id as drivID, DRIV.first_name as drivFname, DRIV.last_name as drivLname, DRIV.nickname as drivNick,
                    BOPAID.id as bopaidID, BOPAID.date_paid as bopaidDate, BOPAID.time_paid as bopaidTime, BOPAID.total_paid as bopaidTotal,
                    BOPAID.photo as bopaidPhoto, BOPAID.note as bopaidNote, BOPAID.payment_type_id as bopaidPayment, BOPAID.bank_account_id as bopaidBank, 
                    BOPAID.user_id as bopaidUser
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
                LEFT JOIN users BOOKER
                    ON BO.booker_id = BOOKER.id
                LEFT JOIN booking_payment BOPAY
                    ON BO.payment_id = BOPAY.id
                LEFT JOIN drivers DRIV
                    ON BTR.driver_id = DRIV.id
                LEFT JOIN booking_paid BOPAID
                    ON BO.id = BOPAID.booking_id
                WHERE BO.id > 0
                AND BO.payment_id = 4 
        ";
        $query .= $id != '' && $department_id == 1 ? " AND BO.booker_id = " . $id : "";
        $query .= " ORDER BY BO.id DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showlistpayment()
    {
        $query = "SELECT *
            FROM booking_payment 
            WHERE id > 0
        ";
        $query .= " ORDER BY id ASC";
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

    public function showbookingextra(int $booking_id)
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

    public function showproducts(int $agent_id, string $travel_date)
    {
        $query = "SELECT COMR.*,
                    PROP.id as propID,
                    PROCA.id as procaID, PROCA.name as procaName,
                    PROD.id as prodID, PROD.name as prodName,
                    PRODR.id as prodrID, PRODR.rate_adult as prodrRateAdult, PRODR.rate_child as prodrRateChild, PRODR.rate_infant as prodrRateInfant
                    FROM company_rate COMR
                    LEFT JOIN product_periods PROP
                        ON COMR.product_period_id = PROP.id
                    LEFT JOIN product_category PROCA
                        ON PROP.product_category_id = PROCA.id
                    LEFT JOIN products PROD
                        ON PROCA.product_id = PROD.id
                    LEFT JOIN product_rates PRODR
                        ON COMR.product_rate_id = PRODR.id
                    WHERE PROP.is_approved = 1
                    AND PROP.is_deleted = 0
                    AND PROD.is_approved = 1
                    AND PROD.is_deleted = 0
                    AND PROCA.is_approved = 1
                    AND PROCA.is_deleted = 0
                    AND PRODR.is_approved = 1
                    AND PRODR.is_deleted = 0
                    AND COMR.company_id = ?
                    AND PROP.period_from <= ? 
                    AND PROP.period_to >= ?
                ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("iss", $agent_id, $travel_date, $travel_date);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_payments_type(int $type)
    {
        $query = "SELECT id, name, type
            FROM payments_type 
            WHERE id > 0
        ";
        $query .= $type > 0 ? " AND type = " . $type : "";
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

    public function get_data(string $select, string $from, string $where)
    {
        $query = "SELECT $select
            FROM $from 
            WHERE $where
        ";
        $statement = $this->connection->prepare($query);
        // $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            $data = false;
        }

        return $data;
    }

    public function get_booking_paid(int $bo_id)
    {
        # code...
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

    public function insert_data(int $booking_status_id, int $booking_type_id, int $payment_type_id, string $booking_date, string $booking_time, int $company_id, string $payment_paid)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO bookings (booking_date, booking_time, discount_type, discount, payment_paid, user_pay, booker_id, status_by, company_id, booking_status_id, booking_type_id, payment_id, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $booking_date);

        $bind_types .= "s";
        array_push($params, $booking_time);

        $bind_types .= "i";
        array_push($params, 1);

        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "d";
        array_push($params, $payment_paid);

        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $bind_types .= "i";
        array_push($params, $company_id);

        $bind_types .= "i";
        array_push($params, $booking_status_id);

        $bind_types .= "i";
        array_push($params, $booking_type_id);

        $bind_types .= "i";
        array_push($params, $payment_type_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
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

    public function insert_customer(int $booking_id, array $itinerary)
    {
        for ($i = 0; $i < count($itinerary); $i++) {
            if (!empty($itinerary[$i]['firstname']) && !empty($itinerary[$i]['lastname'])) {
                $bind_types = "";
                $params = array();

                $query = "INSERT INTO customers (firstname, lastname, birth_date, id_card, telephone, address, facebook, line, email, head, booking_id, blood_id, nationality_id, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

                $bind_types .= "s";
                array_push($params, $itinerary[$i]['firstname']);

                $bind_types .= "s";
                array_push($params, $itinerary[$i]['lastname']);

                $bind_types .= "s";
                array_push($params, '0000-00-00');

                $bind_types .= "s";
                array_push($params, $itinerary[$i]['id_card']);

                $bind_types .= "s";
                array_push($params, $itinerary[$i]['telephone']);

                $bind_types .= "s";
                array_push($params, '');

                $bind_types .= "s";
                array_push($params, '');

                $bind_types .= "s";
                array_push($params, '');

                $bind_types .= "s";
                array_push($params, $itinerary[$i]['email']);

                if ($i == 0) {
                    $bind_types .= "i";
                    array_push($params, 1);
                } else {
                    $bind_types .= "i";
                    array_push($params, 0);
                }

                $bind_types .= "i";
                array_push($params, $booking_id);

                $bind_types .= "i";
                array_push($params, 0);

                $bind_types .= "i";
                array_push($params, 0);

                $statement = $this->connection->prepare($query);
                !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

                if ($statement->execute()) {
                    $this->response = true;
                } else {
                    $this->response = false;
                }
            }
        }

        return $this->response;
    }

    public function insert_booking_product(int $booking_id, int $product_id, int $category_id, string $travel_date, int $adult, int $child, int $infant, string $note)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_products (travel_date, adult, child, infant, foc, note, private_type, booking_type_id, booking_id, product_id, category_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $travel_date);

        $bind_types .= "i";
        array_push($params, $adult);

        $bind_types .= "i";
        array_push($params, $child);

        $bind_types .= "i";
        array_push($params, $infant);

        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "i";
        array_push($params, $booking_id);

        $bind_types .= "i";
        array_push($params, $product_id);

        $bind_types .= "i";
        array_push($params, $category_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function insert_booking_rate(int $bp_id, int $prodr_id, string $rate_adult, string $rate_child, string $rate_infant, string $rate_total)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_product_rates (rate_adult, rate_child, rate_infant, rate_group, pax_group, rate_total, booking_products_id, product_rates_id, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $bind_types .= "d";
        array_push($params, $rate_adult);

        $bind_types .= "d";
        array_push($params, $rate_child);

        $bind_types .= "d";
        array_push($params, $rate_infant);

        $bind_types .= "s";
        array_push($params, 0);

        $bind_types .= "i";
        array_push($params, 0);

        $bind_types .= "d";
        array_push($params, $rate_total);

        $bind_types .= "i";
        array_push($params, $bp_id);

        $bind_types .= "i";
        array_push($params, $prodr_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function insert_booking_paid(int $bo_id, string $paid_date, string $paid_time, int $payments_type, int $bank_account, string $total_pay, string $note, array $fileArray)
    {
        // upload photo file
        $photoResponse = $this->uploadFile($fileArray);
        $countphoto = count($photoResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO booking_paid (date_paid, time_paid, total_paid, photo, note, payment_type_id, bank_account_id, booking_id, user_id, is_deleted, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, now())";

        $bind_types .= "s";
        array_push($params, $paid_date);

        $bind_types .= "s";
        array_push($params, $paid_time);

        $bind_types .= "d";
        array_push($params, $total_pay);

        for ($i = 0; $i < $countphoto; $i++) {
            $bind_types .= "s";
            array_push($params, $photoResponse['filename'][$i]);
        }

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, $payments_type);

        $bind_types .= "i";
        array_push($params, $bank_account);

        $bind_types .= "i";
        array_push($params, $bo_id);

        $bind_types .= "i";
        array_push($params, $_SESSION["supplier"]["id"]);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
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
            $uploadFileDir = !empty($fileArray['uploadFileDir'][$i]) ? $fileArray['uploadFileDir'][$i] : '../../../storage/uploads/booking/paid/';

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
