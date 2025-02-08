<?php
session_start();
include('./includes/connection.php');

if (isset($_POST['tid'])) {
    $task_id = intval($_POST['tid']);
    $query = "SELECT * FROM tasks WHERE tid = $task_id";
    $query_run = mysqli_query($connection, $query);

    if ($task = mysqli_fetch_assoc($query_run)) {
        $attachments = explode(',', $task['attachments']);
        ?>
        <div class="row">
            <?php foreach ($attachments as $attachment): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text" style="color:black;"><?php echo htmlspecialchars($attachment); ?></p>
                            
                            <!-- Download Button -->
                            <?php 
                            $file_path = './task_attachments/' . $attachment;
                            if (file_exists($file_path)): ?>
                                <a href="download.php?file=<?php echo urlencode($attachment); ?>&type=task_attachment" 
                                   class="btn btn-success">
                                   <i class="fas fa-download"></i> Download
                                </a>
                            <?php else: ?>
                                <p style="color: red;">File not available on the server</p>
                            <?php endif; ?>

                            <?php
                            $file_extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                            // Show the preview button only for supported file types (not for DOCX)
                            if (in_array($file_extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'])):
                            ?>
                                 <a href="<?php echo $file_path; ?>" 
                                   class="btn btn-info" target="_blank" rel="noopener noreferrer">
                                   <i class="fas fa-eye"></i> Preview
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    } else {
        echo "<p>No attachments found for this task.</p>";
    }
} else {
    echo "<p>No task ID provided.</p>";
}
?>
