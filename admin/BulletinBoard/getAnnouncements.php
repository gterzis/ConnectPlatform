<?php
require '../../includes/Connection.php';
$sql = $conn -> query("SELECT Title FROM bulletin_board ");
$rows = array();
while($data = mysqli_fetch_row($sql))
{
    $rows[] = $data[0];
}

$conn->close();
echo json_encode($rows);