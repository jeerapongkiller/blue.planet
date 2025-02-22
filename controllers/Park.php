<?php
require_once __DIR__ . '/DB.php';

class Park extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT *
        FROM park 
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
            FROM park 
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

    

    public function insert_data(int $is_approved, string $name, string $rate_adult_eng, string $rate_child_eng, string $rate_adult_th, string $rate_child_th)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO park (name, rate_adult_eng, rate_child_eng, rate_adult_th, rate_child_th, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, 0, now(), now())";

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "d";
        array_push($params, $rate_adult_eng);

        $bind_types .= "d";
        array_push($params, $rate_child_eng);

        $bind_types .= "d";
        array_push($params, $rate_adult_th);

        $bind_types .= "d";
        array_push($params, $rate_child_th);

        $bind_types .= "i";
        array_push($params, $is_approved);
       
        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name, string $rate_adult_eng, string $rate_child_eng, string $rate_adult_th, string $rate_child_th, int $park_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE park SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " rate_adult_eng = ?,";
        $bind_types .= "d";
        array_push($params, $rate_adult_eng);
     
        $query .= " rate_child_eng = ?,";
        $bind_types .= "d";
        array_push($params, $rate_child_eng);
     
        $query .= " rate_adult_th = ?,";
        $bind_types .= "d";
        array_push($params, $rate_adult_th);
     
        $query .= " rate_child_th = ?,";
        $bind_types .= "d";
        array_push($params, $rate_child_th);

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);
     
        $query .= " updated_at = now()";

        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $park_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_data(int $park_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE park SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, 0);

        $query .= " is_deleted = ?,";
        $bind_types .= "i";
        array_push($params, 1);

        $query .= " updated_at = now()";

        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $park_id);

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

        $query = "SELECT *
                FROM park 
                WHERE id > 0
        ";

        // $query = "SELECT provinces.* , country.id as countryId, country.name_th as countryNameTH, country.name_en as countryNameEN
        //  FROM provinces 
          
        //     LEFT JOIN country
        //         ON provinces.country = country.id WHERE provinces.id > 0
        // ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND park.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($name)) {
            $query .= " AND park.name LIKE ?";
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
