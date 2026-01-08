<?php 
namespace newUser;

class InsertNewUser {

    public $database;
    private $name;
    private $email;
    private $pass;

    public function __construct($database, $name, $email, $pass) {
        $this->database = $database;
        $this->name  = $name;
        $this->email = $email;
        $this->pass  = $pass;
    }

    public function insert() {

        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        try {
            $stmt = $this->database->prepare($sql);
            $stmt->bind_param("sss", $this->name, $this->email, $this->pass);
            $stmt->execute();
            $stmt->close();

        } catch (mysqli_sql_exception $e) {

            if ($e->getCode() === 1062) {
                echo "<script>alert('Email already exists')</script>";
                exit();
            }

            return "Error: " . $e->getMessage();
        }
    }
}
