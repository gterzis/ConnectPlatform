<?php
session_start();
require '../includes/Connection.php';
$sql = $conn -> query("SELECT InterestName FROM interests");
$rows = array();
while($r = mysqli_fetch_assoc($sql)) {
    $rows[] = $r['InterestName'];
}

echo json_encode($rows);



