<?php
require_once __DIR__ . '/DB.php';

class Product extends DB
{
    public $response = false;
    public $response_itinerary = true;
    public $response_products_file = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function random_refcode()
    {
        do {
            $data = (rand(10000, 99999));
            $query = "SELECT * 
                    FROM products 
                    WHERE refcode = ? ";
            $statement = $this->connection->prepare($query);
            $statement->bind_param("s", $data);
            $statement->execute();
            $result = $statement->get_result();
        } while ($result->num_rows > 0);

        return $data;
    }

    public function showlist()
    {
        $query = "SELECT *
            FROM products 
            WHERE is_deleted = 0
        ";
        $query .= "  ORDER BY name DESC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showpark()
    {
        $query = "SELECT id, name, is_approved
            FROM park 
            WHERE is_approved = 1
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    function showzone(int $product_id)
    {
        $query = "SELECT zones.*,
                TZ.id as tz_id, TZ.start_pickup as start_pickup, TZ.end_pickup as end_pickup
                FROM zones
                LEFT JOIN time_zone TZ
                    ON zones.id = TZ.zone_id
                    AND TZ.product_id = $product_id
                ";
        $query .= " ORDER BY zones.id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_category(int $product_id)
    {
        $query = "SELECT *
            FROM product_category 
            WHERE product_id = ?
            AND is_deleted = 0
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $product_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_period(int $category_id)
    {
        $query = "SELECT *
            FROM product_periods 
            WHERE product_category_id = ?
            AND is_deleted = 0
        ";
        $query .= " ORDER BY period_from ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $category_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_rates(int $period_id)
    {
        $query = "SELECT *
            FROM product_rates
            WHERE product_period_id = ? AND is_approved = 1
        ";
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $period_id);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function get_data(int $id)
    {
        $query = "SELECT *
            FROM products 
            WHERE is_deleted = 0 
            AND products.id = ?
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

    public function check_period(int $period_id, int $category_id, string $period_from, string $period_to)
    {
        $query = "SELECT * 
                FROM product_periods 
                WHERE product_category_id = ? AND (period_from <= ?) AND (period_to >= ?) AND id != ?
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("issi", $category_id, $period_to, $period_from, $period_id);
        $statement->execute();
        $result = $statement->get_result();

        return $result->num_rows;
    }

    public function insert_data(int $is_approved, string $refcode, string $name, string $note, int $pax, int $park_id)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO products (refcode, name, slug, pax, note, park_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $refcode);

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $refcode);

        $bind_types .= "i";
        array_push($params, $pax);

        $bind_types .= "s";
        array_push($params, $note);

        $bind_types .= "i";
        array_push($params, $park_id);

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name, string $note, int $pax, int $park_id, int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE products SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " pax = ?,";
        $bind_types .= "i";
        array_push($params, $pax);

        $query .= " note = ?,";
        $bind_types .= "s";
        array_push($params, $note);

        $query .= " park_id = ?,";
        $bind_types .= "i";
        array_push($params, $park_id);

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

    public function insert_period(int $is_approved, int $category_id, string $period_from_date, string $period_to_date)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO product_periods (period_from, period_to, product_category_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $period_from_date);

        $bind_types .= "s";
        array_push($params, $period_to_date);

        $bind_types .= "i";
        array_push($params, $category_id);

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_period(int $is_approved, int $id, string $period_from, string $period_to)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE product_periods SET";

        $query .= " period_from = ? ,";
        $bind_types .= "s";
        array_push($params, $period_from);

        $query .= " period_to = ? ,";
        $bind_types .= "s";
        array_push($params, $period_to);

        $query .= " is_approved = ?";
        $bind_types .= "i";
        array_push($params, $is_approved);

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

    public function insert_rates(string $period_id, string $cost_adult, string $rate_adult, string $cost_child, string $rate_child, string $cost_infant, string $rate_infant)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO product_rates (cost_adult, cost_child, cost_infant, rate_adult, rate_child, rate_infant, product_period_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW())";

        $bind_types .= "d";
        array_push($params, $cost_adult);

        $bind_types .= "d";
        array_push($params, $cost_child);

        $bind_types .= "d";
        array_push($params, $cost_infant);

        $bind_types .= "d";
        array_push($params, $rate_adult);

        $bind_types .= "d";
        array_push($params, $rate_child);

        $bind_types .= "d";
        array_push($params, $rate_infant);

        $bind_types .= "i";
        array_push($params, $period_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            return $this->connection->insert_id;
        }
    }

    public function update_rates(int $id, string $cost_adult, string $rate_adult, string $cost_child, string $rate_child, string $cost_infant, string $rate_infant)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE product_rates SET";

        $query .= " cost_adult = ? ,";
        $bind_types .= "d";
        array_push($params, $cost_adult);

        $query .= " cost_child = ? ,";
        $bind_types .= "d";
        array_push($params, $cost_child);

        $query .= " cost_infant = ? ,";
        $bind_types .= "d";
        array_push($params, $cost_infant);

        $query .= " rate_adult = ? ,";
        $bind_types .= "d";
        array_push($params, $rate_adult);

        $query .= " rate_child = ? ,";
        $bind_types .= "d";
        array_push($params, $rate_child);

        $query .= " rate_infant = ? ,";
        $bind_types .= "d";
        array_push($params, $rate_infant);

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

    public function insert_category(int $is_approved, int $transfer, int $customer, int $product_id, string $name, string $detail)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO product_category (name, slug, detail, transfer, customer, product_id, is_approved, is_deleted, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, 0, NOW(),NOW())";

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $detail);

        $bind_types .= "i";
        array_push($params, $transfer);

        $bind_types .= "i";
        array_push($params, $customer);

        $bind_types .= "i";
        array_push($params, $product_id);

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function update_category(int $is_approved, int $transfer, int $customer, int $id, string $name, string $detail)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE product_category SET";

        $query .= " name = ? ,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " detail = ? ,";
        $bind_types .= "s";
        array_push($params, $detail);

        $query .= " transfer = ? ,";
        $bind_types .= "i";
        array_push($params, $transfer);

        $query .= " customer = ? ,";
        $bind_types .= "i";
        array_push($params, $customer);

        $query .= " is_approved = ? ,";
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

        $query = "UPDATE products SET";

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

    public function delete_category(int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE product_category SET";

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

    public function delete_period(int $id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE product_periods SET";

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

    public function insert_timezone(int $product_id, int $zone_id, string $start_pickup, string $end_pickup)
    {
        $bind_types = "";
        $params = array();

        $query = "INSERT INTO time_zone (start_pickup, end_pickup, zone_id, product_id, updated_at)
            VALUES (?, ?, ?, ?, NOW())";

        $bind_types .= "s";
        array_push($params, $start_pickup);

        $bind_types .= "s";
        array_push($params, $end_pickup);

        $bind_types .= "i";
        array_push($params, $zone_id);

        $bind_types .= "i";
        array_push($params, $product_id);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function update_timezone(int $id, string $start_pickup, string $end_pickup)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE time_zone SET";

        $query .= " start_pickup = ? ,";
        $bind_types .= "s";
        array_push($params, $start_pickup);

        $query .= " end_pickup = ? ,";
        $bind_types .= "s";
        array_push($params, $end_pickup);

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


    public function search($is_approved, string $refcode, string $name, $suppier, $province, int $products_type)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT products.*, products_type.id as prodtypeId, products_type.name as prodtypeName, provinces.id as provId, provinces.name_th as provNameTH, provinces.name_en as provNameEN, companies.id as compId, companies.name as compName
            FROM products 
            LEFT JOIN products_type
                ON products.product_type_id = products_type.id
            LEFT JOIN provinces
                ON products.province_id = provinces.id
            LEFT JOIN companies
                ON products.company_id = companies.id
            WHERE products.is_deleted = 0
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND products.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($refcode)) {
            $query .= " AND products.refcode LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $refcode . '%');
        }

        if (!empty($name)) {
            $query .= " AND products.name LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $name . '%');
        }

        if (isset($suppier) && $suppier != "all") {
            $query .= " AND products.company_id = ?";
            $bind_types .= "i";
            array_push($params, $suppier);
        }

        if (isset($province) && $province != "all") {
            $query .= " AND products.province_id = ?";
            $bind_types .= "i";
            array_push($params, $province);
        }

        $query .= " AND products.product_type_id = ?";
        $bind_types .= "i";
        array_push($params, $products_type);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }
}
