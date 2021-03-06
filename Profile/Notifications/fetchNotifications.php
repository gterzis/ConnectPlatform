<?php
// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../index.php");
    exit();
}

require_once '../../includes/Connection.php';
session_start();

$sql = $conn -> query("SELECT * FROM notifications NATURAL JOIN users WHERE toUserID = $_SESSION[user_id] AND fromUserID = users.ID ORDER BY creationDate DESC;");
if($sql ->num_rows > 0) {
    while ($data = mysqli_fetch_assoc($sql)) {

        //Set notification as seen
        $sql2 = $conn -> query("UPDATE notifications SET Seen = 1 WHERE NotificationID = $data[NotificationID]");

        //Calculate the age of the user
        $currentDate = new DateTime(date("Y-m-d"));
        $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
        $age = $age->y; // get the year difference

        // encode user's id in order to pass it to url for the chat page
        $encodedID = base64_encode($data['ID']);

        //Format sent date of request
        $creationDate = date("d-M-Y H:i", strtotime($data['creationDate']));
        echo "  <div style='margin: 0px 0px 5px 0px; font-size: 14px; color: #cccccc; width: 94%;'> <p style='float: left;margin: 10px 30px 5px 30px ;'>Request accepted</p> <p style='float: right; margin: 10px 0px 5px 0px;'>$creationDate</p></div>
                <hr> 
                <div class='result' style='width: auto !important;'>
                                        
                    <img class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' width='25' height=50' >
                    <button class='chat-btn' onclick='location.href=\"http://localhost/Local%20Server/ConnectPlatform/Chat/Messages.php?id=$encodedID\";'> <span class='fa fa-comments' style='font-size: 18px; margin-right: 5px;'></span>Chat</button>

                    <div class='resultInformation' style='display:inline-block; margin-left: 15px; width: auto;'>
                        <p class='userID' hidden>$data[ID]</p>
                        <p style='font-weight: bold'> $data[Name] $data[Surname]</p>
                        <p style='clear: left;'>$data[Gender] &nbsp;</p>
                        <span style='float: left; padding-top: 5px; font-size: 8px;'> &#9679; </span>
                        <p>&nbsp; $age years old</p>
                        <p style='clear: left;'>$data[District]</p>
                        <p style='clear: left;'>$data[Education] &nbsp;</p>";
                        if(!empty($data['MaritalStatus'])){
                            echo" <span style='float: left; padding-top: 5px; font-size: 8px;'> &#9679; </span>
                            <p>&nbsp; $data[MaritalStatus]</p>";
                        }
                        echo "
                        <p style='color: #0066cc; clear: left;'>
                            <strong>Interested in:&nbsp;</strong>
                            <p class='commonInterests' style='color: #0066cc;'>$data[CommonInterests]</p>
                        </p>
                    </div>
    
             </div>";
    }
}
else{
    echo "<div style='font-size: 18px; color: #cccccc; padding-left: 30px;'> No notifications</div>";
}

$conn -> close();
?>
<script>
    // Change the notification icon to its default color. (Notifications are seen)
    $(".fa-bell").css("color", "#c7d1d8");
    // Hide number of unseen notifications icon
    $(".numOfNotifications").hide();
</script>
