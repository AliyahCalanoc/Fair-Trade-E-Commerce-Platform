<?php
class ECommerce {
    private $host = "localhost";
    private $db_name = "Registration";
    private $username = "root";
    private $password = "";
    public $connect;

    public function Connect() {
        $this->connect = null;

        try {
            $this->connect = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            exit();
        }

        return $this->connect;
    }
    
}
?>
