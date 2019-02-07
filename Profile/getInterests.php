<?php
session_start();
require '../includes/Connection.php';
$sql = $conn -> query("SELECT InterestName FROM usersinterests NATURAL JOIN interests 
                              WHERE UserID ='".$_SESSION['user_id']."';");

while($data = mysqli_fetch_row($sql))
{
    echo "<div class='interest'><p>$data[0]</p><i class='fa fa-trash-o' onclick='deleteInterest(this)'></i></div>";
}

$conn->close();