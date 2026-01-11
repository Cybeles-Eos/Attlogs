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
      

      // Get Enrollment Status Message : LEFT JOIN
      public function getAllesm() {
         $sql = "
            SELECT 
               u.id,
               u.name,
               u.email,
               u.role,
               u.is_enrolled,
               s.message
            FROM users u
            LEFT JOIN enrollment_status s
               ON u.is_enrolled = s.id
         ";

         $stmt = $this->database->prepare($sql);
         $stmt->execute();
         return $stmt->get_result();
      }

      // Get Attendance Status Message : LEFT JOIN
      public function getAllPresent() {
         $sql = "
            SELECT 
               u.id,
               u.name,
               u.email,
               u.role,
               u.is_enrolled,
               u.is_in,
               u.time_in,
               u.time_out,
               s.message
            FROM users u
            LEFT JOIN attendance_status s
               ON u.is_in = s.id
         ";

         $stmt = $this->database->prepare($sql);
         $stmt->execute();
         return $stmt->get_result();
      }
   }


?>