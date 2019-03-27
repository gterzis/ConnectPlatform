<?php
session_start();

//if user is not logged-in is being redirected
if(!isset($_SESSION['user_id']))
{
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html style="height: 100%;">

<head>
    <title>Get in Touch - Messages</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../indexStyle.css">
    <script>
        //show user's profile
        var userID;
        function showProfile(e) {
            userID = $(e).parent().find(".userID").text(); // get the user's id whose profile is going to be shown
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/Matches/viewProfile.php");
            return false;
        }

        //Hide spinner and show page's content
        $(function() {
            $(".preload").fadeOut(500, function() {
                $("#Messages-pagecontent").fadeIn(500);
            });
        });

        //get Interlocutors
        getInterlocutors();
        function getInterlocutors() {
            $.ajax({
                method: "POST",
                url:"getInterlocutors.php",
                success:function (response) {
                    $("#results").append(response);
                }
            });
            return false;
        }

        // show conversation details
        function showConversation(clickedUser) {
            var userID = $(clickedUser).find(".userID").text(); //get user's id from the hidden field
            // fetch user's information
            $.ajax({
                method: "POST",
                url:"getUserDetails.php",
                data:{userID: userID},
                success:function (response) {
                    $(".chatbox .result").html(response);
                    showMessages(userID);
                }
            });

            return false;
        }

        // refresh every one second the conversation
        setInterval(function () {
            var interlocutor  = $(".chatbox .result").find(".userID").text(); // get the interlocutor's id
            showMessages(interlocutor);
        }, 1000);

        /// fetch conversation's messages
        function showMessages(user) {
            var userID = user;
            $.ajax({
                method: "POST",
                url:"getMessages.php",
                data:{userID: userID},
                success:function (response) {
                $("#conversation").html(response);
                }
            });
            return false;
        }



        //sending message
        function sendingMessage() {
            var message = $(".inp-message").val(); // get the message's content
            var receiverID = $(".chatbox .result").find(".userID").text(); // get the receiver's ID
            $.ajax({
                method: "POST",
                url:"sendingMessage.php",
                data:{receiverID: receiverID, message: message},
                success:function (response) {
                    $(".inp-message").val("");
                    showMessages(receiverID); // refresh conversation's messages
                }
            });

            return false;
        }

    </script>
</head>

<body style="background-color:#f2f2f2;">
<!--Loading spinner-->
<div class="preload"><img src="../images/Spinner.gif"></div>

<div id="Messages-pagecontent" hidden>
    <!--modal box-->
    <div id="modal-box"></div>

    <!--HEADER-->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/userHeader.php"); ?>
    <div class="messaging">
        <h2>Messaging</h2>

        <div id="results" class="chat-users">
            <!--Place the users where chat with before (AJAX call)-->
        </div>

    </div>

    <div class="chatbox">
        <!-- User's information -->
        <div class='result' style="margin-left: 10px">
            <!--Place the user's information (AJAX call)-->
        </div>

        <hr style="margin: 0;">
        <div id="conversation" style="max-height: 325px; overflow: auto;">
            <!--Place the conversation's messages (AJAX call)-->
        </div>

        <hr style="margin-top: 0px;">

        <div class="input-message">
            <form id="sendMessage" onsubmit="return sendingMessage();">
                <input class="inp-message" type="text"  placeholder="Write a message..." maxlength="300" style="float:left; margin:10px;">
                <button class="btn" type="submit"> Send</button>
            </form>
        </div>

    </div>
</div>
</body>
</html>