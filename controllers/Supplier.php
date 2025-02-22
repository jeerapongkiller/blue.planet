<?php
require_once __DIR__ . '/DB.php';

class Supplier extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT companies.*, companies_type.id as comptypeId, companies_type.name as comptypeName
            FROM companies 
            LEFT JOIN companies_type
                ON companies.company_type_id = companies_type.id
            WHERE companies.is_deleted = 0 AND companies.company_type_id = 1
        ";
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

    public function get_data(int $id)
    {
        $query = "SELECT companies.*, companies_type.id as comptypeId, companies_type.name as comptypeName
            FROM companies 
            LEFT JOIN companies_type
                ON companies.company_type_id = companies_type.id
            WHERE companies.is_deleted = 0 AND companies.company_type_id = 1 AND companies.id = ?
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

    public function insert_data(int $is_approved, string $tat_license, string $name, string $email, string $telephone, string $address, string $contact_person, string $note, array $logoFile)
    {
        // upload logo file
        $logoResponse = $this->uploadFile($logoFile);
        $countlogo = count($logoResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO companies (tat_license, name, email, telephone, address, contact_person, note, logo, company_type_id, credit, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, 0, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $tat_license);

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $email);

        $bind_types .= "s";
        array_push($params, $telephone);

        $bind_types .= "s";
        array_push($params, $address);

        $bind_types .= "s";
        array_push($params, $contact_person);

        $bind_types .= "s";
        array_push($params, $note);

        for ($i = 0; $i < $countlogo; $i++) {
            $bind_types .= "s";
            array_push($params, $logoResponse['filename'][$i]);
        }

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $tat_license, string $name, string $email, string $telephone, string $address, string $contact_person, string $note, array $logoFile, int $id)
    {
        // upload logo file
        $logoResponse = $this->uploadFile($logoFile);
        $countlogo = count($logoResponse);

        $bind_types = "";
        $params = array();

        $query = "UPDATE companies SET";

        $query .= " tat_license = ?,";
        $bind_types .= "s";
        array_push($params, $tat_license);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " email = ?,";
        $bind_types .= "s";
        array_push($params, $email);

        $query .= " telephone = ?,";
        $bind_types .= "s";
        array_push($params, $telephone);

        $query .= " address = ?,";
        $bind_types .= "s";
        array_push($params, $address);

        $query .= " contact_person = ?,";
        $bind_types .= "s";
        array_push($params, $contact_person);

        $query .= " note = ?,";
        $bind_types .= "s";
        array_push($params, $note);

        for ($i = 0; $i < $countlogo; $i++) {
            $query .= " logo = ?,";
            $bind_types .= "s";
            array_push($params, $logoResponse['filename'][$i]);
        }

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
        $bind_types = "";
        $params = array();

        $query = "UPDATE companies SET";

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

    public function check_tat_license(string $tat_license, int $company_id = 0)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM companies 
            WHERE 
        ";

        $query .= " tat_license = ?";
        $bind_types .= "s";
        array_push($params, $tat_license);

        if ($company_id != 0) {
            $query .= " AND id != ?";
            $bind_types .= "i";
            array_push($params, $company_id);
        }

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows == 0) {
            $data = 'true';
        } else {
            $data = 'false';
        }

        return $data;
    }

    public function search($is_approved, string $tat_license, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT companies.*, companies_type.id as comptypeId, companies_type.name as comptypeName
                FROM companies 
                LEFT JOIN companies_type
                    ON companies.company_type_id = companies_type.id
                WHERE companies.is_deleted = 0 AND companies.company_type_id = 1
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND companies.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($tat_license)) {
            $query .= " AND companies.tat_license LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $tat_license . '%');
        }

        if (!empty($name)) {
            $query .= " AND companies.name LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $name . '%');
        }

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function search_report(int $user_id, string $period, string $travel_form, string $travel_to)
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
                    CATE.id as cateID, CATE.name as cateName, CATE.transfer as cateTrans,
                    BPR.id as bprID, BPR.rate_adult as bprRateAdult, BPR.rate_child as bprRateChild, BPR.rate_infant as bprRateInfant, 
                    BPR.rate_group as bprRateGroup, BPR.pax_group as bprPaxGroup, BPR.rate_total as bprRateTotal,
                    BT.id as btID, BT.adult as btAdult, BT.child as btChild, BT.infant as btInfant, BT.hotel_name as btHotelName,
                    BT.room_no as btRoomNo, BT.note as btNote, BT.private_type as btPrivateType,
                    BTR.id as btrID, BTR.rate_adult as btrRateAdult, BTR.rate_child as btrRateChild, BTR.rate_infant as btrRateInfant, 
                    BTR.rate_private as btrRatePrivate, BTR.qty_private as btrQtyPrivate,
                    PLA.id as plaID, PLA.name as plaName,
                    CAR.id as carID, CAR.name as carName,
                    CUS.id as cusID,
                    USER.id as userID, USER.firstname as userFname, USER.lastname as userLname
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
                LEFT JOIN users USER
                    ON BO.booker_id = USER.id
                WHERE BO.id > 0
                AND BO.booker_id = $user_id
        ";

        if ($period != "all") {
            $query .= " AND BP.travel_date BETWEEN ? AND ? ";
            $bind_types .= "ss";
            array_push($params, $travel_to, $travel_form);
        }

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function uploadFile(array $fileArray)
    {
        $responseFilename = array();
        $uploadFileDir = '../../../storage/uploads/companies/logo/';
        $countfiles = count($fileArray);
        for ($i = 0; $i < $countfiles; $i++) {
            $fileTmpPath = !empty($fileArray['fileTmpPath'][$i]) ? $fileArray['fileTmpPath'][$i] : '';
            $fileName = !empty($fileArray['fileName'][$i]) ? $fileArray['fileName'][$i] : '';
            $fileSize = !empty($fileArray['fileSize'][$i]) ? $fileArray['fileSize'][$i] : '';
            $fileBefore = !empty($fileArray['fileBefore'][$i]) ? $fileArray['fileBefore'][$i] : '';
            $fileDelete = !empty($fileArray['fileDelete'][$i]) ? $fileArray['fileDelete'][$i] : '';

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
