<?php
    session_start();
    if(isset($_SESSION['email'])){
    include('includes/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery file -->
    <script src="includes\jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="bootstrap\css\bootstrap.min.css">
    <script src="bootstrap\js\bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="css\styles.css">
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
    <center><h3>Your tasks</h3></center><br>
    <table class="table" style="background-color: whitesmoke;width:75vw;">
        <tr>
            <th>S.No</th>
            <!--<th>Task ID</th>-->
            <th>Title</th>
            <th>Description</th>
            <th>Files</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
            $query="select * from tasks where uid= $_SESSION[uid] and status='In-Progress' or status='Not Started'";
            $query_run= mysqli_query($connection,$query);
            $sno=1;
            while($row =mysqli_fetch_assoc($query_run)){
                ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                   <?php /* <td><?php echo $row['tid']; ?></td>*/?>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                    <?php if (!empty($row['attachments'])) { ?>
                        <a href="#" class="view-files" data-tid="<?php echo $row['tid']; ?>" title="View Files">
                            <i class='fas fa-paperclip fa-lg' style="color: #1874cd;"></i>
                        </a>
                    <?php } ?>
                    </td>
                    <td ><?php echo $row['start_date']; ?></td>
                    <td ><?php echo $row['end_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                    <?php if ($row['status'] != 'Approved') { ?>
                        <a href="update_status.php?id=<?php echo $row['tid']; ?>">Update</a>
                    <?php } ?>
                    </td>
                </tr>
                <?php
                $sno=$sno+1;
            }
        ?>
    </table>
    <!-- Fullscreen Modal -->
    <div id="attachmentsModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attachmentsModalLabel">Task Attachments</h5>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Attachments will be loaded here -->
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('.view-files').click(function(event) {
                    event.preventDefault(); 
                    var tid = $(this).data('tid');
                    $.ajax({
                        url: 'get_task_attachments.php',
                        method: 'POST',
                        data: { tid: tid },
                        success: function(data) {
                            $('#modalBody').html(data);
                            $('#attachmentsModal').css("display", "block"); 
                        },
                        error: function() {
                            alert('Failed to load attachments. Please try again.');
                        }
                    });
                });

                $('.close').click(function() {
                    $('#attachmentsModal').css("display", "none"); // Hide modal on close
                });

                // Close modal when clicking outside of the modal content
                
            });
        </script>
</body>
</html>
<?php
}
else{
    header('Location:user_login.php');
}