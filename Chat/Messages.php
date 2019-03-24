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
    </script>
</head>

<body style="background-color:#f2f2f2;">

    <!--modal box-->
    <div id="modal-box"></div>

    <!--HEADER-->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/userHeader.php"); ?>
    <div class="messaging">
        <h2>Messaging</h2>

        <div id="results" class="chat-users">

            <div class='result chat-user' style="margin-left: 15px;">
                <hr style="width: 100%;">
                <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                    <p class='userID' hidden>$data[ID]</p>
                    <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> George Terzis</p>

                </div>

            </div>
            <div class='result chat-user' style="margin-left: 15px;">
                <hr style="width: 100%;">
                <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                    <p class='userID' hidden>$data[ID]</p>
                    <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> George Terzis</p>

                </div>

            </div>
            <div class='result chat-user' style="margin-left: 15px;">
                <hr style="width: 100%;">
                <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                    <p class='userID' hidden>$data[ID]</p>
                    <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> George Terzis</p>

                </div>

            </div>
            <div class='result chat-user' style="margin-left: 15px;">
                <hr style="width: 100%;">
                <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                    <p class='userID' hidden>$data[ID]</p>
                    <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> George Terzis</p>

                </div>

            </div>
            <div class='result chat-user' style="margin-left: 15px;">
                <hr style="width: 100%;">
                <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                    <p class='userID' hidden>$data[ID]</p>
                    <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> George Terzis</p>

                </div>

            </div>
            <div class='result chat-user' style="margin-left: 15px;">
                <hr style="width: 100%;">
                <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                    <p class='userID' hidden>$data[ID]</p>
                    <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> George Terzis</p>

                </div>

            </div>
            <div class='result chat-user' style="margin-left: 15px;">
                <hr style="width: 100%;">
                <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                    <p class='userID' hidden>$data[ID]</p>
                    <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> George Terzis</p>

                </div>

            </div>

        </div>

    </div>

    <div class="chatbox">
        <div class='result' style="margin-left: 10px">

            <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

            <div class='resultInformation' style='display: inline-block; margin-left: 10px'>
                <p class='userID' hidden>15</p>
                <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> John Grimes</p>
                <p style='clear: left;'>Tseri, Nicosia</p>
                <p style='clear: left;'>Male &nbsp;</p>
                <span style='float: left; padding-top: 1px;'> &#9642; </span>
                <p>&nbsp; 21 years old</p>
                <p style='clear: left;'>Cyprus University of Technology &nbsp;</p>
                <span style='float: left; padding-top: 1px;'> &#9642; </span>
                <p>&nbsp; Divorced</p>
                <p style='color: #0066cc; clear: both;'>
                    Matched interests:<p class='commonInterests' style='color: #0066cc;'>Golf, Chess</p>
                </p>
            </div>

        </div>

        <div id="conversation" style="max-height: 325px; overflow: auto;">
            <div class="message">

                <img class='chat-image' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' >
                <div style="display: inline-block;position: relative; bottom: 17px; margin-left: 5px;">
                    <p class='fullname' style='font-weight: bold;'> John Grimes</p>
                    <span style='padding-top: 1px; color: #cccccc;'> &#9642; </span>
                    <p class="message-date" >&nbsp;22 - March 12:40</p>
                </div>

                <p class="message-content"> Hello there, how are you? Last Wednesday went for interview at University of Cyprus Hello there, how are you? Last Wednesday went for interview at University of Cyprus</p>
            </div>
            <div class="message">

                <img class='chat-image' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/18.jpg' alt='' >
                <div style="display: inline-block;position: relative; bottom: 17px">
                    <p class='fullname' style='font-weight: bold;'> Hodor Grimes</p>
                    <span style='padding-top: 1px; color: #cccccc;'> &#9642; </span>
                    <p class="message-date" >&nbsp;22 - March 12:40</p>
                </div>

                <p class="message-content"> Hello there, how are you? Last Wednesday went for interview at University of Cyprus Hello there, how are you? Last Wednesday went for interview at University of Cyprus</p>
            </div>
            <div class="message">

                <img class='chat-image' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' >
                <div style="display: inline-block;position: relative; bottom: 17px">
                    <p class='fullname' style='font-weight: bold;'> John Grimes</p>
                    <span style='padding-top: 1px; color: #cccccc;'> &#9642; </span>
                    <p class="message-date" >&nbsp;22 - March 12:40</p>
                </div>

                <p class="message-content"> Hello there, how are you? Last Wednesday went for interview at University of Cyprus Hello there, how are you? Last Wednesday went for interview at University of Cyprus</p>
            </div>
            <div class="message">

                <img class='chat-image' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' >
                <div style="display: inline-block;position: relative; bottom: 17px">
                    <p class='fullname' style='font-weight: bold;'> John Grimes</p>
                    <span style='padding-top: 1px; color: #cccccc;'> &#9642; </span>
                    <p class="message-date" >&nbsp;22 - March 12:40</p>
                </div>

                <p class="message-content"> Hello there, how are you? Last Wednesday went for interview at University of Cyprus Hello there, how are you? Last Wednesday went for interview at University of Cyprus</p>
            </div>

        </div>

        <hr style="margin-top: 0px;">
        <div class="input-message">
            <form>
                <input class="inp-message" type="text"  placeholder="Write a message..." maxlength="300" style="float:left; margin:10px;">
                <button class="btn" type="submit"> Send</button>
            </form>
        </div>
    </div>
</body>
</html>