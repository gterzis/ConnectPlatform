<?php // called by Interests.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../index.php");
    exit();
}

require_once '../includes/Connection.php';
session_start();
$sql = $conn -> query("SELECT DISTINCT * FROM matches NATURAL JOIN users WHERE (User1= $_SESSION[user_id] AND User2 = users.ID AND Active=1) OR (User2= $_SESSION[user_id] AND User1 = users.ID AND Active=1 ) 
                              GROUP BY ID ORDER BY MatchDate DESC;");

while($data = mysqli_fetch_assoc($sql))
{
    $matchedInterests ="";// storage for the names of the matched interests

    //get the matched interests for each user
    $sql2 = $conn -> query("SELECT MatchInterest FROM matches WHERE (User1= $_SESSION[user_id] AND User2 = $data[ID] AND Active=1 ) OR (User2= $_SESSION[user_id] AND User1 = $data[ID] AND Active=1)");
    while ($matchInterest = mysqli_fetch_assoc($sql2)){
        $matchedInterests .=  $matchInterest['MatchInterest'].', ';
    }

    $matchedInterests = rtrim($matchedInterests,', ');//remove last comma + space

    //Calculate the age of the user
    $currentDate = new DateTime(date("Y-m-d"));
    $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
    $age = $age->y; // get the year difference

    // encode user's id in order to pass it to url for the chat page
    $encodedID = base64_encode($data['ID']);

    //format match date
    $matchDate = date("d-M-Y", strtotime($data['MatchDate']));
    echo "
        <div style='margin: 0px 0px 5px 0px; font-size: 14px; color: #cccccc; text-align: right; width: 94%;'>Match date: $matchDate</div>
        <hr>
        <div class='result'>

            <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' width='25' height=50' >
            <button class='chat-btn' onclick='location.href=\"../../ConnectPlatform/Chat/Messages.php?id=$encodedID\";'> <span class='fa fa-comments' style='font-size: 18px; margin-right: 5px;'></span>Chat</button>
            <button class='deleteUser-btn' onclick='deleteMatch(this);' style='margin-right: 5px;'><span class='fa fa-user-times' style='font-size: 18px; margin-right: 0px;'></span></button>

            <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                <p class='userID' hidden>$data[ID]</p>
                <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> $data[Name] $data[Surname]</p>
                <p style='clear: left;'>$data[Gender] &nbsp;</p>
                <span style='float: left; padding-top: 4px; font-size: 10px;'> &#9679; </span>
                <p>&nbsp; $age years old</p>
                <p style='clear: left;'>$data[District]</p>
                <p style='clear: left;'>$data[Education] &nbsp;</p>";
                if(!empty($data['MaritalStatus'])) {
                    echo "<span style='float: left; padding-top: 4px; font-size: 10px;'> &#9679; </span>
                    <p>&nbsp; $data[MaritalStatus]</p>";
                }
                echo "<p style='color: #0066cc; clear: both;'>
                    <strong>Matched interests:&nbsp;</strong><p class='commonInterests' style='color: #0066cc;'>$matchedInterests</p>
                </p>
            </div>

        </div>";


}
$conn->close();
?>
<script>

    var numOfResults = <?= $sql->num_rows ?>;
    // $("#results").prepend("<p id='numOfResults' style='margin: 0px 0px 15px 15px; color: #b1b1b1;clear: both;'>"+ numOfResults +" matches</p>");//show the number of results
    $("#numOfResults").html(numOfResults+" matches");
</script>