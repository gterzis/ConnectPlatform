<?php
// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../index.php");
    exit();
}

require_once '../../includes/Connection.php';
session_start();

$sql = $conn -> query("SELECT * FROM matching_requests NATURAL JOIN users WHERE ReceiverID = $_SESSION[user_id] AND SenderID = users.ID ORDER BY SentDate DESC;");
if($sql ->num_rows > 0) {
    while ($data = mysqli_fetch_assoc($sql)) {

        //Set request as seen
        $sql2 = $conn -> query("UPDATE matching_requests SET Seen = 1 WHERE RequestID = $data[RequestID]");

        //Calculate the age of the user
        $currentDate = new DateTime(date("Y-m-d"));
        $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
        $age = $age->y; // get the year difference

        // encode user's id in order to pass it to url for the chat page
        $encodedID = base64_encode($data['ID']);

        //format sent date of request
        $creationDate = date("d-M-Y H:i", strtotime($data['SentDate']));
        echo "  <div style='margin: 0px 0px 5px 0px; font-size: 14px; color: #cccccc; text-align: right; width: 94%;'>$creationDate</div>
                <hr> 
                <div class='result'>
                    
                    <span class='fa fa-user-circle'></span>
                    
                    <button class='acceptRequest-btn' onclick='acceptRequest(this);'> Accept</button>
                    <button class='declineRequest-btn' onclick='declineRequest(this);'> Decline</button>
                    <button hidden id='chat'  class='chat-btn' onclick='location.href=\"http://localhost/Local%20Server/ConnectPlatform/Chat/Messages.php?id=$encodedID\";'><span class='fa fa-comments' style='font-size: 18px; margin-right: 5px;'></span>Chat</button>

                    <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                        <p class='userID' hidden>$data[ID]</p>
                        <p style='margin-top: 3px;'>$data[District]</p>
                        <p style='clear: left;'>$data[Gender] &nbsp;</p>
                        <span style='float: left; padding-top: 1px;'> &#9642; </span>
                        <p>&nbsp; $age years old</p>
                        <p style='clear: left;'>$data[Education] &nbsp;</p>";
                        if (!empty($data['MaritalStatus'])) {
                        echo "
                        <span style = 'float: left; padding-top: 1px;' > &#9642; </span>
                        <p >&nbsp; $data[MaritalStatus] </p >";
                            }
                        echo"
                        <p style='color: #0066cc; clear: both;'><strong>Interested in:</strong>&nbsp;<p class='commonInterests' style='color: #0066cc;'>$data[CommonInterests]</p></p>
                    </div>
    
             </div>";
    }
}
else{
    echo "<div style='font-size: 18px; color: #cccccc; padding-left: 30px;'> No requests</div>";
}

$conn -> close();
?>
<script>
    // Change the requests icon to its default color. (Requests are seen)
    $(".fa-user-plus").css("color", "#c7d1d8");
    // Hide number of unseen requests icon
    $(".numOfRequests").hide();
</script>
