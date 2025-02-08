<?php
    session_start();
    include('../includes/connection.php');
    include('../includes/email_sender.php');
    if(isset($_SESSION['email'])){

//print_r($_SESSION);exit();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <!-- jQuery file -->
    <script src="..\includes\jquery_latest.js"></script>
</head>
<body>
    <h3>Create a new Task</h3>
    <div class="row">
        <div class="col-md-6">
        <form action="" method="post" class="mb-4" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" class="form-control" name="title" required  placeholder="Title">
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea class="form-control" rows="3" cols="50" name="description" placeholder="Mention the task"></textarea>
                </div>
                <div class="form-group">
                    <label>Attachments (Optional):</label>
                    <input type="file" class="form-control" name="attachments[]" multiple>
                </div>
                <div class="form-group">
                    <label>Start date:</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="form-group">
                    <label>End date:</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                <input type="submit" class="btn btn-warning" name="create_task" value="Create">
            </form>
        </div>
    </div>
    
</body>
</html>
<?php
}
else{
    header('Location:admin_login.php');
}