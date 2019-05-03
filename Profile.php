<?php
	session_start();

    //if user is not logged-in is being redirected
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

    $sql = $conn -> query("SELECT * FROM users WHERE ID = $_SESSION[user_id]");
    $row = $sql->fetch_assoc();

    $name=str_replace(' ', '%20', $row['Name']);
    $surname=str_replace(' ', '%20', $row['Surname']);
    $bday=date("d-M-Y", strtotime($row['Birthdate']));
    $gender=$row['Gender'];
    $district=str_replace(' ', '%20', $row['District']);
    $education=str_replace(' ', '%20', $row['Education']);
    $occupation=str_replace(' ', '%20', $row['Occupation']);
    $email=$row['Email'];
    $description=str_replace(' ', '%20', $row['Description']);
    $maritalStatus = $row['MaritalStatus'];

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

    //Show add interest window
    function addInterest(){
        $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/Profile/addInterest.php");
        return false;
    }

    //Send data to edit information window and show it.
    function editInformation() {
        //Storing user's information into an array in order to be send to the information window.
        var array = ["<?= $name ?>", "<?= $surname ?>", "<?= $bday?>", "<?= $gender ?>",
            "<?= $district ?>", "<?= $education ?>", "<?= $occupation ?>", "<?= $email?>", "<?= $description ?>", "<?= $maritalStatus ?>" ];
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

    //Delete user's interest
    function deleteInterest(name) {
        if (confirm('Are you sure you want to delete it?')) {
            var interestName = $(name).siblings("p").text();
            $.ajax
            ({
                type:'post', url:'Profile/deleteInterest.php',
                data:{name: interestName},
                success:function(response)
                {
                    if(response == "success") {
                        $(name).parent().html('<p style="color:#009933; font-size:17px; margin:15px;">' +
                            '<span id="remove" class="fa fa-check-circle-o"> Selected interest deleted successfully !</span></p>');
                        //After 3 seconds
                        setTimeout(function(){
                            //Remove the div where deleted interest was placed.
                            $("#remove").parents(".interest").remove();
                            $(".interests").children('.interest:first').css("border", "none"); // Remove the top border of the first interest
                        }, 3000);
                    }
                    else{
                        alert("Failed");
                    }
                }
            });
        } else {
            // Do nothing!
        }
    }

    $(document).ready(function(){


        //Profile picture updated successfully
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
        $.ajax({
            type: "GET",
            url: "Profile/BulletinBoard.php",
            dataType: "html",   //expect html to be returned
            success: function(response){
                $(".bulletin-board").append(response);
            }
        });

        //Fetch the user's interests.
        $.ajax({
            type: "GET",
            url: "Profile/getInterests.php",
            dataType: "html",   //expect html to be returned
            success: function (response) {
                $(".interests").append(response);
            },
            complete: function () {
                //Remove the top border of the first interest
                $(".interests").children('.interest:first').css("border", "none");
            },
        });
    });

    //Hide spinner and show page
    $(function() {
        $(".preload").fadeOut(500, function() {
            $("#Profile-pagecontent").fadeIn(500);
        });
    });

</script>

</head>

<body style="background-color: #f2f2f2">

<div class="preload"><img src="images/Spinner.gif">
</div>

<div id="Profile-pagecontent" hidden>

    <!--Place change password, edit information window-->
    <div id="modal-box"></div>

    <!--HEADER-->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/userHeader.php"); ?>

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
            <p style="word-wrap: break-word; font-size: 11px;">
                <?php if(empty($row['Description']))
                    echo '<a style="margin-left: 38%; font-size: 14px; color: #0066cc; cursor: pointer;" onclick="editInformation()">
                            <i class="fa fa-plus"></i> Add description </a>';
                else
                    echo $row['Description'];
                ?>
            </p>
        </div>
        <!--PERSONAL INFORMATION-->
        <div class="about">

            <span class="fa fa-birthday-cake"><p> <?= $bday ?></p></span>
            <span class="fa fa-home"><p>     <?= $row['District'] ?></p></span>
            <span class="fa fa-mortar-board"><p><?= $row['Education'] ?></p></span>
            <span class="fa fa-briefcase"><p> <?php if(empty($row['Occupation'])) echo "No details to show"; else echo $row['Occupation']; ?> </p></span>
            <span class="fa fa-venus-mars"><p> <?= $gender ?></p></span>
            <span class="fa fa-heart"><p> <?php if(empty($maritalStatus)) echo "No details to show"; else echo $maritalStatus; ?> </p></span>
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

    <!--INTERESTS-->
    <div class="interests" style="float: left; position: absolute; top: 100%;">
        <h2>Interests</h2>
        <a onclick="addInterest()"><i class="fa fa-plus"></i> Add a new interest</a>
        <!--Any user's interests will be placed here-->
    </div>

    </div>

</body>

</html>