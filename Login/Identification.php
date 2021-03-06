<?php

	session_start();
    //If the user have not pressed the login button. This prevents users visit this page directly.
    if (!$_SERVER["REQUEST_METHOD"] == "POST") {
        header("Location: ../index.php");
        exit();
    }
    // include userLogin class for input validation
    require_once ('userLogin.php');

    $email = $_POST["email"];
    $password = $_POST["password"];
    $userLogin = new userLogin($email, $password); // initialize object
    $userLogin ->checkEmail(); // email validation
    $userLogin ->checkPassword(); // password validation
    $email = $userLogin->email; // get back the processed email
    $password = $userLogin->password;// get back the processed password

	require '../includes/Connection.php';

	//Identifying user. BINARY in WHERE clause is to force case sensitivity
	if ($stmt = $conn->prepare("SELECT ID, Email, Password FROM users WHERE BINARY Email=? "))
	{
	    /* bind parameters for markers */
	    $stmt->bind_param("s",$email);

	    /* execute query */
	    $stmt->execute();

	    /* bind result variables */
	    $stmt->bind_result($id,$user, $pass);

	    /* fetch value */
	    $stmt->fetch();

	    //checking if the encoded password from database matches with the password user has entered.
        $isPasswordCorrect = password_verify($password, $pass);

		if ($isPasswordCorrect )
		{
            //set Sessions
            $_SESSION['user_id'] = $id;
            $_SESSION['user_pass'] = $password;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_admin'] = FALSE;
			$stmt->close();

            // set cookies

            setCookies($user, $password);

            //Update last login
            $today = date("Y-m-d");
            $lastLogin = $conn -> query("UPDATE users SET LastLogin = '$today' WHERE ID = $id");

            $conn->close();
            echo "success";
			exit();
		}
	}

	//Identifying user if is an administrator.
	if ($stmt = $conn->prepare("SELECT AdminID, Email, Password FROM admins WHERE BINARY Email=?"))
	{
	    /* bind parameters for markers */
	    $stmt->bind_param("s",$email);

	    /* execute query */
	    $stmt->execute();

	    /* bind result variables */
	    $stmt->bind_result($id,$user, $pass);

	    /* fetch value */
	    $stmt->fetch();

        //checking if the encoded password from database matches with the password user has entered.
        $isPasswordCorrect = password_verify($password, $pass);

		if ($isPasswordCorrect)
		{
			//set Sessions
			$_SESSION['user_id'] = $id;
			$_SESSION['user_email'] = $user;
			$_SESSION['user_pass'] = $password;
			$_SESSION['user_admin'] = TRUE;

            $stmt->close();
            $conn->close();

            // set cookies
            setCookies($user, $password);

            echo "admin";
            exit();
		}
	}

    //COOKIES
	function setCookies($user, $pass)
    {
        // set cookies if remember me is checked
        if( $_POST["rememberme"] == "true")
        {
            setcookie ("email", $user, time() + (86400 * 30), "/"); //Expires in 30 days
            setcookie ("password", $pass, time() + (86400 * 30), "/"); //Expires in 30 days
        }
        // unset cookies if remember me is unchecked
        else
        {
            unset($_COOKIE['email']);
            setcookie('email', null, -1, '/');
            unset($_COOKIE['password']);
            setcookie('password', null, -1, '/');
        }
    }

    $error = str_replace(' ', '%20', "Invalid email or password");
    echo $error;
	exit();

