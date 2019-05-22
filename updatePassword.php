<?php
    session_start();
    require ('./includes/Connection.php');

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
        echo " Passwords do not match";
        exit();
    }
    //Update admin's password
    elseif ($_SESSION['user_admin'] == TRUE)
    {
        // Hash a new password for storing in the database.
        // The function automatically generates a cryptographically safe salt.
        $hashToStoreInDb = password_hash($_POST["newPass"], PASSWORD_DEFAULT);

        if($stmt = $conn->prepare("UPDATE admins SET Password = ? WHERE AdminID = ?"))
        {
            $stmt->bind_param("si",$hashToStoreInDb, $_SESSION['user_id']);
            $stmt->execute();
            $stmt->close();

            $_SESSION['user_pass'] = $_POST["newPass"];
        }

        $conn->close();
        echo "success";
        exit();
    }
    //Update user's password
    else
    {
        // Hash a new password for storing in the database.
        // The function automatically generates a cryptographically safe salt.
        $hashToStoreInDb = password_hash($_POST["newPass"], PASSWORD_DEFAULT);

        if($stmt = $conn->prepare("UPDATE users SET Password = ? WHERE ID = ?"))
        {
            $stmt->bind_param("si",$hashToStoreInDb, $_SESSION['user_id']);
            $stmt->execute();
            $stmt->close();

            $_SESSION['user_pass'] = $_POST["newPass"];
        }

        $conn->close();
        echo "success";
        exit();
    }
?>