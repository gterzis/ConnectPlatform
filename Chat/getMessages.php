<?php // called by Messages.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../index.php");
    exit();
}

require_once '../includes/Connection.php';
session_start();

$userID = $_POST['userID'];

// get the conversation's messages with the details of the sender
$messages = $conn ->query("SELECT * FROM messages NATURAL JOIN users WHERE (SenderID = $_SESSION[user_id] AND ReceiverID = $userID AND SenderID =ID) 
                                    OR (SenderID = $userID AND ReceiverID = $_SESSION[user_id] AND SenderID =ID) ORDER BY SentDate;");

while ($data = mysqli_fetch_assoc($messages)){

    echo "<div class='message'>

                <img class='chat-image' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' >
                <div style='display: inline-block; position: relative; bottom: 17px'>
                    <p class='fullname' style='font-weight: bold;'> $data[Name] $data[Surname]</p>
                    <span style='padding-top: 1px; color: #cccccc;'> &#9642; </span>
                    <p class='message-date' >&nbsp;$data[SentDate]</p>
                </div>

                <p class='message-content'> $data[Message]</p>
         </div>";

}

$conn->close();
exit();