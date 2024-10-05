<?php
//Import PHPMailer classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendmail{

//Top of page
public function sendmail($mailMsg){

    //Load Composer's autoloader
    require 'plugins/PHPMailer/vendor/autoload.php';

  
    $mail = new PHPMailer(true);

    try {
      
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'gmomanyian@gmail.com';                    
        $mail->Password   = '12345678';                               
        $mail->Password   = '';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = 465;                                    

        //Recipients
        $mail->setFrom('ics@gmail.com', 'ICS 2024');
        $mail->addAddress($mailMsg['to_email'], $mailMsg['to_name']);     

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $mailMsg['subject'];
        $mail->Body    = nl2br($mailMsg['message']);

        $mail->send();

        echo 'Message has been sent';

    } catch (Exception $e) {
        die("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}