<?php // called by Matches.php
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}
session_start();
require_once '../includes/Connection.php';
$matchedUserID = $_POST["matchedUserID"];

try {
    //begin a transaction
    $conn->begin_Transaction();

    //Set match between two users as not active. Delete any notifications between users.
    $sql = $conn -> query("UPDATE matches SET Active = 0 WHERE (User1= $_SESSION[user_id] AND User2 = $matchedUserID) OR (User2= $_SESSION[user_id] AND User1 = $matchedUserID)");
    $sql2 = $conn -> query("DELETE FROM notifications WHERE (fromUserID= $_SESSION[user_id] AND toUserID = $matchedUserID) OR (toUserID = $_SESSION[user_id] AND fromUserID = $matchedUserID)");

    // If we arrive here, it means that no exception was thrown
    $conn->commit();
    echo "success";
} catch (Exception $e) {
    // An exception has been thrown. We must rollback the transaction
    $conn->rollback();
    echo "fail";
}

$conn -> close();
exit();
