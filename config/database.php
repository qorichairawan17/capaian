<?php
class Database
{
    private $host = '153.92.15.55';
    private $user = 'u322727425_db_sipp_user';
    private $pass = 'S1pp@123';
    private $dbname = 'u322727425_db_sipp';
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die('Gagal menghubungkan ke database: ' . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
