<?php
session_start();
if (isset($_SESSION['email'])) {
    include('includes/connection.php');

    if (isset($_POST['submit_leave'])) {
        $subject = mysqli_real_escape_string($connection, $_POST['subject']);
        $message = mysqli_real_escape_string($connection, $_POST['message']);
        
        $query = "INSERT INTO leaves (uid, subject, message, status) VALUES ('$_SESSION[uid]', '$subject', '$message', 'No Action')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $leave_id = mysqli_insert_id($connection);
            $attachments_directory = 'leave_attachments/'; // Ensure this path is correct
            $uploaded_files = [];

            if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
                foreach ($_FILES['attachments']['name'] as $key => $filename) {
                    $file_tmp = $_FILES['attachments']['tmp_name'][$key];
                    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $new_filename = "leave_attachment_" . $leave_id . "_" . ($key + 1) . "." . $file_extension;
                    $file_path = $attachments_directory . $new_filename;

                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $uploaded_files[] = $new_filename; // Store the filename for database entry
                    } else {
                        echo "<script>alert('Error uploading file: " . htmlspecialchars($filename) . "');</script>";
                    }
                }
            }

            if (!empty($uploaded_files)) {
                $attachments_list = implode(',', $uploaded_files);
                $update_query = "UPDATE leaves SET attachments = '$attachments_list' WHERE lid = '$leave_id'";
                mysqli_query($connection, $update_query);
            }

            // Success alert
            echo "<script type='text/javascript'>
            alert('Form submitted successfully...');
            window.location.href = 'user_dashboard.php';
            </script>";
        } else {
            // Error alert
            echo "<script type='text/javascript'>
            alert('Error...Please try again.');
            window.location.href = 'user_dashboard.php';
            </script>";
        }
    }
} else {
    // Redirect if not logged in
    header('Location: admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User dashboard page</title>
    <!-- jQuery file -->
    <script src="includes\jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="css\styles.css?v=6">
    <script type="text/javascript">
        $(document).ready(function(){

$("#right_sidebar").load("user_task_history.php");

            $("#manage_task").click(function(){
                $("#right_sidebar").load("task.php");
            });
        });

        $(document).ready(function(){
            $("#user_task_history").click(function(){
                $("#right_sidebar").load("user_task_history.php");
            });
        });

        $(document).ready(function(){
            $("#apply_leave").click(function(){
                $("#right_sidebar").load("leaveForm.php");
            });
        });

        $(document).ready(function(){
            $("#leave_status").click(function(){
                $("#right_sidebar").load("leave_status.php");
            });
        });
    </script>
</head>
<body>
    <!-- Header code starts here -->
    <div class="row" id="header">
        <div class="col-md-12">
            <div class="col-md-4" style="display: inline-block;">
                <h3>TaskEase</h3>
            </div>
            <div class="col-md-6" style="display: inline-block; text-align: right;">
                <b>Email: </b> <?php echo $_SESSION['email']; ?>
                <span style="margin-left: 25px;"><b>Name: </b><?php echo $_SESSION['name']; ?></span>
            </div>
        </div>
    </div>
    <!-- Header code ends here -->
    <div class="row">
        <div class="col-md-2" id="left_sidebar">
            <table class="table">
               <!-- <tr>
                    <td style="text-align: center;">
                        <a href="user_dashboard.php" type="button" id="logout_link">Dashboard</a>
                    </td>
                </tr>-->
                <tr>
                    <td style="text-align: center;">
                        <a type="button" class="link" id="user_task_history">Dashboard</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a type="button" class="link" id="manage_task">Update Task</a>
                    </td>
                </tr>
                <!--<tr>
                    <td style="text-align: center;">
                        <a type="button" class="link" id="user_task_history">Task History</a>
                    </td>
                </tr>-->
                <tr>
                    <td style="text-align: center;">
                        <a type="button" class="link" id="apply_leave">Apply leave</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a type="button" class="link" id="leave_status">Leave status</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a href="logout.php" type="button" id="logout_link">Logout</a>
                    </td>
                </tr>
            </table>
        </div>
<div class="col-md-10" id="right_sidebar">
    <div class="card bg-transparent border-0 h-100">
        <div class="row no-gutters">
            <div class="col-md-6">
                <div class="card-body">
                    <h4 class="card-title mb-4">Instructions for Employees</h4>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <div class="d-flex">
                                <span class="badge badge-primary badge-pill mr-3 align-self-center">1</span>
                                <span>All employees should mark their attendance daily.</span>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex">
                                <span class="badge badge-primary badge-pill mr-3 align-self-center">2</span>
                                <span>Everyone must complete their assigned tasks.</span>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex">
                                <span class="badge badge-primary badge-pill mr-3 align-self-center">3</span>
                                <span>Kindly maintain decorum of the office.</span>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex">
                                <span class="badge badge-primary badge-pill mr-3 align-self-center">4</span>
                                <span>Keep the office and your area neat and clean.</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <img src="./assets/skill1.png"  alt="Office environment" class="img-fluid ">
            </div>
        </div>
    </div>
</div>
    </div>
</body>
</html>
<?php

?>