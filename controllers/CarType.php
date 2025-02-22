<?php
require_once __DIR__ . '/DB.php';

class Car_type extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT cars_type.*, cars_category.id as categoryId, cars_category.name as categoryName
            FROM cars_type 
            LEFT JOIN cars_category
                ON cars_type.car_category_id = cars_category.id
            WHERE cars_type.id > 0 
        ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showcategory()
    {
        $query = "SELECT *
            FROM cars_category 
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
        $query = "SELECT *
            FROM cars_type
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

    public function insert_data(string $name, int $category)
    {
        $name_trim = trim($name);
        $slug = str_replace(' ', '-', $name_trim);
        $query = "INSERT INTO cars_type (name, slug, car_category_id, created_at, updated_at)
        VALUES (?, ?, ?, NOW(), NOW())";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("ssi", $name_trim, $slug, $category);

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $id, int $category_id, string $name)
    {
        $name_trim = trim($name);
        $slug = str_replace(' ', '-', $name_trim);

        $bind_types = "";
        $params = array();

        $query = "UPDATE cars_type SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name_trim);

        $query .= " slug = ?,";
        $bind_types .= "s";
        array_push($params, $slug);

        $query .= " car_category_id = ?,";
        $bind_types .= "i";
        array_push($params, $category_id);

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

        $query = "UPDATE cars_type SET";

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

    public function check_name(int $car_type_id = 0, int $category = 0, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM cars_type 
            WHERE 
        ";

        $query .= " name = ?";
        $bind_types .= "s";
        array_push($params, $name);

        if ($category != 0) {
            $query .= " AND car_category_id = ?";
            $bind_types .= "i";
            array_push($params, $category);
        }

        if ($car_type_id != 0) {
            $query .= " AND id != ?";
            $bind_types .= "i";
            array_push($params, $car_type_id);
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

    public function search($category, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT cars_type.*, cars_category.id as categoryId, cars_category.name as categoryName
            FROM cars_type
            LEFT JOIN cars_category
                ON cars_type.car_category_id = cars_category.id
            WHERE cars_type.id > 0 
        ";

        if (isset($category) && $category != "all") {
            $query .= " AND cars_type.car_category_id = ?";
            $bind_types .= "i";
            array_push($params, $category);
        }

        if (!empty($name)) {
            $query .= " AND cars_type.name LIKE ?";
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
