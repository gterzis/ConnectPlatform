<?php
require '../includes/Connection.php';
session_start();

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
$checkEmail=mysqli_query($conn, "(SELECT Email FROM users WHERE Email= '$email')
                                        UNION 
								       (SELECT Email FROM admins WHERE Email = '$email')");

if (mysqli_num_rows($checkEmail) == 0)
{
    //Update admin's email
    if($stmt = $conn->prepare("UPDATE admins SET Email = ? WHERE AdminID = ?"))
    {
        $stmt->bind_param("si",$email, $_SESSION['user_id'] );
        $stmt->execute();
        $stmt->close();
        $_SESSION['user_email'] = $email;
    }

    echo "success";
    exit();
}
else
{
    echo "fail";
    exit();
}
