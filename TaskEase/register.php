<?php
    include('includes/connection.php');
    if(isset($_POST['userRegistration'])){
        $query = "insert into users values(null,'$_POST[name]','$_POST[email]','$_POST[password]',$_POST[department_id],$_POST[mobile])";
        $query_run = mysqli_query($connection,$query);
        if($query_run){
            echo "<script type='text/javascript'>
            alert('User registered successfully...');
            window.location.href = 'index.php';
            </script>
            ";
        }
        else{
            echo "<script type='text/javascript'>
            alert('Error...Plz try again.');
            window.location.href = 'register.php';
            </script>
            ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskEase | Registration Page</title>
    <!-- jQuery file -->
    <script src="includes\jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="css\styles.css?v=4">
</head>
<body>
<div class="row">
    <div class="col-md-6 m-auto rounded-lg mb-4" id="register_home_page">
        <h3 class="text-center mb-4" style="background-color: #5A8F7B; padding: 10px; border-radius: 5px; color: white;">User Registration</h3>
        <form action="" method="post" class="mb-4">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" required aria-label="Name">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required aria-label="Email">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required aria-label="Password">
            </div>
            <div class="form-group">
                <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile No." required aria-label="Mobile Number">
            </div>
            <div class="form-group">
                <label for="departmentSelect">Select Department:</label>
                <select class="form-control" name="department_id" id="departmentSelect" required>
                    <option value="">-Select Department-</option>
                    <?php
                        // Fetch the list of departments
                        $dept_query = "SELECT department_id, department_name FROM departments";
                        $dept_result = mysqli_query($connection, $dept_query);
                        if (mysqli_num_rows($dept_result) > 0) {
                            while ($dept_row = mysqli_fetch_assoc($dept_result)) {
                                echo '<option value="' . $dept_row['department_id'] . '">' . $dept_row['department_name'] . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="userRegistration" class="btn btn-warning btn-block py-2">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>
        </form>
        <div class="text-center">
            <a href="index.php" class="btn btn-danger">Go to Home</a>
        </div>
    </div>
</div>

</body>
</html>