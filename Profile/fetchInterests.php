<?php
session_start();
require '../includes/Connection.php';
$all = $_GET['all'];

if ($all == "true"){
    //Fetch all interests
    $sql = $conn -> query("SELECT InterestName FROM interests ");
}
else{
    //Fetch all interests except those which user already selected.
    $sql = $conn -> query("SELECT InterestName FROM interests WHERE InterestName NOT IN 
                              (SELECT InterestName FROM usersinterests WHERE UserID = ". $_SESSION['user_id'] .")");
}

$rows = array();
while($r = mysqli_fetch_assoc($sql)) {
    $rows[] = $r['InterestName'];
}

echo json_encode($rows);



