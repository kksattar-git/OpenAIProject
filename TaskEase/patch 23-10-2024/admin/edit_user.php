<?php
session_start();
include('../includes/connection.php');
include('../includes/email_sender.php');
if (isset($_POST['edit_user'])) {//echo 123;exit();
    $task_id = intval($_GET['id']); 
    $admin_id=$_SESSION['admin_id'];

    $query = "UPDATE users SET  name = ?, email = ?, department_id = ? WHERE uid = ?";
    $stmt = mysqli_prepare($connection, $query);
    if ($stmt) {
        $uid = (int)$_POST['id'];
        $department_id = (int)$_POST['department_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = trim($_POST['password']);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $department_id, $uid);
        $query_run = mysqli_stmt_execute($stmt);

        if($password!=''){
            $query2 = "UPDATE users SET  password = '".$password."' WHERE uid = '".$uid."'";
            $stmt2 = mysqli_prepare($connection, $query2);
                $query_run2 = mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);
            }


        if ($query_run) {

             echo "<script>alert('User updated successfully!');</script>";
            echo "<script>window.location.href = 'admin_dashboard.php';</script>";

           } else {
            echo "<script>alert('Failed to update user. Please try again.');</script>";
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
            <h3 style="color: white;">Edit User</h3><br>
            <?php
            $query = "SELECT * FROM users WHERE uid = $_GET[id]";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                <form action="" method="post" enctype="multipart/form-data" class="mb-4">
                    <div class="form-group">
                        <input type="hidden" name="id" class="form-control" value="<?php echo $row['uid']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" name="name" required value="<?php echo $row['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" class="form-control" name="email" required value="<?php echo $row['email']; ?>">
                    </div>
                     <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="password" placeholder=""  value="">
                    </div>

                    <div class="form-group">
                        <label>Select Department:</label>
                        <select class="form-control" name="department_id" id="departmentSelect" required>
                            <option value="">-Select Department-</option>
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
                    
                    
                    
                   
                    <input type="submit" class="btn btn-warning" name="edit_user" value="Update">
                </form>
                <?php
            }
            ?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            
        });
    </script>
</body>
</html>
