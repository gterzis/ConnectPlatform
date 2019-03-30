<?php
session_start();
require '../includes/Connection.php';
$sql = $conn -> query("SELECT InterestName FROM usersinterests NATURAL JOIN interests 
                              WHERE UserID =$_SESSION[user_id];");

while($data = mysqli_fetch_row($sql))
{
    $numOfMatches = 0;
    //get how many matches has with the the respective interest
    $sql2 = $conn -> query("SELECT * FROM matches WHERE (User1 = $_SESSION[user_id] OR User2 = $_SESSION[user_id]) AND MatchInterest = '".$data[0]."' AND Active = 1;");
    $numOfMatches = mysqli_num_rows($sql2);
    echo "<div class='interest' ><p>$data[0]</p><p style='font-size: 12px; color: #999999;'> <span style='font-size:8px; color: #999999; float: left; padding: 2px 5px;'> &#9679; </span>$numOfMatches</p><i class='fa fa-trash-o' onclick='deleteInterest(this)'></i></div>";
}

$conn->close();