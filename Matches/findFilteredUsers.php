<?php // called by Interests.php
require '../includes/Connection.php';
session_start();
//NAME
$name ="%";
if (!empty($_POST['name']))
    $name = test_input($_POST['name']);

//SURNAME
$surname="%";
if (!empty($_POST['surname']))
    $surname = test_input($_POST['surname']);

//AGE calculations
$maxDate = date('Y-m-d', strtotime('-18 years'));// set date format
if (!empty($_POST['minAge'])){
    $minAge =  $_POST['minAge'];//Get selected minimum age.
    $maxDate = strtotime(''.date("Y-m-d").'-'.$minAge.'years'); //Subtract minAge from current date to get maxDate
    $maxDate = date("Y-m-d", $maxDate);// set date format
}

$minDate = date("Y-m-d", strtotime('1920-01-01'));// set date format
if (!empty($_POST['maxAge'])){
    $maxAge =  $_POST['maxAge'];
    $minDate = strtotime(''.date("Y-m-d").'-'.$maxAge.'years');
    $minDate = date("Y-m-d", $minDate);
}

//GENDER
if (!empty($_POST['gender1'])){
    $gender1 = $_POST['gender1'];
}
if (!empty($_POST['gender2'])){
    $gender2 = $_POST['gender2'];
}

//DISTRICT
$district = "%";//If no district entered.
if (!empty($_POST['district']))
    $district = test_input($_POST['district']);

//EDUCATION
$education = "%";//If no education entered.
if (!empty($_POST['education']))
    $education = test_input($_POST['education']);

//MARITAL STATUS
$maritalStatus = "%";
if (!empty($_POST['maritalStatus']) AND ($_POST['maritalStatus'] != "Any") )
    $maritalStatus = $_POST['maritalStatus'];

function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslashes
    $data = htmlspecialchars($data);
    return $data;
}

//INTERESTS
$insertedInterests = false;
$matchedInterest = true;
if (!empty($_POST['interests'])) { // check if user inserted interests for filtering
    $interests = array();
    $interests = $_POST['interests'];
    $insertedInterests = true;
}

//Find users based on search input
$sql = $conn->query("SELECT * FROM users WHERE (Name LIKE '$name') AND (Surname LIKE '$surname') AND 
                                                    (Birthdate > '$minDate' AND Birthdate < '$maxDate') AND 
                                                    (Gender = '$gender1' OR Gender = '$gender2') AND 
                                                    (District LIKE '$district') AND 
                                                    (Education LIKE '$education') AND 
                                                    (MaritalStatus LIKE '$maritalStatus') AND 
                                                    (ID IN (SELECT DISTINCT ID FROM matches NATURAL JOIN users WHERE (User1= $_SESSION[user_id] AND User2 = users.ID AND Active=1) OR (User2= $_SESSION[user_id] AND User1 = users.ID AND Active=1 ) 
                                                    GROUP BY ID ORDER BY MatchDate) )");

$numOfResults = 0;
while ($data = mysqli_fetch_assoc($sql)) {
    if ($insertedInterests == true)// if the user inserted interests for filtering.
        $matchedInterest =false;// $matchedInterest is for checking if there is any common interest

    $matchedInterests ="";// storage for the names of the matched interests
    //get the matched interests for each user
    $sql2 = $conn -> query("SELECT MatchInterest, MatchDate FROM matches WHERE (User1= $_SESSION[user_id] AND User2 = $data[ID] AND Active=1 ) OR (User2= $_SESSION[user_id] AND User1 = $data[ID] AND Active=1)");
    while ($matchInterest = mysqli_fetch_assoc($sql2)){
        if($insertedInterests == true){
            foreach ($interests as $interest){
                if ($interest == $matchInterest['MatchInterest']){
                    $matchedInterest = true;
                }
            }
        }
        $matchedInterests .=  $matchInterest['MatchInterest'].', ';
        //format match date
        $matchDate = date("d-M-Y", strtotime($matchInterest['MatchDate']));
    }

    $matchedInterests = rtrim($matchedInterests,', ');//remove last comma + space

    //Calculate the age of the user
    $currentDate = new DateTime(date("Y-m-d"));
    $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
    $age = $age->y; // get the year difference

    // encode user's id in order to pass it to url for the chat page
    $encodedID = base64_encode($data['ID']);

    if($matchedInterest == true) {
        $numOfResults++;
        echo "
        <div style='margin: 0px 0px 5px 0px; font-size: 14px; color: #cccccc; text-align: right; width: 94%;'>Match date: $matchDate</div>
        <hr>
        <div class='result'>
    
            <img onclick='showProfile(this)' style='cursor: pointer;' class='notification-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/$data[Photo]' alt='' width='25' height=50' >
            <button class='chat-btn' onclick='location.href=\"../../ConnectPlatform/Chat/Messages.php?id=$encodedID\";'> <span class='fa fa-comments' style='font-size: 18px; margin-right: 5px;'></span>Chat</button>
            <button class='deleteUser-btn' onclick='deleteMatch(this);'> <span class='fa fa-user-times' style='font-size: 18px; margin-right: 5px;'></span>Delete</button>
    
            <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                <p class='userID' hidden>$data[ID]</p>
                <p class='fullname' onclick='showProfile(this)' style='font-weight: bold; cursor: pointer;'> $data[Name] $data[Surname]</p>
                <p style='clear: left;'>$data[Gender] &nbsp;</p>
                <span style='float: left; padding-top: 4px; font-size: 10px;'> &#9679; </span>
                <p>&nbsp; $age years old</p>
                <p style='clear: left;'>$data[District]</p>
                <p style='clear: left;'>$data[Education] &nbsp;</p>";
            if (!empty($data['MaritalStatus'])) {
                echo "<span style='float: left; padding-top: 4px; font-size: 10px;'> &#9679; </span>
                    <p>&nbsp; $data[MaritalStatus]</p>";
            }
            echo "<p style='color: #0066cc; clear: both;'>
                    <strong>Matched interests:&nbsp;</strong><p class='commonInterests' style='color: #0066cc;'>$matchedInterests</p>
                </p>
            </div>
    
        </div>";
    }
}

$conn->close();
?>
<script>

    var numOfResults = <?= $numOfResults?>;
    if (numOfResults>0) {
        $("#numOfResults").html(numOfResults + " matches");
    }
    else {
        $("#numOfResults").html(numOfResults + " matches");
        alert("No any matches !");
    }
</script>
