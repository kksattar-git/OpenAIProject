<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskEase</title>
    <!-- jQuery file -->
    <script src="includes\jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="css\styles.css?v=4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <div class="row">
        <div class="container text-center">
            <img src="assets\newlogo.png" class="rounded-image">
            <p class="fw-bold text-white h3"> Task Ease</p>
           
        </div>
    <div class="col-md-6 m-auto border rounded-lg" id="home_page">
    <div class="card border-0 bg-transparent">
    <div class="card-body">
        <h3 class="card-title text-center mb-4">Choose Login Role</h3>
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="user_login.php" class="btn btn-success text-white btn-outline-success btn-block py-4">
                    <i class="fas fa-user mb-2" style="font-size: 2rem;"></i>
                    <br>User Login
                </a>
            </div>
<!--<div class="col-md-4 mb-3">&nbsp;</div>-->
            <!--<div class="col-md-4 mb-3">
                <a href="register.php" class="btn btn-warning text-white btn-outline-warning btn-block py-4">
                    <i class="fas fa-user-plus mb-2" style="font-size: 2rem;"></i>
                    <br>User Registration
                </a>
            </div>-->
            <div class="col-md-4 mb-3">
                <a href="task_creator/admin_login.php" class="btn btn-warning text-white btn-outline-warning btn-block py-4">
                    <i class="fas fa-user-plus mb-2" style="font-size: 2rem;"></i>
                    <br>Task Creator
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="admin/admin_login.php" class="btn btn-info text-white btn-outline-info btn-block py-4">
                    <i class="fas fa-user-shield mb-2" style="font-size: 2rem;"></i>
                    <br>Admin Login
                </a>
            </div>
        </div>
    </div>
</div>

</div>
    </div>
</body>
</html>