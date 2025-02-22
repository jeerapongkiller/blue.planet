<?php
require_once __DIR__ . '/DB.php';

class Province extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist()
    {
        $query = "SELECT provinces.* , country.id as countryId, country.name_th as countryNameTH, country.name_en as countryNameEN
         FROM provinces 
          
            LEFT JOIN country
                ON provinces.country = country.id WHERE provinces.is_deleted = '0'
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
            FROM provinces 
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

    

    public function insert_data(int $is_approved, string $name_en, string $name_th,int $country, array $picFile)
    {
           // upload pic file
           $picResponse = $this->uploadFile($picFile);
           $countpic = count($picResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO provinces (name_en, name_th, pic, is_approved, country)
        VALUES (?, ?, ?, ?, ?)";

        $bind_types .= "s";
        array_push($params, $name_en);

        $bind_types .= "s";
        array_push($params, $name_th);
        
        for ($i = 0; $i < $countpic; $i++) {
            $bind_types .= "s";
            array_push($params, $picResponse['filename'][$i]);
        }

        $bind_types .= "i";
        array_push($params, $is_approved);
        
        $bind_types .= "i";
        array_push($params, $country);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $name_en, string $name_th, int $country, array $picFile, int $province_id)
    {
        $picResponse = $this->uploadFile($picFile);
        $countpic = count($picResponse);

        $bind_types = "";
        $params = array();

        $query = "UPDATE provinces SET";

        $query .= " name_en = ?,";
        $bind_types .= "s";
        array_push($params, $name_en);

        $query .= " name_th = ?,";
        $bind_types .= "s";
        array_push($params, $name_th);

        $query .= " country = ?,";
        $bind_types .= "i";
        array_push($params, $country);

        for ($i = 0; $i < $countpic; $i++) {
            $query .= " pic = ?,";
            $bind_types .= "s";
            array_push($params, $picResponse['filename'][$i]);
        }

        $query .= " is_approved = ?";
        $bind_types .= "i";
        array_push($params, $is_approved);


        $query .= " WHERE id = ?";
        $bind_types .= "i";
        array_push($params, $province_id);

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

        $query = "UPDATE provinces SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, 0);

        $query .= " is_deleted = ?";
        $bind_types .= "i";
        array_push($params, 1);


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

        // $query = "SELECT *
        //         FROM provinces 
        //         WHERE id > 0
        // ";

        $query = "SELECT provinces.* , country.id as countryId, country.name_th as countryNameTH, country.name_en as countryNameEN
         FROM provinces 
          
            LEFT JOIN country
                ON provinces.country = country.id WHERE provinces.id > 0
        ";

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND provinces.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (!empty($name)) {
            $query .= " AND provinces.name_en LIKE ?";
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


    public function show_country()
    {
        $query = "SELECT id, name_th, name_en
            FROM country 
            WHERE id > 0
        ";
        $query .= " ORDER BY name_en ASC";
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
    
}
