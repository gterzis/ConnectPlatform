<?php
// Including required file for connecting to database.
require_once './includes/Connection.php';

// Checks if user has the right to visit page
$sql = $conn->query("SELECT Email, Link FROM reset_password WHERE Link = '" . $_GET['id'] . "'; ");
$row = $sql->fetch_assoc();
if (empty($row['Email'])) {
    header("Location: index.php");
    exit();
}

// When reset button is being clicked.
if (isset($_POST['reset']))
{
    // Checks if passwords contain only letters and numbers.
    if (!ctype_alnum($_POST["pass"]) or ! ctype_alnum($_POST["pass2"])) {
        echo "<script type='text/javascript'>alert('Invalid password');</script>";
    }
    // Checks if Password and Confirm Password are matched.
    elseif ($_POST["pass"] != $_POST["pass2"]) {
        echo "<script type='text/javascript'>alert('Password and Confirm Password do not match');</script>";
    }
    else
    {
        // Updates user's password
        if ($stmt = $conn->prepare("UPDATE users SET Password = ? WHERE Email = ? ")) {
            $stmt->bind_param("ss", $_POST["pass"], $row['Email']);
            $stmt->execute();
            $stmt->close();
        }
        //Sets link as no longer available
        $sql = $conn->query("DELETE FROM reset_password WHERE Email = '" . $row['Email'] . "'; ");
        echo "<script type='text/javascript'>alert('Password has been reset successfully !')
         window.location.href='Login.php'</script>";
        exit();
    }

}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Get in Touch - Login</title>
    <link rel="stylesheet" href="indexStyle.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body style="margin: 0px; background-color: ivory;">

<!--Place error message box-->
<div id="result"></div>

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/head.html"); ?>

<!--RESET FORM-->
<form class="frm frm-login" style="height: 330px;" method="post" action="">

    <h2 style="margin-left: 45px;">Reset Password</h2>

    <!--PASSWORD-->
    <div class="wrap-input wrap-login" style="float: left;">
        <label class="lbl" for="pass">
            <span class="fa fa-lock"></span>
        </label>
        <input class="inp" id="pass" type="password" name="pass" maxlength="25" placeholder="New password" required/>

    </div>

    <!--CONFIRM PASSWORD-->
    <div class="wrap-input wrap-login" style="float: left;">
        <label class="lbl" for="pass2">
            <span class="fa fa-lock"></span>
        </label>
        <input class="inp" id="pass2" type="password" name="pass2" maxlength="25" placeholder="Confirm password" required/>
    </div>

    <button class="btn" name="reset" style="width: 75%; margin: 8px 15px 15px 45px;">RESET PASSWORD</button>
    <a href="Login.php" style="color: #0066cc; text-decoration: none; float: left; margin-left: 35%;">
        <i class="fa fa-arrow-left"></i> Back to login</a>

</form>

</body>
</html>
