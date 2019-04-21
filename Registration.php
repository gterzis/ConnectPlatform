<?php // called by Register.php

	session_start();

	if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	    //Storing user's input into sessions
	    $_SESSION['name'] = $_POST["name"];
        $_SESSION['surname'] = $_POST["surname"];
        $_SESSION['bday'] = date("Y-m-d", strtotime($_POST["bday"]));
        $_SESSION['district'] = $_POST["district"];
        $_SESSION['education'] = $_POST["education"];
        $_SESSION['occupation'] = $_POST["occupation"];
        $_SESSION['email'] = $_POST["email"];

        //GENDER validation
        if (isset($_POST['gender'])) {
            ($_POST['gender'] == "male") ? $gender = "Male" : $gender = "Female";
            $_SESSION['gender'] = $_POST['gender'];
        }
        else
        {
            $dataErr = base64_encode("Please select your gender");
            header("Location: Register.php?ErrMess=$dataErr&field=Gender");
            exit();
        }

        //NAME validation
        $name = test_input($_POST["name"]);
        //Check if name only contains letters, whitespace and starts with letter.
        if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $name)) {
            $dataErr =  base64_encode("Name: only letters and white space allowed");
            header("Location: Register.php?ErrMess=$dataErr&field=Name");
            exit();
        }

        //LAST NAME validation
        $surname = test_input($_POST["surname"]);
        // Check if last name only contains letters, whitespace and starts with letter.
        if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $surname)) {
            $dataErr = base64_encode("Surname: only letters and white space are allowed");
            header("Location: Register.php?ErrMess=$dataErr&field=Surname");
            exit();
        }

        //DISTRICT validation
        $district = test_input($_POST["district"]);
        // check if address only contains letters, numbers and whitespace
        if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $district)) {
            $dataErr = base64_encode("District: only letters, numbers and  white space are allowed");
            header("Location: Register.php?ErrMess=$dataErr&field=District");
            exit();
        }

        //EDUCATION validation
        $education = test_input($_POST["education"]);
        // check if address only contains letters, numbers and whitespace
        if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $education)) {
            $dataErr = base64_encode("Education: only letters, numbers and  white space are allowed");
            header("Location: Register.php?ErrMess=$dataErr&field=Education");
            exit();
        }

        //OCCUPATION validation
        $occupation = test_input($_POST["occupation"]);
        // check if address only contains letters, numbers and whitespace
        if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $occupation)) {
            $dataErr = base64_encode("Occupation: only letters, numbers and  white space are allowed");
            header("Location: Register.php?ErrMess=$dataErr&field=Occupation");
            exit();
        }

        //EMAIL validation
        $email = strtolower($_POST["email"]); // converting input email to lowercase.
        $email = test_input($email);
        //Check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dataErr = base64_encode("Invalid email format");
            header("Location: Register.php?ErrMess=$dataErr&field=Email");
            exit();
        }

        // PASSWORDS validation
        // Checking if length of password is greater than 7.
        if (strlen($_POST["pass1"]) < 8) {
            $dataErr = base64_encode("Password must has 8 or more characters");
            header("Location: Register.php?ErrMess=$dataErr&field=Password");
            exit();
        }
        // Checking if passwords contain only letters and numbers.
        if (!ctype_alnum($_POST["pass1"]) or !ctype_alnum($_POST["pass2"])) {
            $dataErr = base64_encode("Password must consits of letters, numbers and no space");
            header("Location: Register.php?ErrMess=$dataErr&field=Password");
            exit();
        }
        // Checking if Password and Confirm Password are matched.
        if ($_POST["pass1"] != $_POST["pass2"]) {
            $dataErr = base64_encode("Password and Confirm Password do not match");
            header("Location: Register.php?ErrMess=$dataErr&field=Password");
            exit();
        }
	}
    // If the user has not pressed register button. This prevents users visit this page directly.
    else {
        header("Location: index.php");
        exit();
    }

    function test_input($data)
    {
        $data = trim($data); //removes whitespace from both sides
        $data = stripslashes($data); //removes backslashes
        $data = htmlspecialchars($data);
        return $data;
    }

    // Including required file for connecting to database.
    require_once './includes/Connection.php';

    // Check if email already exists
    if ($stmt = $conn->prepare("(SELECT Email FROM users WHERE Email=? )
                                        UNION 
								       (SELECT Email FROM admins WHERE Email=?)"))
    {

        /* bind parameters for markers */
        $stmt->bind_param("ss", $email,$email);

        /* execute query */
        $stmt->execute();

        /* bind result variables */
        $stmt->bind_result($mail);

        /* fetch value */
        $stmt->fetch();

        if (!empty($mail)) {
            $stmt->close();
            $conn->close();
            $dataErr = base64_encode("Email already exists. Please enter a new one.");
            header("Location: Register.php?ErrMess=$dataErr&field=Email");
            exit();
        }

    }

    // Inserting data into database
    if ($stmt = $conn->prepare("INSERT INTO users
                            (Name, Surname, Birthdate, Gender, District, Education, Occupation, Email, Password, RegistrationDate) 
                             VALUES (?,?,?,?,?,?,?,?,?,?)")) {
        // Bind the variables to the parameters.
        $stmt->bind_param("ssssssssss", $name, $surname, $_SESSION['bday'], $gender, $district, $education, $occupation, $email, $_POST['pass1'], date("Y-m-d") );

        // Execute the statement.
        $stmt->execute();

        // Close the prepared statement.
        $stmt->close();
    }

    $conn->close();

    //Sending welcome email to the user
    require './SendEmail/email_sender.php';

    $subject = "Welcome to Get in Touch";
    $message = "<div style='height: 100px;background-color: #0073b1;top: 0;left: 0; position: relative; width: 100%;'>
                    <p style='margin: 25px 45px;font-family: \"Maiandra GD\";font-size: 45px;color: ivory;display: inline-block;'>Get in Touch</p></a>
                    <p style='float: right; margin: 40px;font-family: \"Maiandra GD\"; font-size: 25px;color: ivory;display: inline-block;'>Meet people with common interests with you</p>
                </div>";
    $message .= "Hello Mr/Ms " . $_POST["last_name"] . " and welcome to Get in Touch !";

//	send_email($email,$subject,nl2br($message));

    header("Location: ./Login/Login.php?registered=success");
    exit();

?>