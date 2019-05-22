<?php
require 'includes/Connection.php';

$hashToStoreInDb = password_hash("12345678", PASSWORD_DEFAULT);


$sql = $conn -> query("UPDATE admins SET Password = '$hashToStoreInDb'");
