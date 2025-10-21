<?php
class DB
{
    private $host = 'ftp.shambhala.work';
    // private $host = 'localhost';
    private $username = 'uodaxwdlggpfl';
    private $password = 'ytb8[1{|533A';
    private $database = 'dbggvyzddr7xtk';
    // private $host = 'localhost';
    // private $username = 'root';
    // private $password = '';
    // private $database = 'blueplanet';
    protected $connection;

    public function __construct()
    {
        if (!isset($this->connection)) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }

            $this->connection->set_charset("utf8");
        }

        return $this->connection;
    }

    public function close()
    {
        $this->connection->close();
    }
}