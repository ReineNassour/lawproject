<?php
include '../db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $attname= $_POST['attname'];
$caseid = $_POST['caseid'];
    
                $sql1 = "UPDATE `case` SET status='Accepted' WHERE id='$caseid'";

            if ($conn->query($sql1)) {
           
    
    $mail = new PHPMailer(true);
   $mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPDebug = 0; // Disable debug output
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'thefirm.contact.leb@gmail.com';
    $mail->Password = 'pisf wxyl nlao xcid';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('thefirm.contact.leb@gmail.com', 'The Firm');
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = 'Case Accepted - Next Steps';

    $mail->Body = '
        <div style="font-family: Arial, sans-serif; padding: 20px; color: #333; line-height: 1.6;">
            <p>Dear <strong>' . htmlspecialchars($name) . '</strong>,</p>
            <p>We are pleased to inform you that your <strong>case has been officially accepted</strong> by TheFirm.</p>
            <p>Our legal team has reviewed the details you submitted and found them compelling. We are now proceeding with the next steps in the process.</p>
            <p>You may now access the <strong>“Track Your Case”</strong> page, where you can monitor progress and view all relevant case details.</p>
            <br>
            <p>Best regards,<br>
            <strong>' . htmlspecialchars($attname) . '</strong><br>
            Legal Administrator<br>
            <span style="color: #555;">TheFirm</span></p>
        </div>
    ';

    $mail->AltBody = "Dear $name,\n\nWe are pleased to inform you that your case has been officially accepted by TheFirm.\n\nOur legal team has reviewed your submission and is moving forward with the process.\n\nYou can now access the 'Track Your Case' page to monitor progress and view all related details.\n\nBest regards,\n$attname\nLegal Administrator\nTheFirm";

    $mail->send();

    header("Location: accepted.php");
    exit();

} catch (Exception $e) {
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}

   
}
}
