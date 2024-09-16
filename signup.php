<?php

class Database {
    private $host = "localhost";
    private $db_name = "ics_e";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}


class User {
    private $conn;
    private $table_name = "users";

    public $fullname;
    public $email;
    public $username;
    public $password;
    public $genderId;
    public $roleId;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (fullname, email, username, password, genderId, roleId)
                  VALUES (:fullname, :email, :username, :password, :genderId, :roleId)";

        $stmt = $this->conn->prepare($query);

       
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":genderId", $this->genderId);
        $stmt->bindParam(":roleId", $this->roleId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $user->fullname = $_POST['fullname'];
    $user->email = $_POST['email'];
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];
    $user->genderId = $_POST['genderId'];
    $user->roleId = $_POST['roleId'];

    if ($user->create()) {
        echo "User registered successfully.";
    } else {
        echo "Unable to register the user.";
    }
}
?>
