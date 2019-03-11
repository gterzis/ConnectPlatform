<?php
$interests = $_REQUEST['interests'];
require_once '../../includes/Connection.php';
foreach( $interests as $interest){
    $interest = trim($interest); //removes whitespace from both sides
    // check if interest is already selected by a user. Selected interests can't be deleted.
    $sql = $conn -> query("SELECT * FROM usersinterests WHERE InterestName = '".$interest."'");
    if ($sql->num_rows > 0){
        echo $interest;
        exit();
    }
    else
        $sql = $conn -> query("DELETE FROM interests WHERE InterestName = '".$interest."';");
}
$conn->close();
if ($sql){
    echo "success";
    exit();
}
else{
    echo "fail";
    exit();
}

?>