<?php
require_once __DIR__ . '/DB.php';

class Bank extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT * FROM banks
            WHERE id > 0 AND is_daleted = 0
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
            FROM banks
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

    public function insert_data(string $name)
    {
        $name_trim = trim($name);
        $slug = str_replace(' ', '-', $name_trim);
        $query = "INSERT INTO banks (name, slug, is_daleted, created_at, updated_at)
        VALUES (?, ?, 0, NOW(), NOW())";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("ss", $name, $slug);

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $id, string $name)
    {
        $name_trim = trim($name);
        $slug = str_replace(' ', '-', $name_trim);

        $bind_types = "";
        $params = array();

        $query = "UPDATE banks SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " slug = ?,";
        $bind_types .= "s";
        array_push($params, $slug);

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

        $query = "UPDATE banks SET";

        $query .= " is_daleted = ?,";
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
            FROM banks 
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

    public function search(string $name)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM banks 
            WHERE id > 0 
        ";

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
