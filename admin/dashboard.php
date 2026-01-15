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
   $result = $data->getAllesm();
   if (!$result) die("Error fetching users.");

   $attendanceData = new GetAllQuery($conn);
   $presents = $attendanceData->getAllPresent();
   if (!$presents) die("Error fetching users.");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <title>Admin</title>
</head>
<body>
<div class="admin-bar">
    <h1 class="">Admin</h1>
    <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>
    <main style="max-width: 900px; margin: 0 auto; padding-inline: 1rem">
        <br>
        <div class="d-flex justify-content-center align-items-center py-3">
            <!-- <p class="me-2 mb-0" style="line-height: 100%;">Sort By: </p> -->
            <div class="btn-group" role="group" aria-label="Attendance filter">
                <input type="radio" class="btn-check" name="logFilter" id="filterAll" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="filterAll" style="font-size: 15px;">All Records</label>

                <input type="radio" class="btn-check" name="logFilter" id="filterTimeIn" autocomplete="off">
                <label class="btn btn-outline-primary" for="filterTimeIn" style="font-size: 15px;">Attendance</label>

                <input type="radio" class="btn-check" name="logFilter" id="filterNotTimeIn" autocomplete="off">
                <label class="btn btn-outline-primary" for="filterNotTimeIn" style="font-size: 15px;"><i class="fa fa-cog me-1 mt-1"></i>Actions</label>
            </div>
        </div>
        <br>
        <div id="allrecords">
            <p style="color: #0000006d; font-weight: 500">All Records</p>
            <table style="border-collapse: collapse; width:100%;">
                <thead>
                    <tr>
                        <th style="border:1px solid #ccc; padding:8px;">ID</th>
                        <th style="border:1px solid #ccc; padding:8px;">Name</th>
                        <th style="border:1px solid #ccc; padding:8px;">Email</th>
                        <th style="border:1px solid #ccc; padding:8px;">Enroll Status</th>
                        <th style="border:1px solid #ccc; padding:8px;">Role</th>
                        <th style="border:1px solid #ccc; padding:8px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($query = $result->fetch_assoc()){

                            if($query['role'] !== 'admin'){
                                // $enrolledText = ($query['is_enrolled'] == 1) ? 'Yes' : 'User Not ';
                                echo "
                                    <tr>
                                        <td style=''>{$query['id']}</td>
                                        <td style=''>{$query['name']}</td>
                                        <td style=''>{$query['email']}</td>
                                        <td style=''>{$query['message']}</td>
                                        <td style=''>{$query['role']}</td>
                                        <td style=''>
                                            <button class='btn btn-danger btn-sm delete-user' data-useraid='{$query['id']}'>Delete</button>
                                            <button class='btn btn-primary btn-sm view-user' 
                                                data-id='{$query['id']}' 
                                                data-name='{$query['name']}' 
                                                data-email='{$query['email']}' 
                                                data-message='{$query['message']}' 
                                                data-role='{$query['role']}'
                                                data-bs-toggle='modal' 
                                                data-bs-target='#exampleModal'>
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                ";
                            }

                        }
                    ?>

                </tbody>
            </table>
        </div>
        <div id="timein" style="display: none;">
            <p style="color: #0000006d; font-weight: 500">Attendance Records(12:00 - 5:00 PM)</p>
            <table style="border-collapse: collapse; width:100%;">
                <thead>
                    <tr>
                        <th style="border:1px solid #ccc; padding:8px; max-width: 25px">ID</th>
                        <th style="border:1px solid #ccc; padding:8px;">Name</th>
                        <th style="border:1px solid #ccc; padding:8px;">Attendance Status</th>
                        <th style="border:1px solid #ccc; padding:8px;">Time in</th>
                        <th style="border:1px solid #ccc; padding:8px;">Time out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        while($present = $presents->fetch_assoc()){

                            if($present['role'] !== 'admin' && $present['is_enrolled'] !== 0){
                                $presentText = ($present['is_in'] == 1) ? 'User Timed-in' : (($present['is_in'] == 2) ? 'User Schedule End' : 'User Not In');
                                $color = ($present['is_in'] == 1) ? 'green' : (($present['is_in'] == 2) ? 'gray' : 'red');
                                echo "
                                    <tr>
                                        <td style='border:1px solid #ccc; padding:8px; max-width: 25px'>{$present['id']}</td>
                                        <td style='border:1px solid #ccc; padding:8px;'>{$present['name']}</td>
                                        <td style='border:1px solid #ccc; padding:8px; color:{$color}'>{$presentText}</td>
                                        <td style='border:1px solid #ccc; padding:8px;'>{$present['time_in']}</td>
                                        <td style='border:1px solid #ccc; padding:8px;'>{$present['time_out']}</td>
                                    </tr>
                                ";
                            }

                        }
                    ?>

                </tbody>
            </table>
        </div>
        <div id="notyettimein" style="display: none;">
            <p style="color: #0000006d; font-weight: 500">Ended Schedule</p>
            <div class="reset-box">
                <button id="reset-sched" class="btn btn-danger">Reset Schedule</button>
                <p>Note: Clicking this button will reset the time-in and time-out records of all users. This action will close the current schedule and immediately start a new scheduling period for everyone. Please ensure all required data is reviewed before proceeding.</p>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function (){
            $('#filterAll').on('change', function (){
                if(this.checked){
                    $('#allrecords').show();
                    $('#timein').hide();
                    $('#notyettimein').hide();
                }
            })
            $('#filterTimeIn').on('change', function (){
                if(this.checked){
                    $('#allrecords').hide();
                    $('#timein').show();
                    $('#notyettimein').hide();
                }
            })
            $('#filterNotTimeIn').on('change', function (){
                if(this.checked){
                    $('#allrecords').hide();
                    $('#timein').hide();
                    $('#notyettimein').show();
                }
            })

            $("#reset-sched").on("click", function () {

                if (!confirm("Reset your attendance for today?")) return;

                $.ajax({
                    url: "../controller/reset_sched.php",
                    type: "POST",
                    success: function (response) {
                        if (response === "success") {
                            alert("Schedule reset successfully");
                            location.reload();
                        } else {
                            alert(response);
                        }
                    }
                });

            });

            
            $(document).on("click", ".view-user", function () {
                const id = $(this).data("id");
                const name = $(this).data("name");
                const email = $(this).data("email");
                const message = $(this).data("message");
                const role = $(this).data("role");

                const modalContent = `
                    <p><b>ID: </b>${id}</p>
                    <p><b>Name: </b>${name}</p>
                    <p><b>Email: </b>${email}</p>
                    <p><b>Enroll Status: </b>${message}</p>
                    <p><b>Role: </b>${role}</p>
                `;
                $(".modal-body").html(modalContent);
            });
            $(document).on("click", ".delete-user", function () {
                if (!confirm("Are you sure you want to delete this user?")) return;

                const userIda = $(this).data("useraid");
                
                $.ajax({
                    url: "../controller/delete_user.php",
                    type: "POST",
                    data: { user_id: userIda },
                    success: function (response) {
                        if (response === "success") {
                            alert("User has been deleted");
                            location.reload();
                        } else {
                            alert(response);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>