<?php
include('../includes/connection.php');

if (isset($_POST['department_id'])) {
    $department_id = mysqli_real_escape_string($connection, $_POST['department_id']);
    $query = "SELECT uid, name FROM users WHERE department_id = '$department_id'";
    $result = mysqli_query($connection, $query);

    echo '<option value="">-Select User-</option>'; // Default option
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['uid'] . '">' . $row['name'] . '</option>';
        }
    }
}
?>
