<?php
session_start();
//check if user has the right to visit the page
if (!isset($_SESSION['user_id'])){
    header("Location: http://localhost/Local%20Server/ConnectPlatform/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Get in Touch - Matches reports</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../../indexStyle.css">
    <style>
        #matches {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        #matches td, #matches th {
            border: 1px solid #ddd;
            padding: 8px 2px;
            font-size: 14px;
            text-align: center;
        }


        #matches tr:nth-child(even){background-color: #f2f2f2;}

        #matches tr:hover {
            cursor: pointer;
            background-color: #ddd;
        }

        #matches th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #0073b1;
            color: white;
            cursor: initial;
        }
    </style>
    <script>
        $(document).ready(function () {
            fetchMatches();

        });

        function fetchMatches() {
            $.ajax({
                method: "POST",
                url: "fetchInterests.php",
                success: function (response) {
                    $("#matches").html(response);
                }
            });
            return false;
        }

        //show filters field
        function showFilters() {
            $("#filters").fadeToggle();
            return false;
        }
        //show user's profile
        var userID;
        function showProfile(e) {
            userID = $(e).find(".reports-userID").text(); // get the user's id whose profile is going to be shown
            $('#modal-box').load("viewUsersProfile.php");
            return false;
        }

        //Hide spinner and show page
        $(function() {
            $(".preload").fadeOut(500, function() {
                $("#Matches-pagecontent").fadeIn(500);
            });
        });
    </script>
</head>

<body>
<!--Loading spinner-->
<div class="preload"><img src="../../../images/Spinner.gif"></div>

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/adminHeader.php"); ?>

<!--Place modal box-->
<div id="modal-box"></div>

<table id="matches">
</table>




</body>
</html>
