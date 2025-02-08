<?php
session_start();
include('./includes/connection.php');

if (isset($_POST['lid'])) {
    $leave_id = intval($_POST['lid']);
    $query = "SELECT * FROM leaves WHERE lid = $leave_id";
    $query_run = mysqli_query($connection, $query);

    if ($leave = mysqli_fetch_assoc($query_run)) {
        $attachments = explode(',', $leave['attachments']);
        ?>
        <div class="row">
            <?php foreach ($attachments as $attachment): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text" style="color:black;"><?php echo htmlspecialchars($attachment); ?></p>

                            <!-- Download Button -->
                            <?php 
                            $file_path = './leave_attachments/' . htmlspecialchars($attachment);
                            if (file_exists($file_path)): ?>
                                <a href="download.php?file=<?php echo urlencode($attachment); ?>&type=leave_attachment" 
                                   class="btn btn-success">
                                   <i class="fas fa-download"></i> Download
                                </a>
                            <?php else: ?>
                                <p style="color: red;">File not available on the server</p>
                            <?php endif; ?>

                            <?php
                            // Determine the file type for review options
                            $file_extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
                            // Show the review button only for supported file types (excluding DOCX)
                            if (in_array($file_extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'])): ?>
                                <a href="<?php echo $file_path; ?>" 
                                   class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                                   <i class="fas fa-eye"></i> Review
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    } else {
        echo "<p>No attachments found for this leave application.</p>";
    }
} else {
    echo "<p>No leave ID provided.</p>";
}
?>
