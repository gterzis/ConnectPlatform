<?php // called by Messages.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}

require_once '../includes/Connection.php';
session_start();

$receiverID = $_POST['receiverID'];
$message = $_POST['message'];

$insertMessage = $conn -> query("INSERT INTO messages (SenderID, ReceiverID, Message) VALUES ($_SESSION[user_id], $receiverID, '".$message."')");

$conn -> close();
exit();