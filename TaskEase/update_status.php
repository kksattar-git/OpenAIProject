<?php
include('includes/connection.php');

if (isset($_POST['update'])) {
    $tid = $_GET['id'];
    $status = $_POST['status'];
    $department_id = !empty($_POST['department_id']) ? (int)$_POST['department_id'] : null;
    $uid = !empty($_POST['uid']) ? (int)$_POST['uid'] : null;
    $new_comment = $_POST['comments'];

    // Fetch the current status, user, and comments of the task
    $task_query = "SELECT uid, status FROM tasks WHERE tid = ?";
    $task_stmt = mysqli_prepare($connection, $task_query);
    mysqli_stmt_bind_param($task_stmt, "i", $tid);
    mysqli_stmt_execute($task_stmt);
    mysqli_stmt_bind_result($task_stmt, $current_uid, $status_before);
    mysqli_stmt_fetch($task_stmt);
    mysqli_stmt_close($task_stmt);

    // Update the task with new status, user, and department if applicable
    $update_query = "UPDATE tasks SET status = ?, uid = ?, department_id = ? WHERE tid = ?";
    $update_stmt = mysqli_prepare($connection, $update_query);
    mysqli_stmt_bind_param($update_stmt, "siii", $status, $uid, $department_id, $tid);
    $query_run = mysqli_stmt_execute($update_stmt);
    mysqli_stmt_close($update_stmt);

    if ($query_run) {
        // Insert the new comment into the task_comments table
        if (!empty($new_comment)) {
            $from_type="user";
            $comment_query = "INSERT INTO task_comments (task_id, uid, comment,from_type) VALUES (?, ?,?, ?)";
            $comment_stmt = mysqli_prepare($connection, $comment_query);
            mysqli_stmt_bind_param($comment_stmt, "iiss", $tid, $uid, $new_comment,$from_type);
            mysqli_stmt_execute($comment_stmt);
            mysqli_stmt_close($comment_stmt);
        }

        $attachments_directory = './task_attachments/';
        $uploaded_files = [];

        // Handle file uploads if there are any
        if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
            $time_based_uuid = uniqid('task_', true);
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

        // Update the task with new attachment information if there are any
        if (!empty($uploaded_files)) {
            $attachments_list = implode(',', $uploaded_files);
            $attachment_update_query = "UPDATE tasks SET attachments = CONCAT(IFNULL(attachments, ''), ',', ?) WHERE tid = ?";
            $attachment_update_stmt = mysqli_prepare($connection, $attachment_update_query);
            mysqli_stmt_bind_param($attachment_update_stmt, "si", $attachments_list, $tid);
            mysqli_stmt_execute($attachment_update_stmt);
            mysqli_stmt_close($attachment_update_stmt);
        }

        if ($current_uid !== $uid) {
            // Log the task update in the task_history table
            $history_query = "INSERT INTO task_history (tid, from_uid, to_uid, reassigned_at, status_before, status_after) 
                              VALUES (?, ?, ?, NOW(), ?, ?)";
            $history_stmt = mysqli_prepare($connection, $history_query);
            mysqli_stmt_bind_param($history_stmt, "iiiss", $tid, $current_uid, $uid, $status_before, $status);
            mysqli_stmt_execute($history_stmt);
            mysqli_stmt_close($history_stmt);


            $update_query2 = "UPDATE tasks SET current_assigne = '".$uid."' WHERE tid = '".$tid."'";
            $update_stmt2 = mysqli_prepare($connection, $update_query2);
           // mysqli_stmt_bind_param($update_stmt2, "siii", $uid, $tid);
            $query_run = mysqli_stmt_execute($update_stmt2);
            mysqli_stmt_close($update_stmt2);





//$update_query = "UPDATE tasks SET status = ?, uid = ?, department_id = ? WHERE tid = ?";
   // $update_stmt = mysqli_prepare($connection, $update_query);
   // mysqli_stmt_bind_param($update_stmt, "siii", $status, $uid, $department_id, $tid);



        }

        echo "<script>alert('Task updated and changes logged successfully!'); window.location.href = 'user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating task. Please try again.'); window.location.href = 'user_dashboard.php';</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status</title>
    <!-- jQuery file -->
    <script src="includes\jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="css\styles.css">
</head>
<body>
    <!-- Header code starts header -->
    <div class="row" id="header">
        <div class="col-md-12">
            <h3><i class="fa fa-solid fa-list" style="padding-right: 15px;"></i>TaskEase</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 m-auto" style="color: white;"><br>
            <h3 style="color: white;">Update the task</h3><br>
            <?php
                $query= "select * from tasks where tid = $_GET[id]";
                $query_run = mysqli_query($connection,$query);
                while($row = mysqli_fetch_assoc($query_run)){
                    ?>
                 <form action="" method="post" class="mb-4" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="id" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                    <label>Select Status:</label>
                        <select class="form-control" name="status">
                            <option disabled>-Select-</option>
                            <option>In-Progress</option>
                            <option>Complete</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Department:</label>
                        <select class="form-control" name="department_id" id="departmentSelect" required>
                            <option value="" disabled>-Select Department-</option>
                            <?php
                            $dept_query = "SELECT department_id, department_name FROM departments";
                            $dept_result = mysqli_query($connection, $dept_query);
                            if (mysqli_num_rows($dept_result) > 0) {
                                while ($dept_row = mysqli_fetch_assoc($dept_result)) {
                                    $selected = ($dept_row['department_id'] == $row['department_id']) ? 'selected' : '';
                                    echo '<option value="' . $dept_row['department_id'] . '" ' . $selected . '>' . $dept_row['department_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select user:</label>
                        <select class="form-control" name="uid" id="userSelect" required>
                            <option>-Select-</option>
                            <?php
                            $query1 = "SELECT uid, name FROM users WHERE uid = {$row['uid']}";
                            $query_run1 = mysqli_query($connection, $query1);
                            if (mysqli_num_rows($query_run1)) {
                                while ($row1 = mysqli_fetch_assoc($query_run1)) {
                                    echo '<option value="' . $row1['uid'] . '" selected>' . $row1['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                <div class="form-group">
                    <label>Attachments:</label>
                    <input type="file" class="form-control" name="attachments[]" multiple>
                </div>
                <div class="form-group">
                    <label>Comments:</label>
                    <textarea class="form-control" rows="3" cols="50" name="comments" placeholder="Leave a Comment"></textarea>
                </div>
                    <input type="submit" class="btn btn-warning" name="update" value="Update">
                </form>
                <?php
                }
            ?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            function toggleFieldsBasedOnStatus() {
                if ($('select[name="status"]').val() === 'Complete') {
                    $('#departmentSelect').closest('.form-group').hide();
                    $('#userSelect').closest('.form-group').hide();
                } else {
                    $('#departmentSelect').closest('.form-group').show();
                    $('#userSelect').closest('.form-group').show();
                }
            }

            toggleFieldsBasedOnStatus();

            $('select[name="status"]').change(function() {
                toggleFieldsBasedOnStatus();
            });

            $('#departmentSelect').change(function() {
                var departmentId = $(this).val();
                if (departmentId != '') {
                    $.ajax({
                        url: './admin/fetch_department_users.php',
                        method: 'POST',
                        data: { department_id: departmentId },
                        success: function(data) {
                            $('#userSelect').html(data);
                        }
                    });
                } else {
                    $('#userSelect').html('<option value="">-Select User-</option>');
                }
            });
        });
    </script>
</body>
</html>