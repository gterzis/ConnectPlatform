<?php

session_start();

//Check if file is called appropriated.
if ( !($_SERVER["REQUEST_METHOD"] == "POST") ){
    header("Location: index.php");
    exit();
}

//NAME validation
$name = test_input($_POST["name"]);
//Check if name only contains letters, whitespace and starts with letter.
if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $name)) {
    echo " Name: only letters and white space allowed";
    ?>
    <script> $("#Name").css("box-shadow", "0 0 5px red");</script>
    <?php
    exit();
}

//LAST NAME validation
$surname = test_input($_POST["surname"]);
// Check if last name only contains letters, whitespace and starts with letter.
if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $surname)) {
    echo " Surname: only letters and white space are allowed";
    ?>
    <script> $("#Surname").css("box-shadow", "0 0 5px red");</script>
    <?php
    exit();
}

//GENDER validation
if ( !empty($_POST["gender"]) ) {
    ($_POST['gender'] == "male") ? $gender = "Male" : $gender = "Female";
}
else
{
    echo " Please select your gender";
    ?>
    <script> $("#Gender").css("box-shadow", "0 0 5px red");</script>
    <?php
    exit();
}

//BIRTHDAY
if (isset($_POST["bday"])) {
    $bday = date("Y-m-d", strtotime($_POST["bday"]));
}

//DISTRICT validation
$district = test_input($_POST["district"]);
// check if address only contains letters, numbers and whitespace
if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $district)) {
    echo" District: only letters, numbers and  white space are allowed";
    ?>
    <script> $("#District").css("box-shadow", "0 0 5px red");</script>
    <?php
    exit();
}

//EDUCATION validation
$education = test_input($_POST["education"]);
// check if address only contains letters, numbers and whitespace
if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $education)) {
    echo " Education: only letters, numbers and  white space are allowed";
    ?>
    <script> $("#Education").css("box-shadow", "0 0 5px red");</script>
    <?php
    exit();
}

//OCCUPATION validation
$occupation = test_input($_POST["occupation"]);
// check if address only contains letters, numbers and whitespace
if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9., ]*[a-zA-Z0-9]$/", $occupation)) {
    echo " Occupation: only letters, numbers and  white space are allowed";
    ?>
    <script> $("#Occupation").css("box-shadow", "0 0 5px red");</script>
    <?php
    exit();
}

//EMAIL validation
$email = strtolower($_POST["email"]); // converting input email to lowercase.
$email = test_input($email);
//Check if e-mail address is well-formed
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo " Invalid email format";
    ?>
    <script> $("#Email").css("box-shadow", "0 0 5px red");</script>
    <?php
    exit();
}

//DESCRIPTION
if (isset($_POST["description"])) {
    $description = test_input($_POST["description"]);
}

//MARITAL STATUS
if (!empty($_POST["maritalStatus"])) {
    $maritalStatus = test_input($_POST["maritalStatus"]);
}

function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslashes
    $data = htmlspecialchars($data);
    return $data;
}

require './includes/Connection.php';

// Check if email already exists
if ($stmt = $conn->prepare("(SELECT Email FROM users WHERE Email=?) 
                                    UNION 
								   (SELECT Email FROM admins WHERE Email=?)")) {

    /* bind parameters for markers */
    $stmt->bind_param("ss", $email,$email);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($mail);

    /* fetch value */
    $stmt->fetch();

    if (!empty($mail))
    {
        if ($_SESSION['user_email'] != $mail)
        {
            $stmt->close();
            $conn->close();
            echo " Email already exists. Please enter a new one.";
            ?>
            <script> $("#Email").css("box-shadow", "0 0 5px red");</script>
            <?php
            exit();
        }
    }

    $stmt->close();
}

//Update user's information
if($stmt = $conn->prepare("UPDATE users SET Name = ?, Surname = ?, Birthdate = ?, Gender = ?, 
									District = ?, Education = ?, Occupation = ?, Description = ?, Email = ?, MaritalStatus = ? WHERE ID = ?"))
{
    $stmt->bind_param("ssssssssssi",$name, $surname, $bday, $gender ,$district, $education, $occupation, $description, $email, $maritalStatus, $_SESSION['user_id'] );
    $stmt->execute();
    $stmt->close();
    $_SESSION['user_email'] = $email;
}

echo "success";
exit();

?>


