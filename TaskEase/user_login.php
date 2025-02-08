<?php 
    session_start();
    include('includes/connection.php');
//echo 123;exit();
    if(isset($_POST['userLogin'])){
        $query = "select email,password,name,uid from users where email = '$_POST[email]' AND password = '$_POST[password]'";
        $query_run = mysqli_query($connection,$query);
        if (mysqli_num_rows($query_run)){
            while($row =mysqli_fetch_assoc($query_run)){
                $_SESSION['email']= $row['email'];
                $_SESSION['name']= $row['name'];
                $_SESSION['uid']= $row['uid'];
            }
            echo "<script type='text/javascript'>
            window.location.href = 'user_dashboard.php';
            </script>
            ";
        }
        else{
            echo "<script type='text/javascript'>
            alert('Please enter correct Email Id and Password.');
            window.location.href = 'user_login.php';
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
    <title>Login Page</title>
    <!-- jQuery file -->
    <script src="includes\jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="css\styles.css?v=6">
</head>
<body>
<div class="row">
    <div class="col-md-4 m-auto rounded-lg" id="login_home_page">
        <h3 class="text-center mb-4" style="background-color: #5A8F7B; padding: 10px; border-radius: 5px; color: white;">User Login</h3>
        <form action="" method="post" class="mb-4">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required aria-label="Email">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required aria-label="Password">
            </div>
            <div class="form-group">
                <button type="submit" name="userLogin" class="btn btn-warning btn-block py-2">
                    <i class="fas fa-sign-in-alt"></i> Login
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