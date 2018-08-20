<?php
require_once(INC_DIR.DS."PHPMailer/PHPMailerAutoload.php");
$Mailer = new PHPMailer();

class Email {
  
    //Sends email using SMTP credentials
    public function send($to="", $subject="", $message="") {
       global $Mailer, $SMTP, $Settings;
 
       $Mailer->isSMTP();
       $Mailer->Host     = $Settings->smtp_host();
       $Mailer->Port     = $Settings->smtp_port();
       $Mailer->SMTPAuth = true;
       $Mailer->Username = $Settings->smtp_user_name();
       $Mailer->Password = $Settings->smtp_password();
       $Mailer->SMTPSecure = 'tls';  
       
       $Mailer->FromName = $Settings->site_name();
       $Mailer->From     = $Settings->site_email_address();
       $Mailer->addAddress($to);
       $Mailer->WordWrap = 50;
       $Mailer->isHTML(true);
       $Mailer->Subject  = $subject;
       $Mailer->Body     = $message;
       $Mailer->AltBody  = strip_tags($message);
       
       return ($Mailer->send()) ? true : false;   
    }
}

$Email = new Email();
?>