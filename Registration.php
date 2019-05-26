<?php // called by Register.php

    //if user visit page improperly
	if (!$_SERVER["REQUEST_METHOD"] == "POST" ) {
        header("Location: index.php");
        exit();
    }
    session_start();

	$_SESSION['email'] = $_POST["email"];// store user's email in a session
    $error = false;

    //GENDER validation
    if (isset($_POST['gender'])) {
        ($_POST['gender'] == "male") ? $gender = "Male" : $gender = "Female";
    }
    else {
        $error = true;
        $output[] = array(
            'field' => "Gender",
            'errorMessage' => "Please select your gender"
        );
    }

    //NAME validation
    $name = test_input($_POST["name"]);
    //Check if name only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $name)) {
        $error = true;
        $output[] = array(
            'field'   => "Name",
            'errorMessage'  => "Name: only letters and white space allowed"
        );

    }

    //LAST NAME validation
    $surname = test_input($_POST["surname"]);
    // Check if last name only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $surname)) {
        $error = true;
        $output[] = array(
            'field'   => "Surname",
            'errorMessage'  => "Surname: only letters and white space are allowed"
        );
    }

    //DISTRICT validation
    $district = test_input($_POST["district"]);
    // check if address only contains letters, numbers and whitespace
    if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $district)) {
        $error = true;
        $output[] = array(
            'field' => "District",
            'errorMessage' => "District: only english letters, numbers and  white space are allowed"
        );
    }

    //EDUCATION validation
    $education = test_input($_POST["education"]);
    // check if address only contains letters, numbers and whitespace
    if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $education)) {
        $error = true;
        $output[] = array(
            'field' => "Education",
            'errorMessage' => "Education: only letters, numbers and  white space are allowed"
        );
    }

    //OCCUPATION validation
    $occupation = test_input($_POST["occupation"]);
    // check if address only contains letters, numbers and whitespace
    if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $occupation)) {
        $error = true;
        $output[] = array(
            'field' => "Occupation",
            'errorMessage' => "Occupation: only letters, numbers and  white space are allowed"
        );
    }

    //EMAIL validation
    $email = strtolower($_POST["email"]); // converting input email to lowercase.
    $email = test_input($email);
    //Check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $output[] = array(
            'field' => "Email",
            'errorMessage' => "Invalid email format"
        );
    }

    // PASSWORDS validation
    // Checking if length of password is greater than 7.
    if (strlen($_POST["pass1"]) < 8) {
        $error = true;
        $output[] = array(
            'field' => "Password",
            'errorMessage' => "Password must has 8 or more characters"
        );
    }
    // Checking if passwords contain only letters and numbers.
    if (!ctype_alnum($_POST["pass1"]) or !ctype_alnum($_POST["pass2"])) {
        $error = true;
        $output[] = array(
            'field' => "Password",
            'errorMessage' => "Password must consists of letters, numbers and no space"
        );
    }
    // Checking if Password and Confirm Password are matched.
    if ($_POST["pass1"] != $_POST["pass2"]) {
        $error = true;
        $output[] = array(
            'field' => "Password",
            'errorMessage' => "Password and Confirm Password do not match"
        );
    }

    //When error occurs
    if ($error){
        echo json_encode($output);
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
            $output[] = array(
                'field' => "Email",
                'errorMessage' => "Email already exists. Please enter a new one."
            );
            echo json_encode($output);
            exit();
        }

    }

    // Hash a new password for storing in the database.
    // The function automatically generates a cryptographically safe salt.
    $hashToStoreInDb = password_hash($_POST['pass1'], PASSWORD_DEFAULT);

    $currentDate = date("Y-m-d");
    // Inserting data into database
    if ($stmt = $conn->prepare("INSERT INTO users
                            (Name, Surname, Birthdate, Gender, District, Education, Occupation, Email, Password, RegistrationDate, LastLogin) 
                             VALUES (?,?,?,?,?,?,?,?,?,?,?)")) {
        // Bind the variables to the parameters.
        $stmt->bind_param("sssssssssss", $name, $surname, $_POST['bday'], $gender, $district, $education, $occupation, $email, $hashToStoreInDb, $currentDate, $currentDate );

        // Execute the statement.
        $stmt->execute();

        // Close the prepared statement.
        $stmt->close();
    }

    $conn->close();

    //Sending welcome email to the user
    require './SendEmail/email_sender.php';

    $subject = "Welcome to Get in Touch";
    $message = "<html style='background-color: #9ccff4'>
                    <body>
                        <h1 style='color: #0066cc;'>Get In Touch</h1>
                        <h2 style='color: #0066cc; margin-top: 0;'>Meet people with common interests with you</h2>
                        <p style='font-size: 18px;'>Hello Mr/Ms " . $_POST["surname"] . " and welcome to Get in Touch !<br><br> Your email in order to log in is: <strong>".$email. "</strong></p>
                    </body>
                </html>";

	send_email($email,$subject,nl2br($message));
    $output[] = array(
        'errorMessage' => "success"
    );
    echo json_encode($output);


?>