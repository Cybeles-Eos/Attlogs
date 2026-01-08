<?php 

   //usersportlog - Database root name
   //users - Table name
   $db_server = 'localhost';
   $db_user = 'root';
   $db_pass = '';
   $db_name = 'attlogs';
   $conn = '';

    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }catch(mysqli_sql_exception){
        echo "Failed To Connect Database(SQL)";
    }

?>