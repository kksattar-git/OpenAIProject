<?php
session_start();
include('../includes/connection.php');
include('../includes/email_sender.php');
if (isset($_POST['edit_task'])) {//echo 123;exit();
    $task_id = intval($_GET['id']); 
    $admin_id=$_SESSION['admin_id'];

    $query = "UPDATE tasks SET  title= '".$_POST['title']."', description = ?, start_date = ?, end_date = ? WHERE tid = ?";
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        $uid = (int)$_POST['id'];
        $department_id = (int)$_POST['department_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $comments = $_POST['comments'];
        mysqli_stmt_bind_param($stmt, "sssi", $description, $start_date, $end_date, $task_id);
//echo $stmt;exit();  
        $query_run = mysqli_stmt_execute($stmt);

        if ($query_run) {

        
            $attachments_directory = '../task_attachments/';
            $uploaded_files = [];

            if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
                foreach ($_FILES['attachments']['name'] as $key => $filename) {
                    $file_tmp = $_FILES['attachments']['tmp_name'][$key];
                    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $new_filename = "attachment_" . uniqid('task_', true) . "_" . ($key + 1) . "." . $file_extension;
                    $file_path = $attachments_directory . $new_filename;

                    if (move_uploaded_file($file_tmp, $file_path)) {
                        $uploaded_files[] = $new_filename;
                    }
                }
            }

            // Update the task with attachment information
            if (!empty($uploaded_files)) {
                // Fetch existing attachments
                $current_attachments_query = "SELECT attachments FROM tasks WHERE tid = ?";
                $current_attachments_stmt = mysqli_prepare($connection, $current_attachments_query);
                mysqli_stmt_bind_param($current_attachments_stmt, "i", $task_id);
                mysqli_stmt_execute($current_attachments_stmt);
                mysqli_stmt_bind_result($current_attachments_stmt, $current_attachments);
                mysqli_stmt_fetch($current_attachments_stmt);
                mysqli_stmt_close($current_attachments_stmt);

                // Combine existing attachments with new uploads
                $existing_files = explode(',', $current_attachments);
                $attachments_list = array_merge($existing_files, $uploaded_files);
                $updated_attachments = implode(',', $attachments_list);

                // Update the attachments in the database
                $update_query = "UPDATE tasks SET attachments = ? WHERE tid = ?";
                $update_stmt = mysqli_prepare($connection, $update_query);
                if ($update_stmt) {
                    mysqli_stmt_bind_param($update_stmt, "si", $updated_attachments, $task_id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                }
            }

            // Fetch user's email address from the database
          /*  $user_query = "SELECT email FROM users WHERE uid = ?";
            $user_stmt = mysqli_prepare($connection, $user_query);
            mysqli_stmt_bind_param($user_stmt, "i", $uid);
            mysqli_stmt_execute($user_stmt);
            mysqli_stmt_bind_result($user_stmt, $user_email);
            mysqli_stmt_fetch($user_stmt);
            mysqli_stmt_close($user_stmt);
          */

            // Send email to the user notifying them of the new task
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

            //    if(smtpmailer($user_email, $subject, $body)){
            //     echo "<script>alert('Task updated successfully!');</script>";
            //    } else{
            //     echo "<script>alert('Error Sending Email');</script>";
            //    }
            // }

            echo "<script>alert('Task updated successfully!');</script>";
            echo "<script>window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to update task. Please try again.');</script>";
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
    <title>Edit Task</title>
    <script src="../includes/jquery_latest.js"></script>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

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
    <div class="row">
        <div class="col-md-4 m-auto" style="color: white;"><br>
            <h3 style="color: white;">Edit the task</h3><br>
            <?php
            $query = "SELECT * FROM tasks WHERE tid = $_GET[id]";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                <form action="" method="post" enctype="multipart/form-data" class="mb-4">
                    <div class="form-group">
                        <input type="hidden" name="id" class="form-control" value="<?php echo $row['uid']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" class="form-control" name="title" required value="<?php echo $row['title']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea class="form-control" rows="3" cols="50" name="description" required><?php echo $row['description']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Attachments (Optional):</label>
                        <div id="attachmentList">
                            <?php
                            $attachments = explode(',', $row['attachments']);
                            $task_id = $row['tid']; // Assuming $row contains the task data
                            foreach ($attachments as $attachment) {
                                echo '<div class="mb-2 d-flex justify-content-between align-items-center">
                                        <span>' . htmlspecialchars($attachment) . '</span>
                                        <button type="button" class="btn btn-danger btn-sm delete-attachment" data-filename="' . htmlspecialchars($attachment) . '" data-task-id="' . $task_id . '">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>';
                            }
                            ?>
                        </div>
                        <input type="file" class="form-control" name="attachments[]" multiple>
                    </div>
                    <div class="form-group">
                        <label>Start date:</label>
                        <input type="date" class="form-control" name="start_date" value="<?php echo $row['start_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>End date:</label>
                        <input type="date" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>" required>
                    </div>
                    <input type="submit" class="btn btn-warning" name="edit_task" value="Update">
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            // deleting attachment
            $(document).on('click', '.delete-attachment', function() {
                var filename = $(this).data('filename');
                var taskId = $(this).data('task-id'); // Get task ID
                var attachmentElement = $(this).closest('.mb-2');

                if (confirm('Are you sure you want to delete this attachment?')) {
                    attachmentElement.remove();

                    $.ajax({
                        url: 'delete_task_attachment.php',
                        type: 'POST',
                        data: { filename: filename, task_id: taskId }, // Include task ID
                        success: function(response) {
                            alert('Attachment deleted successfully.');
                        },
                        error: function() {
                            alert('Error deleting attachment. Please try again.');
                        }
                    });
                }
            });

        });
    </script>
</body>
</html>
