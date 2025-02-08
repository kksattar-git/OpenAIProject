<?php
    session_start();
    if(isset($_SESSION['email'])){
    include('../includes/connection.php');
?>
<html>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
            body {
                font-family: Arial, sans-serif;
            }
          
            
            .modal {
                display: none; 
                position: fixed; 
                z-index: 1; 
                left: 0;
                top: 0;
                width: 100%; 
                height: 100%; 
                overflow: auto; 
                background-color: rgba(0, 0, 0, 0.7); 
            }

            .modal-content {
                background-color: #fefefe;
                margin: 15% auto; 
                padding: 20px;
                border: 1px solid #888;
                width: 80%; 
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .modal-title {
                margin: 0;
                color: black;
            }

            .close {
                cursor: pointer;
                color: #aaa;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
    </head>
<body>
    <center><h3>All Users</h3></center><br>
    <table class="table" style="background-color: whitesmoke; width: 75vw;">
        <tr>
            <th>S.no</th>
           <!-- <th>Task ID</th>-->
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Mobile</th>
            <th>Action</th>
        </tr>
        <?php
            $sno = 1;
            $query = "SELECT users.*, d.department_name FROM users
                        LEFT JOIN departments d on d.department_id = users.department_id";
            $query_run = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($query_run)){
                ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                    <?php /*<td><?php echo $row['tid']; ?></td>*/?>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td style="font-size:12px;"><?php echo $row['department_name']; ?></td>
                    <td style="font-size:12px;"><?php echo $row['mobile']; ?></td>
                    <td><a href="edit_user.php?id=<?php echo $row['uid']; ?>">Edit</a> </td>
                </tr>
                <?php
                $sno= $sno+ 1;
            }
        ?>
    </table>

    

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        </body>
</html>
<?php
}
else{
    header('Location:admin_login.php');
}