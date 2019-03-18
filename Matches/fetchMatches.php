<?php // called by Matches.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../index.php");
    exit();
}

require_once '../includes/Connection.php';
session_start();
$sql = $conn -> query("SELECT DISTINCT * FROM matches NATURAL JOIN users WHERE (User1= $_SESSION[user_id] AND User2 = users.ID) OR (User2= $_SESSION[user_id] AND User1 = users.ID ) 
                              GROUP BY ID ORDER BY Name ;");

while($data = mysqli_fetch_assoc($sql))
{
    $matchedInterests ="";

    //get the matched interests for each user
    $sql2 = $conn -> query("SELECT MatchInterest FROM matches WHERE (User1= $_SESSION[user_id] AND User2 = $data[ID]) OR (User2= $_SESSION[user_id] AND User1 = $data[ID] )");
    while ($matchInterest = mysqli_fetch_assoc($sql2)){
        $matchedInterests .=  $matchInterest['MatchInterest'].', ';
    }

    $matchedInterests = rtrim($matchedInterests,', ');//remove last comma + space

    //Calculate the age of the user
    $currentDate = new DateTime(date("Y-m-d"));
    $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
    $age = $age->y; // get the year difference

    echo "<hr>
        <div class='result'>

            <img class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' width='25' height=50' >
            <button class='chat-btn' onclick=''> <span class='fa fa-comments' style='font-size: 18px; margin-right: 5px;'></span>Chat</button>
            <button class='deleteUser-btn' onclick='deleteMatch(this);'> <span class='fa fa-user-times' style='font-size: 18px; margin-right: 5px;'></span>Delete</button>

            <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                <p class='userID' hidden>$data[ID]</p>
                <p style='font-weight: bold'> $data[Name] $data[Surname]</p>
                <p style='clear: left;'>$data[District]</p>
                <p style='clear: left;'>$data[Gender] &nbsp;</p>
                <span style='float: left; padding-top: 1px;'> &#9642; </span>
                <p>&nbsp; $age years old</p>
                <p style='clear: left;'>$data[Education] &nbsp;</p>
                <span style='float: left; padding-top: 1px;'> &#9642; </span>
                <p>&nbsp; $data[MaritalStatus]</p>
                <p style='color: #0066cc; clear: both;'>
                    Matched interests:<p class='commonInterests' style='color: #0066cc;'>$matchedInterests</p>
                </p>
            </div>

        </div>";


}
$conn->close();
?>
<script>

    var numOfResults = <?= $sql->num_rows ?>;
    $("#results").prepend("<p style='margin: 0px 0px 15px 15px; color: #b1b1b1;'>"+ numOfResults +" matches</p>");//show the number of results

</script>