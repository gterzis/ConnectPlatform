<?php

    require_once '../includes/Connection.php';

    require '../SendEmail/email_sender.php';

    $email = strtolower($_POST['email']); //converting email in lowercase

    $email = test_input($email);

    //Check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "fail";
        exit();
    }

    function test_input($data)
    {
        $data = trim($data); //removes whitespace from both sides
        $data = stripslashes($data); //removes backslashes
        $data = htmlspecialchars($data);
        return $data;
    }

    // Checks if email exists
    $checkEmail=mysqli_query($conn, "SELECT Email FROM users WHERE Email = '$email' ");

    if (mysqli_num_rows($checkEmail) == 1)
    {
        //Get the user's name
        if ($stmt = $conn->prepare("SELECT Name FROM users WHERE Email=?"))
        {
            // bind parameters for markers
            $stmt->bind_param("s",$email);

            // execute query
            $stmt->execute();

            // bind result variables
            $stmt->bind_result($name);

            // fetch value
            $stmt->fetch();

            $stmt->close();

            // Generates a encoded unique number which will be used to reset password.
            $randNum=base64_encode(rand(10000,999999));
            $link = "http://localhost/Local%20Server/ConnectPlatform/ForgottenPassword/resetPass.php?id=$randNum";

            //Insert the unique code into database for the corresponding user.
            if( $stmt = $conn->prepare("INSERT INTO reset_password (Email, Link) VALUES(?,?) ") )
            {
                $stmt->bind_param("ss", $email, $randNum);

                $stmt->execute();

                $stmt->close();
            }

            //Sending email to user with a unique link to reset password
            $subject = "Reset password";
            $message = "<html style='background-color: #9ccff4'>
                            <body>
                                <h1 style='color: #0066cc;'>Get In Touch</h1>
                                <h2 style='color: #0066cc; margin-top: 0;'>Meet people with common interests with you</h2>
                                <p style='font-size: 18px;'>Dear $name, click on the following link to reset your password: $link</p>
                            </body>
                        </html>";
            send_email($email,$subject,$message);
            echo "success";
            exit();
        }
    }
    else
    {
        echo "fail";
        exit();
    }

?>