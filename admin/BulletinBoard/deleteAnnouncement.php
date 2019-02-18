<?php
$announs = $_REQUEST['announs'];
require_once '../../includes/Connection.php';
foreach( $announs as $announ){
    $announ = trim($announ); //removes whitespace from both sides
    $sql = $conn -> query("DELETE FROM bulletin_board WHERE Title = '".$announ."';");
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