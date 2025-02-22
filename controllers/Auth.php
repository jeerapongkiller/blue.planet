<?php
require_once __DIR__ . '/DB.php';

class Auth extends DB
{
    public $response = "false";
    private $hashed_password = "";

    public function __construct()
    {
        parent::__construct();
    }
    
    public function check_login(string $username, string $password)
    {
        $query = "SELECT login.*, 
            users.*,
            roles.id as roleId, roles.name as roleName
            FROM login 
            LEFT JOIN users
                ON login.user_id = users.id
            LEFT JOIN roles
                ON users.role_id = roles.id
            WHERE login.username = ? AND users.is_approved = 1 AND users.is_deleted = 0
        ";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $login = $result->fetch_assoc();
            $this->hashed_password = $login['password'];

            if (password_verify($password, $this->hashed_password)) {
                $_SESSION["supplier"]["id"] = $login['id'];
                $_SESSION["supplier"]["fullname"] = $login['firstname'] . " " . $login['lastname'];
                $_SESSION["supplier"]["email"] = $login['email'];
                $_SESSION["supplier"]["telephone"] = $login['telephone'];
                $_SESSION["supplier"]["role_id"] = $login['role_id'];
                $_SESSION["supplier"]["role_name"] = $login['roleName'];
                $_SESSION["supplier"]["department_id"] = $login['department_id'];

                # --- permission --- #
                $query = "SELECT id, permission_id 
                    FROM permission_user
                    WHERE user_id = ?
                ";
                $statement = $this->connection->prepare($query);
                $statement->bind_param("i", $login['id']);
                $statement->execute();
                $result = $statement->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($data as $permission) {
                    $_SESSION["supplier"]["permission"][] = $permission['permission_id'];
                }

                $this->response = $login['id'];
            }
            
        }

        $this->connection->close();

        return $this->response;
    }
}
