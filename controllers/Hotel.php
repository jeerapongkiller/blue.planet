<?php
require_once __DIR__ . '/DB.php';

class HOTEL extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT hotel.* , 
            zones.id as zone_id, zones.name as zone_name, zones.name_th as zone_nameth
            FROM hotel 
            LEFT JOIN zones
               ON hotel.zone_id = zones.id 
            WHERE hotel.is_deleted = 0
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showzone()
    {
        $query = "SELECT *
            FROM zones 
            WHERE is_deleted = 0
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
            FROM hotel 
            WHERE is_deleted = 0 
            AND id = ?
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

    public function insert_data(int $is_approved, string $name, string $name_th, string $telephone, string $email, int $zone, string $address)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO hotel (name, name_th, address, telephone, email, zone_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $name_th);

        $bind_types .= "s";
        array_push($params, $address);

        $bind_types .= "s";
        array_push($params, $telephone);

        $bind_types .= "s";
        array_push($params, $email);

        $bind_types .= "i";
        array_push($params, $zone);

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name, string $name_th, string $telephone, string $email, int $zone, string $address, int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE hotel SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " name_th = ?,";
        $bind_types .= "s";
        array_push($params, $name_th);

        $query .= " telephone = ?,";
        $bind_types .= "s";
        array_push($params, $telephone);

        $query .= " email = ?,";
        $bind_types .= "s";
        array_push($params, $email);

        $query .= " zone_id = ?,";
        $bind_types .= "i";
        array_push($params, $zone);

        $query .= " address = ?,";
        $bind_types .= "s";
        array_push($params, $address);

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

        $query = "UPDATE hotel SET";

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

    public function search($is_approved, $zone, string $name)
    {
        $bind_types = "";
        $params = array();
      
        $query = "SELECT hotel.* , 
                zones.id as zone_id, zones.name as zone_name, zones.name_th as zone_nameth
                FROM hotel 
                LEFT JOIN zones
                    ON hotel.zone_id = zones.id 
                WHERE hotel.is_deleted = 0
        ";
        
        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND hotel.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (isset($zone) && $zone != "all") {
            $query .= " AND zones.id = ?";
            $bind_types .= "i";
            array_push($params, $zone);
        }

        if (!empty($name)) {
            $query .= " AND hotel.name LIKE ?";
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
    
    public function show_province()
    {
        $query = "SELECT id, name_th, name_en
            FROM provinces 
            WHERE id > 0 AND is_deleted = 0
        ";
        $query .= " ORDER BY name_en ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_zone()
    {
        $query = "SELECT id, name
            FROM zones 
            WHERE id > 0 AND is_deleted = 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }
}
