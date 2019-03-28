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

// Inserting data into database
if ($stmt = $conn->prepare("INSERT INTO messages (SenderID, ReceiverID, Message) VALUES (?,?,?)")) {
    // Bind the variables to the parameters.
    $stmt->bind_param("iis", $_SESSION['user_id'], $receiverID, $message );

    // Execute the statement.
    $stmt->execute();

    // Close the prepared statement.
    $stmt->close();
}

$conn -> close();
exit();