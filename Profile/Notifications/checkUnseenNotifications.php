<?php // called by Profile.php
session_start();
require('../../includes/Connection.php');
// check for unseen notifications
$sql = $conn -> query("SELECT * FROM notifications WHERE toUserID = $_SESSION[user_id] AND Seen = 0");
if ($sql->num_rows > 0){
    $numOfNotifications = $sql->num_rows;
    echo $numOfNotifications;
}
else{
    echo "false"; //no unseen notifications
}

$conn -> close();
exit();
