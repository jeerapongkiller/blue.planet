<?php
require_once __DIR__ . '/DB.php';

class Captain extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT *
            FROM captains 
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
            FROM captains 
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

    public function insert_data(int $is_approved, string $id_card, string $name, string $telephone, string $address, int $sex, string $birth_date, array $picFile)
    {
        // upload pic file
        $picResponse = $this->uploadFile($picFile);
        $countpic = count($picResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO captains (id_card, name, telephone, address, sex, birth_date, pic, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $id_card);

        $bind_types .= "s";
        array_push($params, $name);

        $bind_types .= "s";
        array_push($params, $telephone);

        $bind_types .= "s";
        array_push($params, $address);

        $bind_types .= "i";
        array_push($params, $sex);

        $bind_types .= "s";
        array_push($params, $birth_date);

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

    public function update_data(int $is_approved, string $id_card, string $name, string $telephone, string $address, int $sex, string $birth_date, array $picFile, int $id)
    {
        // upload pic file
        $picResponse = $this->uploadFile($picFile);
        $countpic = count($picResponse);

        $bind_types = "";
        $params = array();

        $query = "UPDATE captains SET";

        $query .= " id_card = ?,";
        $bind_types .= "s";
        array_push($params, $id_card);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " telephone = ?,";
        $bind_types .= "s";
        array_push($params, $telephone);

        $query .= " address = ?,";
        $bind_types .= "s";
        array_push($params, $address);

        $query .= " sex = ?,";
        $bind_types .= "i";
        array_push($params, $sex);

        $query .= " birth_date = ?,";
        $bind_types .= "s";
        array_push($params, $birth_date);

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

        $query = "UPDATE captains SET";

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

    public function check_id_card(int $id_card, int $captain_id = 0)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
            FROM captains 
            WHERE 
        ";

        $query .= " id_card = ?";
        $bind_types .= "i";
        array_push($params, $id_card);

        if ($captain_id != 0) {
            $query .= " AND id != ?";
            $bind_types .= "i";
            array_push($params, $captain_id);
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

    public function search($is_approved, string $id_card, string $name, $sex)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT *
                FROM captains 
                WHERE is_deleted = 0 
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($id_card)) {
            $query .= " AND id_card LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $id_card . '%');
        }

        if (!empty($name)) {
            $query .= " AND name LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $name . '%');
        }

        if (isset($sex) && $sex != "all") {
            $query .= " AND sex = ?";
            $bind_types .= "i";
            array_push($params, $sex);
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
