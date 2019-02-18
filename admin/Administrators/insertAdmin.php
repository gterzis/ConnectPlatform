<?php

//EMAIL validation
$email = strtolower($_POST["email"]); // converting input email to lowercase.
$email = test_input($email);
//Check if e-mail address is well-formed
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode($array = array(" Invalid email format", "Email"));//First parameter is the error message and the second one is the erred field.
    exit();
}

// PASSWORDS validation
// Checking if length of password is greater than 7.
if (strlen($_POST["pass1"]) < 8) {
    echo json_encode($array = array(" Password must has 8 or more characters", "Password"));
    exit();
}
// Checking if passwords contain only letters and numbers.
if (!ctype_alnum($_POST["pass1"]) or !ctype_alnum($_POST["pass2"])) {
    echo json_encode($array = array(" Password must consists of letters, numbers and no space", "Password"));
    exit();
}
// Checking if Password and Confirm Password are matched.
if ($_POST["pass1"] != $_POST["pass2"]) {
    echo json_encode($array = array(" Password and Confirm Password do not match","Password"));
    exit();
}

function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslashes
    $data = htmlspecialchars($data);
    return $data;
}

require '../../includes/Connection.php';
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

        echo json_encode($array = array(" Email already exists. Please enter a new one.","Email"));
        exit();
    }

}
else {
    echo " Something went wrong. Try again later";
    $conn->close();
    exit();
}

// Insert new admin
if ($stmt = $conn->prepare("INSERT INTO admins (Email, Password) VALUES (?,?)")) {
    // Bind the variables to the parameters.
    $stmt->bind_param("ss",$email, $_POST['pass1']);

    // Execute the statement.
    $stmt->execute();

    // Close the prepared statement.
    $stmt->close();

    $conn->close();
    echo json_encode("success");
    exit();
}
else {
    echo " Something went wrong. Try again later";
    $conn->close();
    exit();
}




