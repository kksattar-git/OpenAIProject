<?php
// download.php

// Check if both 'file' and 'type' parameters are set
if (isset($_GET['file']) && isset($_GET['type'])) {
    $filename = basename($_GET['file']);
    $type = $_GET['type'];

    // Determine the folder based on the type parameter
    $folder = '';
    if ($type === 'task_attachment') {
        $folder = './task_attachments/';
    } elseif ($type === 'leave_attachment') {
        $folder = './leave_attachments/';
    } else {
        // Invalid type parameter
        echo "Error: Invalid type specified.";
        exit;
    }

    $file_path = $folder . $filename;

    // Check if the file exists in the selected folder
    if (file_exists($file_path)) {
        // Set the appropriate headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . urlencode($filename));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        // Clear the output buffer
        ob_clean();
        flush();

        // Read the file for download
        readfile($file_path);
        exit;
    } else {
        echo "Error: File not found.";
    }
} else {
    echo "Error: Missing file or type parameter.";
}
?>
