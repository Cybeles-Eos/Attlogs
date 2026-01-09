<?php
    session_start();
    include('../database/database.php');
    include("../controller/getquery.php");
    use allQuery\GetAllQuery;

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

   // Get all users from database.
   $data = new GetAllQuery($conn);
   $result = $data->getAllQuery();
   if (!$result) die("Error fetching users.");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>

    <title>Admin</title>
</head>
<body>

    <main style="max-width: 900px; margin: 0 auto;">
        <h1 class="mt-5">Admin</h1>
        <a href="../logout.php">Logout</a>
        <br><br>
        <table style="border-collapse: collapse; width:100%;">
            <thead>
                <tr>
                    <th style="border:1px solid #ccc; padding:8px;">ID</th>
                    <th style="border:1px solid #ccc; padding:8px;">Name</th>
                    <th style="border:1px solid #ccc; padding:8px;">Email</th>
                    <th style="border:1px solid #ccc; padding:8px;">Role</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($query = $result->fetch_assoc()){
                        echo "
                            <tr>
                                <td style='border:1px solid #ccc; padding:8px;'>{$query['id']}</td>
                                <td style='border:1px solid #ccc; padding:8px;'>{$query['name']}</td>
                                <td style='border:1px solid #ccc; padding:8px;'>{$query['email']}</td>
                                <td style='border:1px solid #ccc; padding:8px;'>{$query['role']}</td>
                            </tr>
                        ";
                    }
                ?>

            </tbody>
        </table>
    </main>


</body>
</html>