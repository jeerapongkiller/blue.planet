<?php
require_once __DIR__ . '/DB.php';

class Car extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT *
            FROM cars 
            WHERE is_deleted = 0 
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

    public function showtype()
    {
        $query = "SELECT *
            FROM cars_type 
            WHERE id > 0 
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function change_category(int $category_id)
    {
        $query = "SELECT *
            FROM cars_type 
            WHERE car_category_id = ?
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $category_id);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = false;
        }
        return $data;
    }

    public function get_data(int $id)
    {
        $query = "SELECT *
        FROM cars 
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

    public function insert_data(int $is_approved, int $category, string $name, string $registration, int $capacity)
    {
        $registration_trim = trim($registration);
        $slug = str_replace(' ', '-', $registration_trim);

        $query = "INSERT INTO cars (car_registration, name, slug, capacity, cars_category_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("sssiii", $registration_trim, $name, $slug, $capacity, $category, $is_approved);

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, int $category, string $name, string $registration, int $capacity, int $id)
    {
        $registration_trim = trim($registration);
        $slug = str_replace(' ', '-', $registration_trim);

        $bind_types = "";
        $params = array();

        $query = "UPDATE cars SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);

        $query .= " car_registration = ?,";
        $bind_types .= "s";
        array_push($params, $registration);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " slug = ?,";
        $bind_types .= "s";
        array_push($params, $slug);

        $query .= " cars_category_id = ?,";
        $bind_types .= "i";
        array_push($params, $category);

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

        $query = "UPDATE cars SET";

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

    public function check_name(int $car_id = 0, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM cars 
            WHERE 
        ";

        $query .= " name = ?";
        $bind_types .= "s";
        array_push($params, $name);

        if ($car_id != 0) {
            $query .= " AND id != ?";
            $bind_types .= "i";
            array_push($params, $car_id);
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

    public function check_registration(int $id, string $registration)
    {
        $query = "SELECT *
            FROM cars 
            WHERE car_registration = ?
            AND id != $id
        ";

        // $query .= $id != 0 ? ' AND id != ' . $id : '';
        $statement = $this->connection->prepare($query);
        $statement->bind_param("s", $registration);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows == 0) {
            $data = 'true';
        } else {
            $data = 'false';
        }

        return $data;
    }

    public function search($is_approved, string $registration, string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM cars 
            WHERE is_deleted = 0 
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($registration)) {
            $query .= " AND car_registration LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $registration . '%');
        }

        if (!empty($name)) {
            $query .= " AND name LIKE ?";
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
