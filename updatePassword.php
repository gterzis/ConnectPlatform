<?php
    session_start();

    // Check if all fields are filled.
    if ( empty($_POST["oldPass"]) OR empty($_POST["newPass"]) OR empty($_POST["confirmPass"]))
    {
        echo " All fields are required";
        exit();
    }
    // Check if old password is correct.
    elseif( $_POST["oldPass"] != $_SESSION["user_pass"])
    {
        echo " Wrong old password";
        exit();
    }
    // Check if length of password is greater than 7.
    elseif (strlen($_POST["newPass"]) < 8) {
        echo " Password must consists of 8 or more characters";
        exit();
    }
    // Check if passwords contain only letters and numbers.
    elseif (!ctype_alnum($_POST["newPass"]) or !ctype_alnum($_POST["confirmPass"]) )
    {
        echo " Invalid password";
        exit();
    }
    // Check if Password and Confirm Password are matched.
    elseif( $_POST["newPass"] != $_POST["confirmPass"]  )
    {
        echo " New password and confirm password do not match";
        exit();
    }
    else
    {
        // Updating password with the new one.
        require ('./includes/Connection.php');

        if($stmt = $conn->prepare("UPDATE users SET Password = ? WHERE ID = ?"))
        {
            $stmt->bind_param("si",$_POST["newPass"], $_SESSION['user_id']);
            $stmt->execute();
            $stmt->close();

            $_SESSION['user_pass'] = $_POST["newPass"];
        }

        $conn->close();
        echo "success";
        exit();
    }
?>