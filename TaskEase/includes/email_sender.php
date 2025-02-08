<?php
// Handling email
  use PHPMailer\PHPMailer\PHPMailer;
  require __DIR__.'/PHPMailer/src/Exception.php';
  require __DIR__. '/PHPMailer/src/PHPMailer.php';
  require __DIR__.'/PHPMailer/src/SMTP.php';
  
define('GUSER','');
define('GPWD', '');
define('HOST', '');
define('FROM', '');
define('FROMNAME', 'TaskEase');
define('PORT',465);



function smtpmailer($to, $subject, $body) { 
    $mail = new PHPMailer();  
    $mail->IsSMTP(); 
    $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only 0=no debub errors
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host =HOST ;
    $mail->Port =PORT;
    $mail->Username = GUSER;  
    $mail->Password = GPWD;           
    $mail->SetFrom(FROM,FROMNAME);
    $mail->Subject = $subject;
    $mail->AddEmbeddedImage('../assets/logo.png', 'logo');
    $mail->AddEmbeddedImage('../assets/logo.png', 'sender-icon', 'logo.png');
    $mail->Body = $body;
    $mail->isHTML(true);
    $mail->AddAddress($to);
    if($mail->Send()){
        return true;
    }else{
        return false;
    }
    
  }
?>