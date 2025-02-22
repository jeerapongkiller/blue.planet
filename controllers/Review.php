<?php
require_once __DIR__ . '/DB.php';

class Review extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT review_tours.*,
        products.id as proID, products.name as proName 
        FROM review_tours
        LEFT JOIN products
            ON review_tours.products = products.id
        WHERE review_tours.id > 0 
    ";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function get_data(int $id)
    {
        $query = "SELECT review_tours.*,review_tours.id as reID,
        products.id as proID, products.name as proName 
        FROM review_tours
        LEFT JOIN products
            ON review_tours.products = products.id
        WHERE review_tours.id = ?
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

   
    public function update_data(int $is_approved, int $review_id)
    {
      
        $bind_types = "";
        $params = array();

        $query = "UPDATE review_tours SET";      
       
        $query .= " status = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);


        $query .= " last_edit_time = now()";

        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $review_id);

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

        $query = "UPDATE review_tours SET";

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

  
    public function search($is_approved, $products)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT review_tours.*,review_tours.id as reID,
        products.id as proID, products.name as proName 
        FROM review_tours
        LEFT JOIN products
            ON review_tours.products = products.id
        WHERE review_tours.id > 0 ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND review_tours.status = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (isset($products) && $products != "all") {
            $query .= " AND products.id = ?";
            $bind_types .= "i";
            array_push($params, $products);
        }

     
      

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function show_product()
    {
        $query = "SELECT id, name, is_approved
            FROM products 
            WHERE is_approved = 1 
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function uploadFile(array $fileArray)
    {
        $responseFilename = array();
        $countfiles = count($fileArray);
        for ($i = 0; $i < $countfiles; $i++) {
            $fileTmpPath = !empty($fileArray['fileTmpPath'][$i]) ? $fileArray['fileTmpPath'][$i] : '';
            $fileName = !empty($fileArray['fileName'][$i]) ? $fileArray['fileName'][$i] : '';
            $fileSize = !empty($fileArray['fileSize'][$i]) ? $fileArray['fileSize'][$i] : '';
            $fileBefore = !empty($fileArray['fileBefore'][$i]) ? $fileArray['fileBefore'][$i] : '';
            $fileDelete = !empty($fileArray['fileDelete'][$i]) ? $fileArray['fileDelete'][$i] : '';
            $uploadFileDir = !empty($fileArray['fileDir'][$i]) ? $fileArray['fileDir'][$i] : '';

            if (!empty($fileName)) {
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $allowedfileExtensions = array('jpg', 'jpeg', 'png');
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                    // directory in which the uploaded file will be moved
                    $targetPath = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $targetPath)) {
                        $responseFilename['filename'][$i] = $newFileName;
                        !empty($fileBefore) ? unlink($uploadFileDir . $fileBefore) : '';
                    }
                }
            } elseif ($fileDelete == 1) {
                !empty($fileBefore) ? unlink($uploadFileDir . $fileBefore) : '';
                $responseFilename['filename'][$i] = "";
            } else {
                $responseFilename['filename'][$i] = $fileBefore;
            }
        }

        return $responseFilename;
    }

    public function get_age(string $date)
    {
        $then = strtotime($date);
        return (floor((time() - $then) / 31556926));
    }
}
