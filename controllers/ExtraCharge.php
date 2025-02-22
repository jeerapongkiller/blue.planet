<?php
require_once __DIR__ . '/DB.php';

class ExtraCharge extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT *
            FROM extra_charges 
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
            FROM extra_charges 
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

    public function insert_data(int $is_approved, string $name, string $unit, string $rate_adult, string $rate_child, string $rate_infant, string $rate_total, string $detail, array $picArray)
    {
        // upload pic file
        $picResponse = $this->uploadFile($picArray);
        $countpic = count($picResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO extra_charges (name, unit, rate_adult, rate_child, rate_infant, rate_total, detail, pic, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $unit);

        $bind_types .= "d";
        array_push($params, $rate_adult);

        $bind_types .= "d";
        array_push($params, $rate_child);

        $bind_types .= "d";
        array_push($params, $rate_infant);

        $bind_types .= "d";
        array_push($params, $rate_total);

        $bind_types .= "s";
        array_push($params, $detail);

        for ($i = 0; $i < $countpic; $i++) {
            $bind_types .= "s";
            array_push($params, $picResponse['filename'][$i]);
        }

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name, string $unit, string $rate_adult, string $rate_child, string $rate_infant, string $rate_total, string $detail, array $picArray, int $id)
    {
        // upload pic file
        $picResponse = $this->uploadFile($picArray);
        $countpic = count($picResponse);

        $bind_types = "";
        $params = array();

        $query = "UPDATE extra_charges SET";

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);
        
        $query .= " unit = ?,";
        $bind_types .= "s";
        array_push($params, $unit);

        $query .= " rate_adult = ?,";
        $bind_types .= "d";
        array_push($params, $rate_adult);

        $query .= " rate_child = ?,";
        $bind_types .= "d";
        array_push($params, $rate_child);

        $query .= " rate_infant = ?,";
        $bind_types .= "d";
        array_push($params, $rate_infant);

        $query .= " rate_total = ?,";
        $bind_types .= "d";
        array_push($params, $rate_total);

        $query .= " detail = ?,";
        $bind_types .= "s";
        array_push($params, $detail);

        for ($i = 0; $i < $countpic; $i++) {
            $query .= " pic = ?,";
            $bind_types .= "s";
            array_push($params, $picResponse['filename'][$i]);
        }

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

        $query = "UPDATE extra_charges SET ";

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

        $query = "SELECT *
                FROM extra_charges 
                WHERE is_deleted = 0 
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
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

    public function uploadFile(array $fileArray)
    {
        $responseFilename = array();
        $countfiles = count($fileArray);
        for ($i = 0; $i < $countfiles; $i++) {
            $fileTmpPath = !empty($fileArray['fileTmpPath'][$i]) ? $fileArray['fileTmpPath'][$i] : '' ;
            $fileName = !empty($fileArray['fileName'][$i]) ? $fileArray['fileName'][$i] : '' ;
            $fileSize = !empty($fileArray['fileSize'][$i]) ? $fileArray['fileSize'][$i] : '' ;
            $fileBefore = !empty($fileArray['fileBefore'][$i]) ? $fileArray['fileBefore'][$i] : '' ;
            $fileDelete = !empty($fileArray['fileDelete'][$i]) ? $fileArray['fileDelete'][$i] : '' ;
            $uploadFileDir = !empty($fileArray['fileDir'][$i]) ? $fileArray['fileDir'][$i] : '' ;

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
        return(floor((time()-$then)/31556926));
    }
}
