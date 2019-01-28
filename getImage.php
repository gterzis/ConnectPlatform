<?php
$id = $_GET['id'];
// do some validation here to ensure id is safe

require './includes/Connection.php';
$sql = $conn -> query("SELECT Photo FROM users WHERE ID = '".$id."';");
$row = $sql->fetch_assoc();
$conn->close();
header("Content-type: image/*");
echo $row['Photo'];

?>