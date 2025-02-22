<?php
require_once __DIR__ . '/DB.php';

class User extends DB
{
    public $response = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function showlist(int $role)
    {
        $query = "SELECT users.*, 
            login.username as username, 
            roles.id as roleId, roles.name as roleName,
            department.id as dpmtId, department.name as dpmtName
            FROM users 
            LEFT JOIN login
                ON users.id = login.user_id
            LEFT JOIN roles
                ON users.role_id = roles.id
            LEFT JOIN department
                ON users.department_id = department.id
            WHERE users.is_deleted = 0
            AND users.companie_id = 0
        ";
        $query .= $role > 1 ? 'AND users.role_id != 1' : '';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showpermissions()
    {
        $query = "SELECT id, name, is_approved
            FROM permissions 
            WHERE is_approved = 1 
        ";
        $query .= " ORDER BY name ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showrole(int $role)
    {
        $query = "SELECT id, name, is_approved
            FROM roles 
            WHERE is_approved = 1 
            AND id != 3
        ";
        $query .= $role > 1 ? ' AND id != 1' : '';
        $query .= $role > 2 ? ' AND id = ' . $role : '';
        $query .= " ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function showdepartment()
    {
        $query = "SELECT id, name, is_approved
            FROM department 
            WHERE is_approved = 1 
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
        $query = "SELECT users.*, login.username as username, roles.id as roleId, roles.name as roleName
            FROM users 
            LEFT JOIN login
                ON users.id = login.user_id
            LEFT JOIN roles
                ON users.role_id = roles.id
            WHERE users.id = ?
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

    public function check_perms(int $user_id, int $perms_id)
    {
        $query = "SELECT *
                FROM permission_user
                WHERE user_id = ? AND permission_id = ?
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("ii", $user_id, $perms_id);
        $statement->execute();
        $result = $statement->get_result();

        return $result->num_rows;
    }

    public function insert_data(int $is_approved, string $firstname, string $lastname, string $email, string $telephone, int $role, int $department, int $companies, int $type, string $address, string $contact_person, string $note, array $fileArray)
    {
        // upload logo file
        $photoResponse = $this->uploadFile($fileArray);
        $countphoto = count($photoResponse);

        $bind_types = "";
        $params = array();

        $query = "INSERT INTO users (firstname, lastname, email, telephone, type, address, contact_person, note, photo, department_id, role_id, companie_id, is_approved, is_deleted, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";

        $bind_types .= "s";
        array_push($params, $firstname);

        $bind_types .= "s";
        array_push($params, $lastname);

        $bind_types .= "s";
        array_push($params, $email);

        $bind_types .= "s";
        array_push($params, $telephone);

        $bind_types .= "s";
        array_push($params, $type);

        $bind_types .= "s";
        array_push($params, $address);

        $bind_types .= "s";
        array_push($params, $contact_person);

        $bind_types .= "s";
        array_push($params, $note);

        for ($i = 0; $i < $countphoto; $i++) {
            $bind_types .= "s";
            array_push($params, $photoResponse['filename'][$i]);
        }

        $bind_types .= "i";
        array_push($params, $department);

        $bind_types .= "i";
        array_push($params, $role);

        $bind_types .= "i";
        array_push($params, $companies);

        $bind_types .= "i";
        array_push($params, $is_approved);

        $statement = $this->connection->prepare($query);
        !empty($bind_types) ? $statement->bind_param($bind_types, ...$params) : '';

        if ($statement->execute()) {
            $this->response = $this->connection->insert_id;
        }

        return $this->response;
    }

    public function insert_login(int $user_id, string $username, string $password)
    {

        $query = "INSERT INTO login (username, password, user_id, created_at, updated_at)
        VALUES (?, ?, ?, NOW(), NOW())";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("ssi", $username, $password, $user_id);
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function insert_permiss(int $user_id, int $permissions)
    {

        $query = "INSERT INTO permission_user (user_id, permission_id, created_at)
        VALUES (?, ?, NOW())";

        $statement = $this->connection->prepare($query);
        $statement->bind_param("ii", $user_id, $permissions);
        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function update_data(int $is_approved, string $firstname, string $lastname, string $email, string $telephone, int $role, int $department, int $companies, int $type, string $address, string $contact_person, string $note, array $fileArray, int $id)
    {
        // upload logo file
        $photoResponse = $this->uploadFile($fileArray);
        $countphoto = count($photoResponse);

        $bind_types = "";
        $params = array();

        $query = "UPDATE users SET";

        $query .= " is_approved = ?,";
        $bind_types .= "i";
        array_push($params, $is_approved);

        $query .= " firstname = ?,";
        $bind_types .= "s";
        array_push($params, $firstname);

        $query .= " lastname = ?,";
        $bind_types .= "s";
        array_push($params, $lastname);

        $query .= " email = ?,";
        $bind_types .= "s";
        array_push($params, $email);

        $query .= " telephone = ?,";
        $bind_types .= "s";
        array_push($params, $telephone);

        for ($i = 0; $i < $countphoto; $i++) {
            $query .= " photo = ?,";
            $bind_types .= "s";
            array_push($params, $photoResponse['filename'][$i]);
        }

        $query .= " role_id = ?,";
        $bind_types .= "i";
        array_push($params, $role);

        $query .= " department_id = ?,";
        $bind_types .= "i";
        array_push($params, $department);

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

    public function update_login(string $password, int $user_id)
    {
        $bind_types = "";
        $params = array();

        $query = "UPDATE login SET";

        $query .= " password = ?,";
        $bind_types .= "s";
        array_push($params, $password);

        $query .= " updated_at = now()";

        $query .= " WHERE user_id = ?";
        $bind_types .= "i";
        array_push($params, $user_id);

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

        $query = "UPDATE users SET";

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

    public function delete_permiss(int $user_id, int $permissions)
    {
        $query = "DELETE FROM permission_user WHERE user_id = ? AND permission_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("ii", $user_id, $permissions);

        if ($statement->execute()) {
            $this->response = true;
        }

        return $this->response;
    }

    public function check_username(string $username)
    {
        $query = "SELECT *
            FROM login 
            WHERE username = ?
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows == 0) {
            $data = 'true';
        } else {
            $data = 'false';
        }

        return $data;
    }

    public function search(int $user_role, $is_approved, $role, string $firstname, string $lastname, string $username)
    {
        $bind_types = "";
        $params = array();

        $query = "SELECT users.*,  login.username as username, roles.id as roleId, roles.name as roleName
            FROM users 
            LEFT JOIN login
                ON users.id = login.user_id
            LEFT JOIN roles
                ON users.role_id = roles.id
            WHERE users.is_deleted = 0 
        ";
        $query .= $user_role > 1 ? 'AND users.id != 1' : '';

        if (isset($is_approved) && $is_approved != "all") {
            $query .= " AND users.is_approved = ?";
            $bind_types .= "i";
            array_push($params, $is_approved);
        }

        if (isset($role) && $role != "all") {
            $query .= " AND users.role_id = ?";
            $bind_types .= "i";
            array_push($params, $role);
        }

        if (!empty($firstname)) {
            $query .= " AND users.firstname LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $firstname . '%');
        }

        if (!empty($lastname)) {
            $query .= " AND users.lastname LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $lastname . '%');
        }

        if (!empty($username)) {
            $query .= " AND login.username LIKE ?";
            $bind_types .= "s";
            array_push($params, '%' . $username . '%');
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
            $uploadFileDir = !empty($fileArray['uploadFileDir'][$i]) ? $fileArray['uploadFileDir'][$i] : '../../../storage/uploads/users/admin/';

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
