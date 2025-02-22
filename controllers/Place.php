<?php
require_once __DIR__ . '/DB.php';

class Place extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT place.* , provinces.id as provincesId, provinces.name_th as provincesNameTH, provinces.name_en as provincesNameEN
        FROM place 
         
           LEFT JOIN provinces
               ON place.provinces = provinces.id WHERE place.is_deleted = '0'
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
            FROM place 
            WHERE is_deleted = 0 AND id = ?
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

    public function insert_data(int $is_approved, string $name, int $pickup, int $dropoff, int $province, int $zone)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO place (name, pickup, dropoff, is_approved, is_deleted, created_at, updated_at,provinces,zones)
        VALUES (?, ?, ?, ?, 0, NOW(), NOW(),?,?)";

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "i";
        array_push($params, $pickup);

        $bind_types .= "i";
        array_push($params, $dropoff);

        $bind_types .= "i";
        array_push($params, $is_approved);


        $bind_types .= "i";
        array_push($params, $province);

        $bind_types .= "i";
        array_push($params, $zone);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name, int $pickup, int $dropoff, int $province, int $zone, int $place_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE place SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " pickup = ?,";
        $bind_types .= "i";
        array_push($params, $pickup);

        $query .= " dropoff = ?,";
        $bind_types .= "i";
        array_push($params, $dropoff);

        $query .= " provinces = ?,";
        $bind_types .= "i";
        array_push($params, $province);

        $query .= " zones = ?,";
        $bind_types .= "i";
        array_push($params, $zone);

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);

        $query .= " updated_at = now()";

        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $place_id);

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

        $query = "UPDATE place SET";

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

    public function search($is_approved, string $name)
    {
        $bind_types = "";
        $params = array();
      
        $query = "SELECT place.* , provinces.id as provincesId, provinces.name_th as provincesNameTH, provinces.name_en as provincesNameEN
        FROM place 
         
           LEFT JOIN provinces
               ON place.provinces = provinces.id WHERE place.is_deleted = '0'
        ";
        

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND place.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($name)) {
            $query .= " AND place.name LIKE ?";
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
