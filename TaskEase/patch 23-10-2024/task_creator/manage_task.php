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
    <center><h3> My Created Tasks</h3></center><br>
    <table class="table" style="background-color: whitesmoke; width: 75vw;">
        <tr>
            <th>S.no</th>
           <!-- <th>Task ID</th>-->
            <th>Title</th>
            <th>Description</th>
            <th>Comments</th>
            <th>Files</th>
            <th>Current Assigne</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
            $sno = 1;
             $query = "SELECT tasks.*, u.name current_assigne FROM tasks
                        LEFT JOIN users u on u.uid = tasks.current_assigne
                        WHERE (tasks.status = 'Not Started' or tasks.status='In-Progress') and created_by ='".$_SESSION['task_creator_id']."'";
            $query_run = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($query_run)){
                ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                    <?php /*<td><?php echo $row['tid']; ?></td>*/?>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <a href="#" class="view-comments-btn" data-tid="<?php echo $row['tid']; ?>" title="View Comments">
                            <i class='fas fa-download' style="color: #1874cd;"></i>
                        </a>
                    </td>
                    <td>
                    <?php if (!empty($row['attachments'])) { ?>
                        <a href="#" class="view-files" data-tid="<?php echo $row['tid']; ?>" title="View Files">
                            <i class='fas fa-paperclip fa-lg' style="color: #1874cd;"></i>
                        </a>
                    <?php } ?>
                    </td>
                    <td style="font-size:12px;"><?php echo $row['current_assigne']; ?></td>
                    <td style="font-size:12px;"><?php echo $row['start_date']; ?></td>
                    <td style="font-size:12px;"><?php echo $row['end_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><a href="edit_task.php?id=<?php echo $row['tid']; ?>">Edit</a> | <a href="delete_task.php?id=<?php echo $row['tid']; ?>">Delete</a></td>
                </tr>
                <?php
                $sno= $sno+ 1;
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

                // geting comments pdf
            $('.view-comments-btn').on('click', function() {
                const taskId = $(this).data('tid');
                window.open('getComments.php?task_id=' + taskId, '_blank');
            });

                
            });
        </script>
</body>
</html>
<?php
}
else{
    header('Location:admin_login.php');
}