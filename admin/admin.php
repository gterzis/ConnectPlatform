<?php ?>
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
<html style="height: 100%;">

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

        //Show add interest window
        function addInterest(){
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/Profile/addInterest.php");
            return false;
        }

        //Send data to edit information window and show it.
        //function editInformation() {
        //    //Storing user's information into an array in order to be send to the information window.
        //    var array = ["<?//= $name ?>//", "<?//= $surname ?>//", "<?//= $bday?>//", "<?//= $gender ?>//",
        //        "<?//= $district ?>//", "<?//= $education ?>//", "<?//= $email?>//", "<?//= $description ?>//", "<?//= $maritalStatus ?>//" ];
        //    array = JSON.stringify(array);
        //    $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/editInformation.php?array="+array+"");
        //    return false;
        //}

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
                url: "../Profile/BulletinBoard.php",
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

    </script>


</head>

<body style="background-color: #f2f2f2">

<!--Place change password, edit information window-->
<div id="modal-box"></div>

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/header2.html"); ?>

<div class="main" style="height: 70px; width: 40%;" >

    <!--PERSONAL INFORMATION-->
    <div class="about" style="left: 5%; top: 15px;">

        <span class="fa fa-user-o"><p> <?= $email ?></p></span>

    </div>

    <div class="buttons" style="top: 5px; left: 180px;">

        <a onclick="editInformation()"><span class="fa fa-edit"></span> Edit </a>
        <a  style="top:10px; left:200px " onclick="changePassword()"><span class="fa fa-unlock"></span> Change Password</a>

    </div>

</div>

<!--BULLETIN BOARD-->
<div class="bulletin-board">
    <h1>Bulletin Board</h1>
    <!--Any announcements will be placed here-->
</div>

<!--ADDS-->
<div class="adds">
    <h2 style="width: 40%; display: inline-block;">Additives</h2>
    <div class='add' style="border: none;"><p>Add admin</p></i></div>
    <div class='add'><p>Add announcement</p></div>
    <div class='add'><p>Add interest</p></div>
</div>


</body>

</html>
