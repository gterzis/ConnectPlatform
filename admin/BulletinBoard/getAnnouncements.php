<?php
require '../../includes/Connection.php';
$sql = $conn -> query("SELECT Title, CreationDate FROM bulletin_board ORDER BY CreationDate DESC");
$rows = array();
while($data = mysqli_fetch_assoc($sql))
{
    $creationDate = date( "d-M-Y H:i", strtotime($data['CreationDate']));
    $rows[] = $data['Title'] ." ". "<p style='color: #999999; font-size: 14px;'>". $creationDate ."</p>" ;
}

$conn->close();
echo json_encode($rows);