<?php // called by Matches.php
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}
session_start();
require_once '../includes/Connection.php';
$matchedUserID = $_POST["matchedUserID"];

if ($sql = $conn -> query("DELETE FROM matches WHERE (User1= $_SESSION[user_id] AND User2 = $matchedUserID) OR (User2= $_SESSION[user_id] AND User1 = $matchedUserID );") )
    echo "success";
else
    echo "fail";

$conn -> close();
exit();
