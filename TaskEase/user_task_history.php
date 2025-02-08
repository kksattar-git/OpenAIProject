<?php
session_start();

function getUserById($connection, $userId) {
    $query = "SELECT name FROM users WHERE uid = ?";
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userName);
        if (mysqli_stmt_fetch($stmt)) {
            return $userName; 
        } else {
            return null; 
        }
    } else {
        return null;
    }
}


if (isset($_SESSION['email'])) {
    include('includes/connection.php');

    // Get the user ID using the user's email
    $user_email = $_SESSION['email'];
    $uid_query = "SELECT uid FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection, $uid_query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $uid);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    // Proceed only if a user ID is found
    if ($uid) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery file -->
    <script src="includes/jquery_latest.js"></script>
    <!-- Bootstrap files -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- External CSS files -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
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
        .approved-task {
            background-color: #d4edda; 
        }
    </style>
</head>
<body>
    <center><h3>Task History</h3></center><br>
    <table class="table" style="background-color: whitesmoke; width: 75vw;">
        <tr>
            <th>S.No</th>
            <!--<th>Task ID</th>-->
            <th>Title</th>
            <th>Description</th>
            <th>Files</th>
            <th>Current Assigne</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
        <?php
          // Fetch complete tasks assigned to the user
          $completed_tasks_query = "SELECT tasks.*,u.name assigne_name FROM tasks 
                                    LEFT JOIN users u on u.uid = tasks.current_assigne
                                    WHERE tasks.uid = ? AND tasks.status = 'Complete' or tasks.status='Approved'";
          $stmt = mysqli_prepare($connection, $completed_tasks_query);
          mysqli_stmt_bind_param($stmt, "i", $uid);
          mysqli_stmt_execute($stmt);
          $completed_tasks_result = mysqli_stmt_get_result($stmt);
          $sno = 1;

          while ($task_row = mysqli_fetch_assoc($completed_tasks_result)) {
            $isApproved = $task_row['status'] == 'Approved';
              ?>
              <tr class="<?php echo $isApproved ? 'approved-task' : ''; ?>">
                  <td><?php echo $sno; ?></td>
                 <?php /* <td><?php echo $task_row['tid']; ?></td>*/?>
                 <td><?php echo $task_row['title']; ?></td>
                  <td><?php echo $task_row['description']; ?></td>
                  <td>
                      <?php if (!empty($task_row['attachments'])) { ?>
                          <a href="#" class="view-files" data-tid="<?php echo $task_row['tid']; ?>" title="View Files">
                              <i class='fas fa-paperclip fa-lg' style="color: #1874cd;"></i>
                          </a>
                      <?php } ?>
                  </td>
                   <td><?php echo $task_row['assigne_name']; ?></td>
                  <td><?php echo $task_row['start_date']; ?></td>
                  <td><?php echo $task_row['end_date']; ?></td>
                  <td><?php echo $task_row['status']; ?></td>
              </tr>
              <?php
              $sno++;
          }
          mysqli_stmt_close($stmt);
            // Fetch task IDs from task_history based on the user ID
            $history_query = "SELECT DISTINCT tid FROM task_history WHERE from_uid = ? ";
            $stmt = mysqli_prepare($connection, $history_query);
            mysqli_stmt_bind_param($stmt, "i", $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $task_ids = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $task_ids[] = $row['tid'];
            }
            mysqli_stmt_close($stmt);

            // Fetch tasks based on the retrieved task IDs
            if (!empty($task_ids)) {
                $task_ids_placeholder = implode(',', array_fill(0, count($task_ids), '?'));
                $tasks_query = "SELECT tasks.*, u.name assigne_name FROM tasks
                                LEFT JOIN users u on u.uid = tasks.current_assigne
                                WHERE tasks.tid IN ($task_ids_placeholder)
                                ";
                $stmt = mysqli_prepare($connection, $tasks_query);
                mysqli_stmt_bind_param($stmt, str_repeat('i', count($task_ids)), ...$task_ids);
                mysqli_stmt_execute($stmt);
                $tasks_result = mysqli_stmt_get_result($stmt);

                
                while ($task_row = mysqli_fetch_assoc($tasks_result)) {
        ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                       <?php /* <td><?php echo $task_row['tid']; ?></td>*/?>
                        <td><?php echo $task_row['title']; ?> 
                        <td><?php echo $task_row['description']; ?> 
                        <span style="color:red;font-size:10px; margin-left:10px;">Assigned to <?php echo getUserById($connection, $task_row['uid'])?></span>
                    </td>
                        <td>
                       
                            <?php if (!empty($task_row['attachments'])) { ?>
                                <a href="#" class="view-files" data-tid="<?php echo $task_row['tid']; ?>" title="View Files">
                                    <i class='fas fa-paperclip fa-lg' style="color: #1874cd;"></i>
                                </a>
                            <?php } ?>
                        </td>
                        <td><?php echo $task_row['assigne_name']; ?></td>
                        <td ><?php echo $task_row['start_date']; ?></td>
                        <td ><?php echo $task_row['end_date']; ?></td>
                        <td><?php echo $task_row['status']; ?></td>
                    </tr>
        <?php
                    $sno++;
                }
                mysqli_stmt_close($stmt);
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
        });
    </script>
</body>
</html>
<?php
    } else {
        echo "<p>User ID not found.</p>";
    }
} else {
    header('Location: user_login.php');
}
