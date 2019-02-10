<?php

	session_start();

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//EMAIL validation
	  	if (empty($_POST["email"]))
	  	{
            $error = str_replace(' ', '%20', "Email and password are both required");
            echo $error;
			exit();
	  	}
	  	else
	  	{
	   		$email = test_input($_POST["email"]);
	    	//Check if e-mail address is well-formed
	    	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	    	{
                $error = str_replace(' ', '%20', "Invalid email or password");
                echo $error;
		  		exit();
			}
  		}

        //PASSWORD validation
		if ( empty($_POST["password"]) )
  		{
            $error = str_replace(' ', '%20', "Email and password are both required");
            echo $error;
	  		exit();
  		}
  		else if (!ctype_alnum($_POST["password"]) )
  		{
  		    $error = str_replace(' ', '%20', "Invalid email or password");
	  		echo $error;
	  		exit;
  		}

	}
	 //If the user have not pressed the login button. This prevents users visit this page directly.
	else
	{
		header("Location: SearchUsers.php");
		exit();
	}

	function test_input($data)
	{
	  $data = trim($data); //removes whitespace from both sides
	  $data = stripslashes($data); //removes backslashes
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$email = strtolower($_POST["email"]); // converting letters to lowercase.
    $pass = $_POST["password"];
	require './includes/Connection.php';

	//Identifying user.
	if ($stmt = $conn->prepare("SELECT ID, Email, Password FROM users WHERE Email=? AND Password=?"))
	{
	    /* bind parameters for markers */
	    $stmt->bind_param("ss",$email,$pass);

	    /* execute query */
	    $stmt->execute();

	    /* bind result variables */
	    $stmt->bind_result($id,$user, $pass);

	    /* fetch value */
	    $stmt->fetch();

		if ( !empty($user) AND !empty($pass) )
		{
            $_SESSION['user_id'] = $id;
            $_SESSION['user_pass'] = $pass;
            $_SESSION['user_email'] = $email;
			$stmt->close();
			$conn->close();

			// set cookies if remember me is checked
			if( $_POST["rememberme"] == "true")
			{
				setcookie ("email", $user, time() + (86400 * 30), "/");
				setcookie ("password", $pass, time() + (86400 * 30), "/");
			}
			// unset cookies if remember me is unchecked
			else
			{
				unset($_COOKIE['email']);
    			setcookie('email', null, -1, '/');
    			unset($_COOKIE['password']);
    			setcookie('password', null, -1, '/');
			}

            echo "success";
			exit();
		}
	}

	//Identifying user if is an administrator.
//	if ($stmt = $conn->prepare("SELECT ID, Email, Phone_Number, Password FROM admins WHERE Email=? AND Password=?"))
//	{
//	    /* bind parameters for markers */
//	    $stmt->bind_param("ss",$email,$_POST["password"]);
//
//	    /* execute query */
//	    $stmt->execute();
//
//	    /* bind result variables */
//	    $stmt->bind_result($id,$user,$phone,$pass);
//
//	    /* fetch value */
//	    $stmt->fetch();
//
//		if ( !empty($user) AND !empty($pass) )
//		{
//			$stmt->close();
//			$conn->close();
//			$_SESSION['user_id'] = $id;
//			$_SESSION['user_email'] = $user;
//			$_SESSION['user_phone'] = $phone;
//			$_SESSION['user_pass'] = $pass;
//			$_SESSION['user_admin'] = TRUE;
//
//			// set cookies if remember me is checked
//			if(!empty($_POST["rememberme"]))
//			{
//				setcookie ("user_login", $user, time() + (86400 * 30), "/");
//				setcookie ("user_password", $pass, time() + (86400 * 30), "/");
//			}
//			// unset cookies if remember me is unchecked
//			else
//			{
//				unset($_COOKIE['user_login']);
//    			setcookie('user_login', '', time() - 3600, '/');
//    			unset($_COOKIE['user_password']);
//    			setcookie('user_password', '', time() - 3600, '/');
//			}
//
//			$dataErr = "";
//			header("Location: Management.php");
//			exit();
//		}
//	}

    $error = str_replace(' ', '%20', "Invalid email or password");
    echo $error;
	exit();

