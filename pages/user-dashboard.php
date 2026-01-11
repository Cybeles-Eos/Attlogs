<?php
    session_start();
    include('../database/database.php');
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    //Get User Data Session
    $nameId = htmlspecialchars($_SESSION['user_id']);

    // Get All Data of nameId 
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nameId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    $isin       = (int) $user['is_in'];
    $isenrolled = (int) $user['is_enrolled'];
    $name       = htmlspecialchars($user['name']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Dashboard</title>
    
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    
</head>
<body class="d-flex text-center text-bg-dark" style="height: 100vh;">
    <!-- <h1>I:<?= $isin ?> E: <?= $isenrolled ?></h1> -->
    
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column"> 
        <header class="mb-auto"> 
            <div class="mt-3 px-3"> 
                <h4 class="float-md-start mb-0">ATTLOGS</h4> 
                <nav class="nav nav-masthead justify-content-center float-md-end"> 
                    <a class="btn btn-primary" href="../logout.php">Logout</a> 
                </nav> 
            </div> 
        </header> 
        <main class="px-3"> 
            <h1>Welcome <?= $name ?></h1> 
            <p class="lead" style="max-width: 700px; margin: 1rem auto">Tap the button below to record your time in for today. This action confirms your attendance and ensures your daily record is saved properly.</p> 
            <p class="lead"> 
                <?php  
                    if ($isenrolled != 0) {
                        if ($isin == 0) {
                            echo "
                                <button 
                                    id='time-in' 
                                    data-userid='{$nameId}' 
                                    class='btn btn-lg btn-light fw-bold border-white bg-white'>
                                    Time In
                                </button>
                            ";
                        } elseif ($isin == 1){
                            echo "
                                <button 
                                    class='btn btn-lg btn-danger'
                                    id='time-out' 
                                    data-useroid='{$nameId}'
                                    >
                                    Time Out
                                </button>
                            ";
                        }
                        else {
                            echo "
                                <p style='font-size: 20px; color: gray'>Your Schedule Is Ended</p>
                            ";
                        }
                    } else {
                        echo "
                            <button id='enroll' class='btn btn-lg btn-warning' data-usereid='{$nameId}'>
                                Enroll Now
                            </button>
                        ";
                    }
                ?>
            </p> 
        </main> 
        <footer class="mt-auto text-white-50"> 
            <p>Team Daniiii ♥.</p> 
        </footer> 
    </div>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script>
        $("#time-in").on("click", function () {

            const userId = $(this).data("userid");

            $.ajax({
                url: "../controller/timein.php",
                type: "POST",
                data: { user_id: userId },
                success: function (response) {
                    if (response === "success") {
                        alert("Time in recorded");
                        location.reload();
                        // $("#timeInBtn").prop("disabled", true).text("In");
                    } else {
                        alert(response);
                    }
                }
            });

        });
        $("#time-out").on("click", function () {

            const userId = $(this).data("data-useroid");

            $.ajax({
                url: "../controller/timeout.php",
                type: "POST",
                data: { user_id: userId },
                success: function (response) {
                    if (response === "success") {
                        alert("Time Out recorded");
                        location.reload();
                        // $("#timeInBtn").prop("disabled", true).text("In");
                    } else {
                        alert(response);
                    }
                }
            });

        });
        $("#enroll").on("click", function () {

            const userId = $(this).data("usereid");

            $.ajax({
                url: "../controller/enroll.php",
                type: "POST",
                data: { user_id: userId },
                success: function (response) {
                    if (response === "success") {
                        alert("You are now enrolled");
                        location.reload();
                    } else {
                        alert(response);
                    }
                }
            });

        });
   </script>
</body>
</html>