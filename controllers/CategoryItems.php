<?php
require_once __DIR__ . '/DB.php';

class CategotyItems extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT *
        FROM category_items 
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
            FROM category_items 
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

    

    public function insert_data(int $is_approved, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO category_items (name, is_approved, created_at)
        VALUES (?, ?, now())";

        $bind_types .= "s";
        array_push($params, $name);
        $bind_types .= "i";
        array_push($params, $is_approved);
       
        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name, int $category_items_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE category_items SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);
     

        $query .= " is_approved = ?";
        $bind_types .= "i";
        array_push($params, $is_approved);


        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $category_items_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function delete_data(int $category_items_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE category_items SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, 0);

        $query .= " is_deleted = ?";
        $bind_types .= "i";
        array_push($params, 1);


        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $category_items_id);

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
                FROM category_items 
                WHERE id > 0
        ";

        // $query = "SELECT provinces.* , country.id as countryId, country.name_th as countryNameTH, country.name_en as countryNameEN
        //  FROM provinces 
          
        //     LEFT JOIN country
        //         ON provinces.country = country.id WHERE provinces.id > 0
        // ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND category_items.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($name)) {
            $query .= " AND category_items.name LIKE ?";
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
