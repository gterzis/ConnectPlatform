 
<?php
 
    require_once 'PHPMailer-master/PHPMailerAutoload.php';


    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    
    $email='axilleassavva24@gmail.com';
    $pt_ft='Part Time';
    $monthly_hours='45';
    $monthly_salary='4560';
    $date_from='01/01/2017'; 
    $date_to='01/01/2018';
    $sugg='axilleassavva_suggest';
    
    
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'axilleassavva24@gmail.com';                 // SMTP username
    $mail->Password = 'axiLLeas+240';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('axilleassavva24@gmail.com', 'Mailer');     // Add a recipient
    $mail->addAddress($email);               // Name is optional


    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Στοιχεία Καταχωρήσεως';                                                   //Add subject
    $mail->Body    = 'Πιο κάτω φαίνονται τα στοιχεία που καταχωρήθηκαν σχετικά με εσάς:     
    Part Time /Full Time:'.$pt_ft.'/n
    Ώρες ανά μήνα: '.$monthly_hours. '/n
    Μηνιαίος μισθός: '.$monthly_salary.'/n
    Χρονική Περίοδος: Από: '.$date_from.' Μέχρι: '.$date_to. '/n
    Εισηγήσεις/Παρατηρήσεις: '.$sugg.'';

    if(!$mail->send()) 
        {
            echo "Message could not be sent.";
            echo "Mailer Error: " . $mail->ErrorInfo;
        }    
    else 
        {
            echo "Message has been sent";
        }
  
?>