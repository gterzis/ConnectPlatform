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
    <title>Get in Touch - Matches</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../indexStyle.css">
    <script>
        $(document).ready(function () {
            // Show matches
            fetchMatches();
            function fetchMatches() {
                $.ajax
                ({
                    method: "POST",
                    url: "http://localhost/Local%20Server/ConnectPlatform/Matches/fetchMatches.php",
                    success: function (response) {
                        $("#results").append(response);
                    }
                });
                return false;
            }
        });

        //delete match
        function deleteMatch(clickedBtn) {
            if (confirm('Are you sure you want to delete this match?')) {
                var matchedUserID = $(clickedBtn).siblings(".resultInformation").find(".userID").text(); // get request sender's id
                $.ajax({
                    method: "POST",
                    url: "http://localhost/Local%20Server/ConnectPlatform/Matches/deleteMatch.php",
                    data:{matchedUserID: matchedUserID},
                    success: function(response){
                        if (response == "success"){
                            $(clickedBtn).text("Deleted").prop('disabled', true);// change button's text and disable it
                            $(clickedBtn).siblings(".chat-btn").hide();// hide decline button
                        }
                        else {
                            alert(response);
                        }
                    }
                });
            }
            else {// Do nothing!
                }

            return false;
        }

        //show user's profile
        var userID;
        function showProfile(e) {
             userID = $(e).parent().find(".userID").text(); // get the user's id whose profile is going to be shown
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/Matches/viewProfile.php");
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
<body id="matches-pagecontent">
<!--Loading spinner-->
<div class="preload"><img src="../images/Spinner.gif">
</div>

<div id="Matches-pagecontent" hidden>

    <!--HEADER-->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/userHeader.php"); ?>

    <!--Place modal box-->
    <div id="modal-box"></div>

    <div id="matches-main">
        <h2>Matches</h2>

        <div id="results">

        </div>

    </div>

</div>
</body>
</html>