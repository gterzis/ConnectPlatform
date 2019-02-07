<?php
session_start();
require '../includes/Connection.php';
$interests = $_REQUEST['interestsArray'];
foreach( $interests as $interest){
    $sql = $conn -> query("INSERT INTO usersinterests (UserID, InterestName) VALUES ('".$_SESSION['user_id']."','". $interest ."' )");
}

if ($sql){
    echo "success";
}
else{
    echo "fail";
}