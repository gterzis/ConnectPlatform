<?php
require '../../includes/Connection.php';
$sql = $conn -> query("SELECT * FROM admins ");
$rows = array();
while($data = mysqli_fetch_row($sql))
{
    $rows[] = $data[1];
}

$conn->close();
echo json_encode($rows);