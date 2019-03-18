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

        //delete match
        function deletemMatch(clickedBtn) {
            var matchedUserID = $(clickedBtn).siblings(".resultInformation").find(".userID").text(); // get request sender's id
            $.ajax({
                method: "POST",
                url: "http://localhost/Local%20Server/ConnectPlatform/Profile/Requests/declineRequest.php",
                data:{matchedUserID: matchedUserID},
                success: function(response){
                    if (response == "success"){
                        $(clickedBtn).text("Declined").prop('disabled', true);// change button's text and disable it
                        $(clickedBtn).siblings(".chat-btn").hide();// hide decline button
                    }
                    else {
                        alert(response);
                    }
                }
            });
            return false;
        }
    </script>
</head>
<body id="matches-pagecontent">

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/userHeader.php"); ?>

<!--Place modal box-->
<div id="modal-box"></div>

<div id="matches-main">
    <h2>Matches</h2>

    <div id="results">




    </div>

</div>

</body>
</html>