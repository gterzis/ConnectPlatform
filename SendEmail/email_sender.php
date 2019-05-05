<?php
function send_email($email,$subject,$message){
        require 'PHPMailer-master/PHPMailerAutoload.php';
            
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'george.terzis.16@gmail.com';
        $mail->Password = 'terzis1234';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('george.terzis.16@gmail.com', 'Get In Touch');
        $mail->addAddress($email);
        $mail->isHTML(true);
        
        $mail->Subject = $subject;
        $mail->Body    = $message;
        if(!$mail->send()){
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
			

     return 0;
}



?>
