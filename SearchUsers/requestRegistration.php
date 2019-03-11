<?php
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}
session_start();
require_once '../includes/Connection.php';
$receiverID = $_POST["receiverID"];
$commonInterests = $_POST["commonInterests"];
$sql = $conn -> query("SELECT * FROM matching_requests WHERE SenderID = $_SESSION[user_id] AND ReceiverID = $receiverID");
if ($sql -> num_rows > 0 ){
    echo "Already sent request !";
}
else {
    $sql = $conn->query("INSERT INTO matching_requests (SenderID, ReceiverID, CommonInterests) VALUES ($_SESSION[user_id], $receiverID, '".$commonInterests."')");
    echo "success";
}
$conn -> close();
?>
