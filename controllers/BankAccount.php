<?php
require_once __DIR__ . '/DB.php';

class BankAccount extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT BA.*,
            BNK.id as bnkID, BNK.name as bnkName 
            FROM bank_account BA
            LEFT JOIN banks BNK
                ON BA.bank_id = BNK.id
            WHERE BA.id > 0 AND BA.is_deleted = 0
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showbank()
    {
        $query = "SELECT * FROM banks
            WHERE id > 0 
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function get_data(int $id)
    {
        $query = "SELECT *
            FROM bank_account
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

    public function insert_data(int $is_approved, int $bank_id, string $name, string $no)
    {
        $name_trim = trim($name);
        $slug = str_replace(' ', '-', $name_trim);

        $query = "INSERT INTO bank_account (account_name, account_no, bank_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, 0, NOW(), NOW())";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("ssii", $name, $no, $bank_id, $is_approved);

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, int $id, int $bank_id, string $name, string $no)
    {
        $name_trim = trim($name);
        $slug = str_replace(' ', '-', $name_trim);

        $bind_types = "";
        $params = array();

        $query = "UPDATE bank_account SET";

        $query .= " account_name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " account_no = ?,";
        $bind_types .= "s";
        array_push($params, $no);

        $query .= " bank_id = ?,";
        $bind_types .= "i";
        array_push($params, $bank_id);

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
            // set new fullname
            // $_SESSION["supplier"]["fullname"] = $_SESSION["supplier"]["id"] == $id ? $firstname . " " . $lastname : $_SESSION["supplier"]["fullname"];

            $this->response = true;
        }

        return $this->response;
    }

    public function delete_data(int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE bank_account SET";

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

    public function check_name(int $car_category_id = 0, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM bank_account 
            WHERE 
        ";

        $query .= " name = ?";
        $bind_types .= "s";
        array_push($params, $name);

        if ($car_category_id != 0) {
            $query .= " AND id != ?";
            $bind_types .= "i";
            array_push($params, $car_category_id);
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

    public function search($is_approved, string $name, string $no, string $bank)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT BA.*,
            BNK.id as bnkID, BNK.name as bnkName 
            FROM bank_account BA
            LEFT JOIN banks BNK
                ON BA.bank_id = BNK.id
            WHERE BA.id > 0 
        ";

        if (!empty($name)) {
            $query .= " AND BA.account_name LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $name . '%');
        }

        if (!empty($no)) {
            $query .= " AND BA.account_no LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $no . '%');
        }

        if (isset($bank) && $bank != "all") {
            $query .= " AND BA.bank_id = ?";
            $bind_types .= "i";
            array_push($params, $bank);
        }

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND BA.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }
}
