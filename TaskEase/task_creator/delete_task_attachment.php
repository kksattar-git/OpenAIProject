<?php
include('../includes/connection.php');

if (isset($_POST['filename']) && isset($_POST['task_id'])) {
    $filename = $_POST['filename'];
    $task_id = intval($_POST['task_id']); 
    $filePath = '../task_attachments/' . $filename;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            // Remove filename from the database
            $query = "SELECT attachments FROM tasks WHERE tid = $task_id";
            $result = mysqli_query($connection, $query);
            if ($result && $row = mysqli_fetch_assoc($result)) {
                $attachments = explode(',', $row['attachments']);
                $attachments = array_filter($attachments, function($attachment) use ($filename) {
                    return trim($attachment) !== trim($filename);
                });
                $updatedAttachments = implode(',', $attachments);
                $updateQuery = "UPDATE tasks SET attachments = '$updatedAttachments' WHERE tid = $task_id";
                mysqli_query($connection, $updateQuery);
            }
            echo 'File deleted successfully.';
        } else {
            echo 'Error deleting file.';
        }
    } else {
        echo 'File not found.';
    }
} else {
    echo 'No filename or task ID provided.';
}
?>
