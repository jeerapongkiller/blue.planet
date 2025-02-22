<?php
require_once __DIR__ . '/DB.php';

class Agent extends DB
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
            WHERE companies.is_deleted = 0 AND companies.company_type_id = 2
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showprograms()
    {
        $query = "SELECT *
            FROM products 
            WHERE is_deleted = 0
        ";
        $query .= "  ORDER BY name DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showcategory(int $product_id)
    {
        $query = "SELECT *
            FROM product_category 
            WHERE product_id = ?
            AND is_deleted = 0
            AND is_approved = 1
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $product_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showperiod(int $category_id)
    {
        $query = "SELECT *
            FROM product_periods 
            WHERE product_category_id = ?
            AND is_deleted = 0
            AND is_approved = 1
        ";
        $query .= " ORDER BY period_from ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $category_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showrates(int $period_id, int $com_id)
    {
        $query = "SELECT COMR.*,
            RATE.id as rate_id, RATE.rate_adult as rate_adult, RATE.rate_child as rate_child, RATE.rate_infant as rate_infant, RATE.rate_private as rate_private  
            FROM company_rate COMR
            LEFT JOIN product_rates RATE
                ON COMR.product_rate_id = RATE.id
            WHERE COMR.product_period_id = ? 
            AND COMR.company_id = ? 
            AND is_approved = 1
        ";
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("ii", $period_id, $com_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function get_data(int $id)
    {
        $query = "SELECT COM.*, 
            CTY.id as comptypeId, CTY.name as comptypeName
            FROM companies COM
            LEFT JOIN companies_type CTY
                ON COM.company_type_id = CTY.id
            WHERE COM.is_deleted = 0 AND COM.company_type_id = 2 AND COM.id = ?
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

    public function check_product_rate(int $period_id, int $company_id)
    {
        $query = "SELECT * 
            FROM company_rate 
            WHERE product_period_id = ? 
            AND company_id = ?
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("ii", $period_id, $company_id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows == 0) {
            $data = true;
        } else {
            $data = false;
        }

        return $data;
    }

    public function insert_data(int $is_approved, string $tat_license, string $name, string $email, string $telephone, string $address, string $contact_person, string $note, int $sale_id, array $logoFile)
    {
        // upload logo file
        $logoResponse = $this->uploadFile($logoFile);
        $countlogo = count($logoResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO companies (tat_license, name, email, telephone, address, contact_person, note, logo, company_type_id, sale_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 2, ?, ?, 0, NOW(), NOW())";

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
        array_push($params, $sale_id);

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $tat_license, string $name, string $email, string $telephone, string $address, string $contact_person, string $note, int $sale_id, array $logoFile, int $id)
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

        $query .= " sale_id = ?,";
        $bind_types .= "s";
        array_push($params, $sale_id);

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
                WHERE companies.is_deleted = 0 AND companies.company_type_id = 2
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

    public function insert_data_rate(string $rate_adult, string $rate_child, string $rate_infant, string $rate_private, int $period_id)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO product_rates (rate_adult, rate_child, rate_infant, rate_private, product_period_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, 1, 0, NOW(), NOW())";

        $bind_types .= "d";
        array_push($params, $rate_adult);

        $bind_types .= "d";
        array_push($params, $rate_child);

        $bind_types .= "d";
        array_push($params, $rate_infant);

        $bind_types .= "d";
        array_push($params, $rate_private);

        $bind_types .= "i";
        array_push($params, $period_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            return $this->connection->insert_id;
        }
    }

    public function update_data_rate(string $rate_adult, string $rate_child, string $rate_infant, string $rate_private, int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE product_rates SET";

        $query .= " rate_adult = ? ,";
        $bind_types .= "d";
        array_push($params, $rate_adult);

        $query .= " rate_child = ? ,";
        $bind_types .= "d";
        array_push($params, $rate_child);

        $query .= " rate_infant = ? ,";
        $bind_types .= "d";
        array_push($params, $rate_infant);

        $query .= " rate_private = ? ,";
        $bind_types .= "d";
        array_push($params, $rate_private);

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

    public function insert_data_company(int $product_period_id, int $product_rate_id, int $agent)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO company_rate (company_id, product_period_id, product_rate_id, created_at)
            VALUES (?, ?, ?, NOW())";

        $bind_types .= "i";
        array_push($params, $agent);

        $bind_types .= "i";
        array_push($params, $product_period_id);

        $bind_types .= "i";
        array_push($params, $product_rate_id);

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
            $uploadFileDir = !empty($fileArray['uploadFileDir'][$i]) ? $fileArray['uploadFileDir'][$i] : '../../../storage/uploads/companies/logo/';

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
