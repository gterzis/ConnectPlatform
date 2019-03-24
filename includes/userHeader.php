<?php
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="topnav" id="myTopnav">
<a class="head-title" href="http://localhost/Local%20Server/ConnectPlatform/index.php"><p class="title2">Get in Touch</p></a>
    <div class="menu">
        <a href="http://localhost/Local%20Server/ConnectPlatform/Profile.php"><span class="fa fa-home"><p>Home</p></span></a>
        <a href="http://localhost/Local%20Server/ConnectPlatform/SearchUsers/SearchUsers.php"><span class="fa fa-search"><p>Find people</p></span></a>
        <a href="http://localhost/Local%20Server/ConnectPlatform/Chat/Messages.php"><span class="fa fa-comments"><p>Conversations</p></span></a>
        <a href="http://localhost/Local%20Server/ConnectPlatform/Matches/Matches.php"><span class="fa fa-users"><p>Matches</p></span></a>
        <a><span class="fa fa-user-plus"><p>Requests</p><i class="numOfRequests" hidden></i></span></a>
        <a><span class="fa fa-bell"><p>Notifications</p><i class="numOfNotifications" hidden></i></span></a>
        <a href="http://localhost/Local%20Server/ConnectPlatform/Logout.php"><span class="fa fa-sign-out"><p>Log out</p></span></a>
    </div>
</div>
<script>
    $(".fa-user-plus").click(function () {
        $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/Profile/Requests/Requests.php");
        return false;
    });

    $(".fa-bell").click(function () {
        $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/Profile/Notifications/Notifications.php");
        return false;
    });

    $(document).ready(function() {
        // check for unseen notifications and requests every 1 second
        setInterval(function () {
            $.ajax({
                type: "GET",
                url: "http://localhost/Local%20Server/ConnectPlatform/Profile/Notifications/checkUnseenNotifications.php",
                success: function (response) {
                    //change notification icon color if are there any unseen notifications
                    if (response > 0) {
                        $(".fa-bell").css("color", "#ffff66");
                        $(".fa-bell").children().css("color", "#c7d1d8");
                        $(".numOfNotifications").text(response).show();
                    }
                }
            });

            $.ajax({
                type: "GET",
                url: "http://localhost/Local%20Server/ConnectPlatform/Profile/Requests/checkUnseenRequests.php",
                success: function (response) {
                    //change request icon color if are there any unseen notifications
                    if (response > 0) {
                        $(".fa-user-plus").css("color", "#ffff66");
                        $(".fa-user-plus").children().css("color", "#c7d1d8");
                        $(".numOfRequests").text(response).show();
                    }
                }
            });

        }, 1000);
    });

    /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }

</script>
<style>

    body{
        margin: 0;
    }

    .numOfRequests,
    .numOfNotifications{
        border-radius: 50%;
        background-color: red;
        font-size: 13px;
        color: ivory !important;
        padding: 2px 5px;
        position: relative;
        bottom: 65px;
        margin-left: 30px;
    }

    .topnav span{
        margin-right: 30px;
    }

    .topnav p{
        margin-top: 7px;
        font-size: 13px;
        font-family: Verdana, Helvetica, Arial;
    }

    .topnav .fa{
        font-size: 20px;
        text-align: center;
        cursor: pointer;
        color: #c7d1d8;
        transition: 0.3s;
        transition-timing-function: ease-in-out;
        text-shadow: 0 0 3px #000;
    }

    .topnav .fa:hover{
        color: ivory !important;
    }

    .menu{
        float: right;
        margin: 20px 40px;
    }

    .head-title{
        float: left;
    }

    .title2{
        margin: 15px 45px;
        font-family: "Maiandra GD" !important;
        font-size: 45px !important;
        color: ivory;
        display: inline-block;
    }

    .topnav{
        margin:0;
        font-family: "Maiandra GD";
        font-size: 25px;
        color: ivory;
        width: 100%;
        height: 80px;
        background-color: #0073b1;
    }

    /* Style the links inside the navigation bar */
    .topnav a {
        float: left;
        display: block;
    }


</style>