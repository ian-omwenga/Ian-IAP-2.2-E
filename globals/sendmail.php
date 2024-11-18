<?php
// Import PHPMailer classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendmail {
    private function generateCode($length = 6) {
        return rand(10 ** ($length - 1), (10 ** $length) - 1); // Generates a random number 
    }

    public function sendmail($mailMsg) {
        require 'C:\xampp\htdocs\fnc for php\vendor\autoload.php';
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0; 
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'omwengaim@gmail.com'; // Your Gmail address
            $mail->Password   = 'jfsm jlmo gxgb xzxy'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('my_email@gmail.com', 'Mailer');
            $mail->addAddress($mailMsg['to_email'], $mailMsg['to_name']);

            $verificationCode = $this->generateCode(); // Generate random verification code

            $mail->isHTML(true);
            $mail->Subject = $mailMsg['subject'];
            $mail->Body    = nl2br("Your verification code is: {$verificationCode}");

            $mail->send();
            echo 'Message has been sent with verification code: ' . $verificationCode;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

// Call the sendmail function 
$mailMsg = [
    'to_email' => 'omwengaim@gmail.com',
    'to_name'  => 'IANNO',
    'subject'  => 'Verification Code',
    'message'  => ''
];

$mailer = new sendmail();
$mailer->sendmail($mailMsg);
