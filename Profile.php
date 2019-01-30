<?php

	session_start();

    //if user is not logged-in is redirected
	if(!isset($_SESSION['user_id']))
	{
		header("Location: index.php");
		exit();
	}

	$success = "false";
    if(!empty($_GET['success'])) {
        $success = $_GET['success'];
    }

	require('./includes/Connection.php');

    $sql = $conn -> query("SELECT * FROM users WHERE ID = '".$_SESSION['user_id']."';");
    $row = $sql->fetch_assoc();

    $name=str_replace(' ', '%20', $row['Name']);
    $surname=str_replace(' ', '%20', $row['Surname']);
    $bday=date("d-M-Y", strtotime($row['Birthdate']));
    $gender=$row['Gender'];
    $district=str_replace(' ', '%20', $row['District']);
    $education=str_replace(' ', '%20', $row['Education']);
    $email=$row['Email'];
    $description=str_replace(' ', '%20', $row['Description']);

	$conn->close();
?>
<!DOCTYPE html>
<html style="height: 100%;">

    <head>
        <title>Get in Touch</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="indexStyle.css">
        <script language="JavaScript">
            //Show change password window
            function changePassword(){
                $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/changePassword.php");
                return false;
            }

            //Send data to edit information window and show it.
            function editInformation() {
                //Storing user's information into an array
                var array = ["<?= $name ?>", "<?= $surname ?>", "<?= $bday?>", "<?= $gender ?>",
                    "<?= $district ?>", "<?= $education ?>", "<?= $email?>", "<?= $description ?>" ];
                array = JSON.stringify(array);
                $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/editInformation.php?array="+array+"");
                return false;
            }

            $(function() {
                $("#upload-photo").on('click', function (e) {
                    e.preventDefault();
                    $("#photo:hidden").trigger('click');
                });
            });

            //Profile picture updated successfully
            $(document).ready(function(){
                var x = <?= $success ?>;
                if (x == true){
                    $("#upload-photo").html("Updated successfully !").css({"background-color" : "transparent", "color" : "green"});
                    setTimeout(
                        function()
                        {
                            location.href = "Profile.php";
                        }, 2500);
                }

                //Fetch data for bulletin board.
                $.ajax({    //create an ajax request to display.php
                    type: "GET",
                    url: "Profile/BulletinBoard.php",
                    dataType: "html",   //expect html to be returned
                    success: function(response){
                        $(".bulletin-board").append(response);
                    }

                });

            });

        </script>


    </head>

    <body style="background-color: #f2f2f2">

        <!--Place change password window-->
        <div id="modal-box"></div>

        <!--HEADER-->
        <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/header2.html"); ?>

        <div class="main">

            <!--PROFILE PICTURE-->
            <form id="updatePhoto" action="uploadPhoto.php" method="POST" enctype="multipart/form-data">
                <img id="phot" class="profile-pic" src="profile-pictures/<?= $row['Photo'] ?>" alt="" width="175" height="200" >
                <input hidden id="photo" name="image" type="file" accept="image/*"
                       onchange="document.getElementById('phot').src = window.URL.createObjectURL(this.files[0]);
                                    document.getElementById('sp').style.display='block';"/>
                <button id="sp" class="save-photo"><span class="fa fa-save"></span>     &nbspSave photo</button>
            </form>
            <!--FULL NAME-->
            <p class="name"><?= $row['Name']." ".$row['Surname'] ?></p>

            <!--DESCRIPTION-->
            <div class="description">
                <p style="word-wrap: break-word; font-size: 11px;"><?= $row['Description']; ?></p>
            </div>
            <!--PERSONAL INFORMATION-->
            <div class="about">

                <span class="fa fa-birthday-cake"><p> <?= $bday ?></p></span>
                <span class="fa fa-home"><p>     <?= $row['District'] ?></p></span>
                <span class="fa fa-mortar-board"><p><?= $row['Education'] ?></p></span>
                <span class="fa fa-venus-mars"><p> <?= $gender ?></p></span>

            </div>

            <div class="buttons">

                <a onclick="editInformation()"><span class="fa fa-edit"></span> Edit </a>
                <a  style="top:80px;" onclick="changePassword()"><span class="fa fa-unlock"></span> Change Password</a>
                <a id="upload-photo" style="top: -240px;"><span class="fa fa-camera"></span> Update photo</a>

            </div>

        </div>

        <!--BULLETIN BOARD-->
        <div class="bulletin-board">
            <h1>Bulletin Board</h1>
            <!--Any announcements will be placed here-->
        </div>


    </body>

</html>