<?php
session_start();
require '../includes/Connection.php';
$interestName = $_POST['name'];
if($sql = $conn->query("DELETE FROM usersinterests WHERE UserID = $_SESSION[user_id] AND InterestName = '$interestName'; ") ) {
    echo "success";
}
else{
    echo "fail";
}