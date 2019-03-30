<?php // called by Messages.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}

require_once '../includes/Connection.php';
session_start();

$userID = $_POST['userID'];

// get user's information
if($getInformation = $conn -> query("SELECT * FROM users WHERE ID = $userID")) {

    $data = mysqli_fetch_assoc($getInformation);

    $matchedInterests ="";

    //get the matched interests between the two users
    $sql2 = $conn -> query("SELECT MatchInterest FROM matches WHERE (User1= $_SESSION[user_id] AND User2 = $data[ID] AND Active=1) OR (User2= $_SESSION[user_id] AND User1 = $data[ID] AND Active=1 )");
    if ($sql2->num_rows>0) {
        while ($matchInterest = mysqli_fetch_assoc($sql2)) {
            $matchedInterests .= $matchInterest['MatchInterest'] . ', ';
        }

        $matchedInterests = rtrim($matchedInterests, ', ');//remove last comma + space

        //Calculate the age of the user
        $currentDate = new DateTime(date("Y-m-d"));
        $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
        $age = $age->y; // get the year difference

        echo "<img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' width='25' height=50' >

            <div class='resultInformation' style='display: inline-block; margin-left: 10px'>
                <p class='userID' hidden>$data[ID]</p>
                <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> $data[Name] $data[Surname] </p>
                <p style='clear: left;'>$data[Gender] &nbsp;</p>
                <span style='float: left; padding-top: 3px; font-size: 8px;'> &#9679; </span>
                <p>&nbsp; $age years old</p>
                <p style='clear: left;'>$data[District]</p>
                <p style='clear: left;'>$data[Education] &nbsp;</p>
                <span style='float: left; padding-top: 3px; font-size: 8px;'> &#9679; </span>
                <p>&nbsp; $data[MaritalStatus]</p>
                <p style='color: #0066cc; clear: both;'>
                    <strong>Matched interests:&nbsp;</strong> <p class='commonInterests' style='color: #0066cc;'>$matchedInterests</p>
                </p>
            </div>";
    }
    else{
        echo "<h4>You are no longer matched with the user</h4>";
    }
}
$conn->close();
exit();