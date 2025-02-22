<?php
require_once __DIR__ . '/DB.php';

class Zone extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT ZO.*,
            POV.id as pov_id, POV.name_en as pov_nameen, POV.name_th as pov_nameth
            FROM zones ZO
            LEFT JOIN provinces POV
                ON ZO.provinces = POV.id
            WHERE ZO.is_deleted = 0
    ";
        $statement = $this->connection->prepare($query);
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

    public function get_data(int $id)
    {
        $query = "SELECT ZO.*,
            POV.id as pov_id, POV.name_en as pov_nameen, POV.name_th as pov_nameth
            FROM zones ZO
            LEFT JOIN provinces POV
                ON ZO.provinces = POV.id 
            WHERE ZO.id = ?
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

    public function insert_data(int $is_approved, string $name, string $name_th, string $start_pickup, string $end_pickup, int $pickup, int $dropoff, int $provinces)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO zones (provinces, name, name_th, start_pickup, end_pickup, pickup, dropoff, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, now(), now())";

        $bind_types .= "i";
        array_push($params, $provinces);

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $name_th);

        $bind_types .= "s";
        array_push($params, $start_pickup);

        $bind_types .= "s";
        array_push($params, $end_pickup);

        $bind_types .= "i";
        array_push($params, $pickup);

        $bind_types .= "i";
        array_push($params, $dropoff);

        $bind_types .= "i";
        array_push($params, $is_approved);
       
        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name, string $name_th, string $start_pickup, string $end_pickup, int $province, int $zone_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE zones SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);
     
        $query .= " name_th = ?,";
        $bind_types .= "s";
        array_push($params, $name_th);

        $query .= " start_pickup = ?,";
        $bind_types .= "s";
        array_push($params, $start_pickup);

        $query .= " end_pickup = ?,";
        $bind_types .= "s";
        array_push($params, $end_pickup);

        $query .= " provinces = ?,";
        $bind_types .= "i";
        array_push($params, $province);

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);

        $query .= " updated_at = now()";

        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $zone_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_data(int $zone_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE zones SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, 0);

        $query .= " is_deleted = ?,";
        $bind_types .= "i";
        array_push($params, 1);

        $query .= " updated_at = now()";

        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $zone_id);

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

        $query = "SELECT zones.*,
                POV.id as pov_id, POV.name_en as pov_nameen, POV.name_th as pov_nameth
                FROM zones
                LEFT JOIN provinces POV
                    ON zones.provinces = POV.id 
                WHERE zones.id > 0
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND zones.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($name)) {
            $query .= " AND zones.name LIKE ?";
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
