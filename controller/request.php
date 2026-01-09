<?php 
   namespace findUser;

    class Request{
        public $database;
        private $name;

        public function __construct($database, $name){
            $this->database = $database;
            $this->name = $name;
        }

        public function getUser() {

            $sql = "SELECT * FROM users WHERE email = ? OR name = ?";

            try {
                $stmt = $this->database->prepare($sql);
                $stmt->bind_param("ss", $this->name, $this->name);
                $stmt->execute();

                $result = $stmt->get_result();

                //Return result in associative array
                return $result->num_rows > 0
                    ? $result->fetch_assoc()
                    : null;

            } catch (mysqli_sql_exception $e) {
                return false;
            }
        }

        //OLD
        // public function getUser(){
        //     $sql_req = "SELECT * FROM users WHERE username = ?";

        //     try{
        //         $stmt = $this->database->prepare($sql_req);
        //         $stmt->bind_param("s", $this->name);
        //         $stmt->execute();
        //         $result = $stmt->get_result();
        //     if (mysqli_num_rows($result) > 0) {
        //         return $result->fetch_assoc(); // to return just the row
        //     }else{
        //         return null;
        //     }
            
        //     }catch(mysqli_sql_exception){
        //         return false;
        //     }
        // }
    }

?>