<?php
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}
session_start();
require_once '../../includes/Connection.php';
$senderID = $_POST["senderID"];

if ($sql = $conn -> query("DELETE FROM matching_requests WHERE SenderID = $senderID AND ReceiverID = $_SESSION[user_id]") )
    echo "success";
else
    echo "fail";

$conn -> close();
exit();