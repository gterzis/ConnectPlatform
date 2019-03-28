<?php // called by userHeader.php
session_start();
require('../../includes/Connection.php');
// check for unseen requests
$sql = $conn -> query("SELECT * FROM matching_requests WHERE ReceiverID = $_SESSION[user_id] AND Seen = 0");

if ($sql->num_rows > 0){
    $numOfRequests = $sql -> num_rows;
    echo $numOfRequests;
}
else{
    echo "false"; // no unseen requests
}

$conn -> close();
exit();
