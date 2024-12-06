<?php 
class User{
    private $connect;
    public $table_name = 'information';
    public $username;
    public $password;
    public $email;
    public $Address;

    public $phone;
    public $age;
    public $birthday;
    public $gender;

    public function __construct($db) {
        $this->connect = $db;
    }

    public function create() {
        if ($this->emailExists()) {
            return false; // 
        }
        $query = "INSERT INTO " . $this->table_name . " (username, password, email, Address, phone, age, birthday, gender) 
        VALUES (:username, :password, :email, :Address, :phone, :age, :birthday, :gender)";
        $set = $this->connect->prepare($query);

        $set->bindParam(':username', $this->username);
        $set->bindParam(':password', $this->password);
        $set->bindParam(':email', $this->email);
        $set->bindParam(':Address', $this->Address);
        $set->bindParam(':phone', $this->phone);
        $set->bindParam(':age', $this->age);
        $set->bindParam(':birthday', $this->birthday);
        $set->bindParam(':gender', $this->gender);
        
        if ($set->execute()) {
            return true;
        }
        return false;
    }
    public function emailExists() {
        $query = "SELECT email FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $set = $this->connect->prepare($query);
        $set->bindParam(':email', $this->email);
        $set->execute();
    
        if ($set->rowCount() > 0) {
            return true;
        }
        return false; 
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name; 
        $set = $this->connect->prepare($query);
        $set->execute();

        return $set;
    }

public function updateByUsername($currentUsername, $newUsername, $newData) {
    
    $query = "UPDATE " . $this->table_name . " 
              SET username = :newUsername, 
                  password = :password, 
                  email = :email, 
                  Address = :Address,
                  phone = :phone, 
                  age = :age, 
                  birthday = :birthday, 
                  gender = :gender 
              WHERE username = :currentUsername";
    
    $stmt = $this->connect->prepare($query);

    
    $stmt->bindParam(':currentUsername', $currentUsername);
    $stmt->bindParam(':newUsername', $newUsername);
    $stmt->bindParam(':password', $newData['password']);
    $stmt->bindParam(':email', $newData['email']);
    $stmt->bindParam(':Address', $newData['Address']);
    $stmt->bindParam(':phone', $newData['phone']);
    $stmt->bindParam(':age', $newData['age']);
    $stmt->bindParam(':birthday', $newData['birthday']);
    $stmt->bindParam(':gender', $newData['gender']);

    
    if ($stmt->execute()) {
        
        return true; 
    } else {
        echo "Error: " . implode(", ", $stmt->errorInfo()); 
        return false; 
    }
}
}
?>