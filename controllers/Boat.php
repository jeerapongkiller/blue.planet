<?php
require_once __DIR__ . '/DB.php';

class Boat extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT boats.*, boats_type.id as typeId, boats_type.name as typeName
            FROM boats 
            LEFT JOIN boats_type
                ON boats.boat_type_id = boats_type.id
            WHERE boats.is_deleted = 0 
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showtype()
    {
        $query = "SELECT *
            FROM boats_type 
            WHERE id > 0 
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function get_data(int $id)
    {
        $query = "SELECT boats.*, boats_type.id as typeId, boats_type.name as typeName
        FROM boats 
        LEFT JOIN boats_type
            ON boats.boat_type_id = boats_type.id
            WHERE boats.id = ?
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

    public function insert_data(int $is_approved, int $boat_type_id, string $name, string $refcode, int $capacity)
    {
        $refcode_trim = trim($refcode);
        $slug = str_replace(' ', '-', $refcode_trim);

        $query = "INSERT INTO boats (refcode, name, slug, capacity, boat_type_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("sssiii", $refcode_trim, $name, $slug, $capacity, $boat_type_id, $is_approved);

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, int $boat_type_id, string $name, string $refcode, int $capacity, int $id)
    {
        $refcode_trim = trim($refcode);
        $slug = str_replace(' ', '-', $refcode_trim);

        $bind_types = "";
        $params = array();

        $query = "UPDATE boats SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);

        $query .= " refcode = ?,";
        $bind_types .= "s";
        array_push($params, $refcode);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " slug = ?,";
        $bind_types .= "s";
        array_push($params, $slug);

        $query .= " boat_type_id = ?,";
        $bind_types .= "i";
        array_push($params, $boat_type_id);

        $query .= " capacity = ?,";
        $bind_types .= "i";
        array_push($params, $capacity);

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

        $query = "UPDATE boats SET";

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

    public function check_name(int $boat_id = 0, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM boats 
            WHERE 
        ";

        $query .= " name = ?";
        $bind_types .= "s";
        array_push($params, $name);

        if ($boat_id != 0) {
            $query .= " AND id != ?";
            $bind_types .= "i";
            array_push($params, $boat_id);
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

    public function check_refcode(int $id, string $refcode)
    {
        $query = "SELECT *
            FROM boats 
            WHERE refcode = ?
            AND id != $id
        ";

        // $query .= $id != 0 ? ' AND id != ' . $id : '';
        $statement = $this->connection->prepare($query);
        $statement->bind_param("s", $refcode);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows == 0) {
            $data = 'true';
        } else {
            $data = 'false';
        }

        return $data;
    }

    public function search($is_approved, $type, string $refcode, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT boats.*, boats_type.id as typeId, boats_type.name as typeName
            FROM boats 
            LEFT JOIN boats_type
                ON boats.boat_type_id = boats_type.id
            WHERE boats.is_deleted = 0 
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND boats.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (isset($type) && $type != "all") {
            $query .= " AND boats.boat_type_id = ?";
            $bind_types .= "i";
            array_push($params, $type);
        }

        if (!empty($refcode)) {
            $query .= " AND boats.refcode LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $refcode . '%');
        }

        if (!empty($name)) {
            $query .= " AND boats.name LIKE ?";
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
}
