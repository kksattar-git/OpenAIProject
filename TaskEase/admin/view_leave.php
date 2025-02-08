<?php
session_start();
if (isset($_SESSION['email'])) {
    include('../includes/connection.php');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <title>Leave Applications</title>
    </head>
    <body>
        <center><h3>All Leave Applications</h3></center><br>
        <table class="table" style="background-color: whitesmoke;width:75vw;">
            <tr>
                <th>S.No</th>
                <th>User</th>
                <th>Subject</th>
                <th style="width: 35%;">Message</th>
                <th>Files</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $sno = 1;
            $query = "SELECT * FROM leaves";
            $query_run = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                ?>
                <tr>
                    <td><?php echo $sno; ?></td>
                    <?php
                    $query1 = "SELECT name FROM users WHERE uid= $row[uid]";
                    $query_run1 = mysqli_query($connection, $query1);
                    while ($row1 = mysqli_fetch_assoc($query_run1)) {
                        ?>
                        <td><?php echo htmlspecialchars($row1['name']); ?></td>
                        <?php
                    }
                    ?>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td>
                        <?php if (!empty($row['attachments'])) { ?>
                            <a href="#" class="view-files" data-lid="<?php echo $row['lid']; ?>" title="View Files">
                                <i class='fas fa-paperclip fa-lg' style="color: #1874cd;"></i>
                            </a>
                        <?php } ?>
                    </td>

                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="approve_leave.php?id=<?php echo $row['lid']; ?>">Approve</a> | 
                        <a href="reject_leave.php?id=<?php echo $row['lid']; ?>">Reject</a>
                    </td>
                </tr>
                <?php
                $sno++;
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('.view-files').click(function(event) {
                    event.preventDefault(); // Prevent default anchor click behavior
                    var lid = $(this).data('lid');
                    $.ajax({
                        url: 'get_leave_attachments.php',
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
} else {
    header('Location:admin_login.php');
}
?>
