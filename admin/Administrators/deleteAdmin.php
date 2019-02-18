<?php
$admins = $_REQUEST['admins'];
require_once '../../includes/Connection.php';
foreach( $admins as $admin){
    $admin = trim($admin); //removes whitespace from both sides
    $sql = $conn -> query("DELETE FROM admins WHERE Email = '".$admin."';");
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