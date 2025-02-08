<?php
    session_start();
    if(isset($_SESSION['email'])){
    include('includes/connection.php');
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
    <center><h3>Your leave applications</h3></center><br>
    <table class="table" style="background-color: whitesmoke;width:75vw;">
        <tr>
            <th>S.No</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Files</th>
            <th>Status</th>
        </tr>
        <?php
            $query="select * from leaves where uid=$_SESSION[uid]";
            $query_run=mysqli_query($connection,$query);
            $sno=1;
            while($row =mysqli_fetch_assoc($query_run)){
                ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td>
                        <?php if (!empty($row['attachments'])) { ?>
                            <a href="#" class="view-files" data-lid="<?php echo $row['lid']; ?>" title="View Files">
                                <i class='fas fa-paperclip fa-lg' style="color: #1874cd;"></i>
                            </a>
                        <?php } ?>
                    </td>
                    <td><?php echo $row['status']; ?></td>
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
                    <h5 class="modal-title" id="attachmentsModalLabel">Leave Attachments</h5>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Attachments will be loaded here -->
                </div>
            </div>
        </div>
    <script>
            $(document).ready(function() {
                $('.view-files').click(function(event) {
                    event.preventDefault(); 
                    var lid = $(this).data('lid');
                    $.ajax({
                        url: './admin/get_leave_attachments.php',
                        method: 'POST',
                        data: { lid: lid },
                        success: function(data) {
                            $('#modalBody').html(data);
                            $('#attachmentsModal').css("display", "block"); // Show modal
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
                $(window).click(function(event) {
                    if ($(event.target).is('#attachmentsModal')) {
                        $('#attachmentsModal').css("display", "none");
                    }
                });
            });
        </script>
</body>
</html>
<?php
}
else{
    header('Location:user_login.php');
}