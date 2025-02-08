<?php
session_start();
require('../includes/connection.php');
require('../includes/pdf/fpdf.php'); 

function getTaskComments($taskId) {
    global $connection;
    $comments = [];

    // Query to fetch comments with user or admin and department information
    $query = "
        SELECT tc.comment, tc.comment_date, tc.from_type, 
               IF(tc.from_type = 'admin', a.name, u.name) AS user_name, 
               IF(tc.from_type = 'admin', '-', d.department_name) AS department_name
        FROM task_comments tc
        LEFT JOIN users u ON tc.uid = u.uid AND tc.from_type = 'user'
        LEFT JOIN admins a ON tc.uid = a.id AND tc.from_type = 'admin'
        LEFT JOIN departments d ON u.department_id = d.department_id
        WHERE tc.task_id = ?
        ORDER BY tc.comment_date DESC
    ";

    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $taskId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $comment, $comment_date, $from_type, $user_name, $department_name);

        // Fetching each comment row
        while (mysqli_stmt_fetch($stmt)) {
            $comments[] = [
                'comment' => $comment,
                'comment_date' => $comment_date,
                'from_type' => $from_type,
                'user_name' => $user_name,
                'department_name' => $department_name
            ];
        }
        mysqli_stmt_close($stmt);
    }

    return $comments;
}

if (isset($_GET['task_id'])) {
    $taskId = (int)$_GET['task_id'];
    $comments = getTaskComments($taskId);



            $query_task = "SELECT * FROM tasks WHERE tid = $taskId";
            $query_run_task = mysqli_query($connection, $query_task);
            $row_task = mysqli_fetch_array($query_run_task);

                



    if (!empty($comments)) {
        class PDF extends FPDF {
            function Header() {
                // Get the width of the page
                $pageWidth = $this->GetPageWidth();
                
                // Logo
                // Calculate logo position to center it
                $logoWidth = 20; // Increased logo size for better visibility
                $logoX = ($pageWidth - $logoWidth) / 2;
               // $this->Image('../assets/newlogo.png', $logoX, 10, $logoWidth);
                $this->Image('../assets/logo-transparent.png', $logoX, 10, $logoWidth);
                
                // Title
                $this->SetFont('Arial', 'B', 15);
                $this->Ln(20); // Move down after logoss
            }

            function MultiCellRow($w, $h, $txt, $border=0, $align='J', $fill=false) {
                $x = $this->GetX();
                $y = $this->GetY();
                $this->MultiCell($w, $h, $txt, $border, $align, $fill);
                $this->SetXY($x + $w, $y);
            }
            
            function Footer() {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 8, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
            }
        } 

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial', 'B', 12);


        // PDF Title
        $pdf->Cell(0, 8, "EXECUTIVE OFFICE OF THE PRESIDENT", 0, 1, 'C');
        $pdf->Ln(2);

        // PDF Title
        $pdf->Cell(0, 0, "BETTING CONTROL AND LICENSING BOARD", 0, 0, 'C');
        $pdf->Ln(5);

        // PDF Title
        $pdf->Cell(0, 0, "ACK Garden Annex 1st Avenue, 7th floor.", 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 8);
        // PDF Title
        $pdf->Cell(0, 0, "Telephone: 0111021400", 0, 1, 'L');
       // $pdf->Ln(5);

        // PDF Title
        $pdf->Cell(0, 0, "P.O. Box 43977-00100,", 0, 1, 'R');
        $pdf->Ln(5);

        // PDF Title
        $pdf->Cell(0, 0, "Email: info@bclb.go.ke", 0, 1, 'L');
       // $pdf->Ln(5);

        // PDF Title
        $pdf->Cell(0, 0, "NAIROBI", 0, 1, 'R');
        $pdf->Ln(5);



        // PDF Title
        $pdf->Cell(0, 10, "Title: ".$row_task['title'], 0, 1, 'C');
        $pdf->Ln(5);

        

        $pdf->SetFont('Arial', '', 10);
        foreach ($comments as $comment) {
            // First row: Date, User, Department (removed borders by setting last parameter to 0)
            $pdf->Cell(60, 7, $comment['comment_date'], 0);
            $pdf->Cell(70, 7, ($comment['from_type'] == 'admin' ? '(Admin) ' : '(User) ') . $comment['user_name'], 0);
            $pdf->Cell(60, 7, ($comment['from_type'] == 'admin' ? '' : $comment['department_name']), 0);
            $pdf->Ln();

            // Second row: Comment (removed border)
            $pdf->MultiCell(0, 7, $comment['comment'], 0);
            $pdf->Ln(5);
        }

        $pdf->Output('D', "Task_Comments_TaskID_$taskId.pdf");
        exit;
    } else {
        echo 'No comments found for this task.';
    }
} else {
    echo 'No task ID provided.';
}
?>