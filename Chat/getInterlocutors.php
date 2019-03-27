<?php // called by Messages.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}

require_once '../includes/Connection.php';
session_start();

// get the details of the users that had chat with before
$getInterlocutors = $conn -> query("SELECT DISTINCT * FROM users NATURAL JOIN messages WHERE (SenderID = $_SESSION[user_id] AND ReceiverID = users.ID) 
                                            OR (ReceiverID = $_SESSION[user_id] AND SenderID = users.ID) GROUP BY ID ORDER BY SentDate DESC");

while ($data = mysqli_fetch_assoc($getInterlocutors)) {
    echo "<div class='result chat-user' onclick='showConversation(this);' style='margin-left: 15px;'>

            <hr style='width: 100%;'>
            <img style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' width='25' height=50' >
            
            <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                <p class='userID' hidden>$data[ID]</p>
                <p class='fullname' style='font-weight: bold; cursor: pointer; text-decoration: none;'> $data[Name] $data[Surname]</p>
            
            </div>
            
         </div>";
}

$conn -> close();