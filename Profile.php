<?php

	session_start();

    //if user is not logged-in is redirected
	if(!isset($_SESSION['user_id']))
	{
		header("Location: index.php");
		exit();
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
            function changePassword(){
                $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/changePassword.php");
                return false;
            }

            function editInformation() {
                //Storing user's information into an array
                var array = ["<?= $name ?>", "<?= $surname ?>", "<?= $bday?>", "<?= $gender ?>",
                    "<?= $district ?>", "<?= $education ?>", "<?= $email?>", "<?= $description ?>" ];
                array = JSON.stringify(array);
                $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/editInformation.php?array="+array+"");
                return false;
            }

            $(function(){
                $("#upload-photo").on('click', function(e){
                    e.preventDefault();
                    $("#photo:hidden").trigger('click');
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
            <img id="phot" class="profile-pic" src="images/background.jpg">
            <input hidden id="photo" type="file" accept="image/*"
                   onchange="document.getElementById('phot').src = window.URL.createObjectURL(this.files[0])"/>
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

                <a onclick="editInformation()"><span class="fa fa-edit"></span> Edit</a>
                <a  style="top:80px;" onclick="changePassword()"><span class="fa fa-unlock"></span> Change Password</a>
                <a id="upload-photo" style="top: -240px;"><span class="fa fa-camera"></span> Update photo</a>

            </div>

        </div>


    </body>

</html>