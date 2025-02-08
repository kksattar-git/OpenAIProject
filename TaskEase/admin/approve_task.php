<?php
    include('../includes/connection.php');
    $query = "UPDATE tasks SET status = 'Approved' WHERE tid = $_GET[id]";
    $query_run = mysqli_query($connection, $query);
    
    if($query_run){
        echo "<script type='text/javascript'>
            alert('Task status updated to Approved successfully...');
            window.location.href = 'admin_dashboard.php';
            </script>
            ";
    }
    else{
        echo "<script type='text/javascript'>
        alert('Error...Please try again.');
        window.location.href = 'admin_dashboard.php';
        </script>
        ";
    }
?>
