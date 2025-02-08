<?php
session_start();
include('../includes/connection.php');
include('../includes/email_sender.php');

if (isset($_POST['create_task'])) {
    // Prepare the insert statement
    $query = "INSERT INTO tasks (title ,description, start_date, end_date, status,created_by,creator_type) 
              VALUES (?, ?, ?,?, 'Not Started',?,'creator')";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        // Bind parameters and execute
        $uid = $_SESSION['task_creator_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        mysqli_stmt_bind_param($stmt, "ssssi",$title,$description, $start_date, $end_date,$uid);
        $query_run = mysqli_stmt_execute($stmt);

        if ($query_run) {
            $task_id = mysqli_insert_id($connection);
            
            // Handle file uploads
            $time_based_uuid = uniqid('task_', true); 
            $attachments_directory = '../task_attachments/';
            $uploaded_files = [];

            if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
                foreach ($_FILES['attachments']['name'] as $key => $filename) {
                    $file_tmp = $_FILES['attachments']['tmp_name'][$key];
                    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $new_filename = "attachment_" . $time_based_uuid . "_" . ($key + 1) . "." . $file_extension;
                    $file_path = $attachments_directory . $new_filename;

                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $uploaded_files[] = $new_filename;
                    }
                }
            }

            // Update the task with attachment information
            if (!empty($uploaded_files)) {
                $attachments_list = implode(',', $uploaded_files);
                $update_query = "UPDATE tasks SET attachments = ? WHERE tid = ?";
                $update_stmt = mysqli_prepare($connection, $update_query);
                
                if ($update_stmt) {
                    mysqli_stmt_bind_param($update_stmt, "si", $attachments_list, $task_id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                }
            }

            // // Fetch user's email address from the database
            // $user_query = "SELECT email FROM users WHERE uid = ?";
            // $user_stmt = mysqli_prepare($connection, $user_query);
            // mysqli_stmt_bind_param($user_stmt, "i", $uid);
            // mysqli_stmt_execute($user_stmt);
            // mysqli_stmt_bind_result($user_stmt, $user_email);
            // mysqli_stmt_fetch($user_stmt);
            // mysqli_stmt_close($user_stmt);

            // // Send email to the user notifying them of the new task
            // if (!empty($user_email)) {
            //     $subject = "New Task Assigned to You";
            //     $body = "<p>Dear User,</p>
            //              <p>A new task has been created and assigned to you with the following details:</p>
            //              <ul>
            //                 <li><strong>Task Description:</strong> $description</li>
            //                 <li><strong>Start Date:</strong> $start_date</li>
            //                 <li><strong>End Date:</strong> $end_date</li>
            //              </ul>
            //              <p>Please log in to your account to view more details.</p>
            //              <p>Best regards,<br>Task Management Team</p>";

            //     smtpmailer($user_email, $subject, $body);
            // }

            echo "<script>alert('Task created and files uploaded successfully!');</script>";
        } else {
            echo "<script>alert('Failed to create task. Please try again.');</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare the database statement. Please try again.');</script>";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard page</title>
    <!-- jQuery file -->
    <script src="..\includes\jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="..\bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="..\css\styles.css">
    <!-- jQuery code -->
    <script type="text/javascript">
        $(document).ready(function(){
        $("#right_sidebar").load("manage_task.php");
            $("#create_task").click(function(){
                $("#right_sidebar").load("create_task.php");
            });

            $("#view_user_list").click(function(){
                $("#right_sidebar").load("manage_user.php");
            });


    
        });

        $(document).ready(function(){
            $("#manage_task").click(function(){
                $("#right_sidebar").load("manage_task.php");
            });
        });

        $(document).ready(function(){
            $("#verify_task").click(function(){
                $("#right_sidebar").load("verify_task.php");
            });
        });

        $(document).ready(function(){
            $("#view_leave").click(function(){
                $("#right_sidebar").load("view_leave.php");
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
                <!--<tr>
                    <td style="text-align: center;">
                        <a href="admin_dashboard.php" type="button" id="logout_link">Dashboard</a>
                    </td>
                </tr>-->
                <tr>
                    <td style="text-align: center;">
                        <a type="button" class="link" id="manage_task">Manage task</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a type="button" class="link" id="create_task">Create Task</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <a href="../logout.php" type="button" id="logout_link">Logout</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-10" id="right_sidebar">
</div>
    </div>
</body>
</html>