<?php
$interests = $_REQUEST['interests'];
require_once '../../includes/Connection.php';
foreach( $interests as $interest){
    $interest = trim($interest); //removes whitespace from both sides
    $sql = $conn -> query("DELETE FROM interests WHERE InterestName = '".$interest."';");
}

if ($sql){
    echo "success";
}
else{
    echo "fail";
}

$conn->close();
exit();
?>