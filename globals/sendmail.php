<?php
// Import PHPMailer classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendmail {
    public function sendmail($mailMsg) {
        require 'C:\xampp\htdocs\fnc for php\vendor\autoload.php';
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2; // Debug info
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'omwengaim@gmail.com'; // Your Gmail address
            $mail->Password   = 'Ged!on77'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('ics@gmail.com', 'ICS 2024');
            $mail->addAddress($mailMsg['to_email'], $mailMsg['to_name']);

            $mail->isHTML(true);
            $mail->Subject = $mailMsg['subject'];
            $mail->Body    = nl2br($mailMsg['message']);

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

// Call the sendmail function after the class definition
$mailMsg = [
    'to_email' => 'omwengaim@gmail.com',
    'to_name'  => 'IANNO',
    'subject'  => 'MY SUBJECT IS brooo',
    'message'  => 'What is up brooo'
];

$mailer = new sendmail();
$mailer->sendmail($mailMsg);
