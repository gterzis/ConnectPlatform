<?php // called by userHeader.php
session_start();
require('../includes/Connection.php');
// check for unseen requests
$sql = $conn -> query("SELECT Seen FROM messages WHERE ReceiverID = $_SESSION[user_id] AND Seen = 0");

if ($sql->num_rows > 0){
    $numOfMessages = $sql -> num_rows;
    echo $numOfMessages;
}
else{
    echo "false"; // no unseen requests
}

$conn -> close();
exit();