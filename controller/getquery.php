<?php 
   namespace allQuery;

   class GetAllQuery{
      public $database;
      
      public function __construct($database){
         $this->database = $database;
      }
   
      public function getAllQuery(){
         $sql_req = "SELECT * FROM users";
         
         try{
            $stmt = $this->database->prepare($sql_req);
            $stmt->execute();
            return $stmt->get_result();
         }catch(mysqli_sql_exception){
            return false;
         }
      }
   }


?>