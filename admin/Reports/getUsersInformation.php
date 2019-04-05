<?php
// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../index.php");
    exit();
}

require_once '../../includes/Connection.php';
session_start();

$userID = $_POST['userID']; // get the user's ID

//get user's information
if( $sql = $conn -> query("SELECT * FROM users WHERE ID = $userID") ){

    //find matched interests and put them in a string
    $matchedInterests="";
    $findMatchedInterests = $conn -> query("SELECT MatchInterest FROM matches WHERE (User1 = $userID AND User2 = $_SESSION[user_id] AND Active=1) OR 
                                                  (User1 = $_SESSION[user_id] AND User2 = $userID AND Active=1)");

        while ($data = mysqli_fetch_assoc($sql)) {

            //Calculate the age of the user
            $currentDate = new DateTime(date("Y-m-d"));
            $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
            $age = $age->y; // get the year difference

            echo " <div class='result'>

                    <img class='profile-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' width='25' height=50' >

                    <div class='profileInformation' style='display: inline-block; margin-left: 15px;'>
                        <p class='userID' hidden>$data[ID]</p>
                        <p style='font-weight: bold; font-size: 22px; color: #0066cc;'> $data[Name] $data[Surname]</p>
                        <p style='clear: left;'>$data[Gender] &nbsp;</p>
                        <span style='float: left; padding-top: 1px;'> &#9642; </span>
                        <p>&nbsp; $age years old</p>";
            if (!empty($data['MaritalStatus'])) {
                echo " <span style='float: left; padding-top: 1px;'> &nbsp; &#9642; </span>
                            <p>&nbsp; $data[MaritalStatus]</p>";
            }
            echo "</div>
                    <hr style='width: 100%; margin-top: 3px'>";
            //if the user has no description don't show the description field
            if (!empty($data['Description'])) {

                echo "<div id='description'>
                                <p id='description-content'>$data[Description]</p>
                            </div>
        
                            <hr style='width: 100%; margin-top: 3px'>";
            }

            echo "<!--PERSONAL INFORMATION-->
                    <div class='more-details'>
                        <span class='fa fa-home'><p> $data[District]</p></span>
                        <span class='fa fa-mortar-board'><p> $data[Education]</p></span>";
            if (!empty($data['Occupation'])) {
                echo "<span class='fa fa-briefcase'><p> $data[Occupation]</p></span>";
            }
            echo "</div>

                    <!--INTERESTS-->
                    <div class='viewProfile-interests' >
                        <div style='font-size: 18px; color: #999999;'> <p style='float: left;margin: 10px 30px 5px 0px ;'>Interests</p>
                        <hr style=\"width: 100%; margin-top: 3px\">";

            $usersInterests = $conn->query("SELECT InterestName FROM usersinterests WHERE UserID = $userID;");
            while ($interestName = mysqli_fetch_assoc($usersInterests)) {
                echo "<button class='viewProfile-chosen-interest' type='button'><p>$interestName[InterestName]</p></button>";
            }

            echo "</div>

                </div>";
        }
    }
    // show inform message
    else{
        echo "<div class='result'>
                <h4>You are no longer matched with the user</h4>
              </div>";
    }



