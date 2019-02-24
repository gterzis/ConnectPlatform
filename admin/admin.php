<?php
session_start();

//if user is not logged-in is redirected
if(!isset($_SESSION['user_id']))
{
    header("Location: index.php");
    exit();
}

//To check if photo uploaded successfully.
$success = "false";
if(!empty($_GET['success'])) {
    $success = $_GET['success'];
}

require('../includes/Connection.php');

$sql = $conn -> query("SELECT * FROM admins WHERE AdminID = '".$_SESSION['user_id']."';");
$row = $sql->fetch_assoc();
$email=$row['Email'];


$conn->close();
?>
<!DOCTYPE html>
<html style="overflow: hidden">

<head>
    <title>Get in Touch - Admin</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/indexStyle.css">

    <script language="JavaScript">
        //Show change password window
        function changePassword(){
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/changePassword.php");
            return false;
        }

        //Show admins window
        function showAdmins(){
            $('#modal-box').load("./Administrators/Admins.php");
            return false;
        }

        //Show announcements window
        function showAnnouncements(){
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/admin/BulletinBoard/Announcements.php");
            return false;
        }

        //Show interests window
        function showInterests(){
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/admin/Interests/Interests.php");
            return false;
        }

        //Send data to edit information window and show it.
        function editInformation() {
            //Storing user's information into an array in order to be send to the information window.
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/admin/editAdminEmail.php");
            return false;
        }

        //Fetch data for bulletin board.
        function fetchBulletinBoard() {
            $.ajax({
                type: "GET",
                url: "../Profile/BulletinBoard.php",
                dataType: "html",   //expect html to be returned
                success: function (response) {
                    $(".bulletin-board").html("<h1>Bulletin Board</h1>" + response);
                }
            });
        }

        $(document).ready(function () {
            fetchBulletinBoard();//cant call it outside from this scope :(
        })


    </script>

</head>

<body style="background-color: #f2f2f2;">

<!--Page's Content-->
<div style="overflow: auto; position: absolute; width: 100%; height: 100%;">
    <!--Place modal box-->
    <div id="modal-box"></div>

    <!--HEADER-->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/adminHeader.html"); ?>

    <div class="main" style="height: 70px; width: 40%;" >

        <!--PERSONAL INFORMATION-->
        <div class="about" style="left: 5%; top: 15px;">
            <span class="fa fa-user-circle"><p> <?= $email ?></p></span>
        </div>

        <div class="buttons" style="top: 5px; left: 180px;">
            <a onclick="editInformation()"><span class="fa fa-edit"></span> Edit </a>
            <a  style="top:10px; left:200px " onclick="changePassword()"><span class="fa fa-unlock"></span> Change Password</a>
        </div>

    </div>

    <!--BULLETIN BOARD-->
    <div class="bulletin-board">
        <!--Any announcements will be placed here-->
    </div>

    <!--ADDS-->
    <div class="adds" style="position: absolute; top: 160px;">
        <h2 style="width: 40%; display: inline-block;">Operations</h2>
        <div class='add' style="border: none;" onclick="showAdmins()"><p><i class="fa fa-cog" style="color: #999999;"></i> Administrators</p></div>
        <div class='add' onclick="showAnnouncements()"><p><i class="fa fa-cog" style="color: #999999;"></i> Announcements</p></div>
        <div class='add' onclick="showInterests()"><p><i class="fa fa-cog" style="color: #999999;"></i> Interests</p></div>
    </div>

</div>

</body>

</html>
