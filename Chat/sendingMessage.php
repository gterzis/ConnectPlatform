<?php // called by Messages.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}

require_once '../includes/Connection.php';
session_start();

$receiverID = $_POST['receiverID']; //get the receiver's id
$message = test_input($_POST['message']);// get the content of the message

function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslashes
    $data = htmlspecialchars($data);
    return $data;
}

//check if there is active match with the user
$sql = $conn -> query("SELECT Active FROM matches WHERE (User1= $_SESSION[user_id] AND User2 = $receiverID AND Active = 1 ) OR (User2= $_SESSION[user_id] AND User1 = $receiverID AND Active = 1 )");
if($sql->num_rows == 0){
    echo "fail";
    $conn->close();
    exit();
}

// Inserting data into database
if ($stmt = $conn->prepare("INSERT INTO messages (SenderID, ReceiverID, Message) VALUES (?,?,?)") AND !empty($message)) {
    // Bind the variables to the parameters.
    $stmt->bind_param("iis", $_SESSION['user_id'], $receiverID, $message );

    // Execute the statement.
    $stmt->execute();

    // Close the prepared statement.
    $stmt->close();

    echo "success";
}

$conn -> close();
exit();