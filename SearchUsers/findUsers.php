<?php
require '../includes/Connection.php';
session_start();
//AGE calculations
if (!empty($_POST['minAge'])){
    $minAge =  $_POST['minAge'];//Get selected minimum age.
    $maxDate = strtotime(''.date("Y-m-d").'-'.$minAge.'years'); //Subtract minAge from current date to get maxDate
    $maxDate = date("Y-m-d", $maxDate);// set date format
}

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
    $district = $_POST['district'];

//EDUCATION
$education = "%";//If no education entered.
if (!empty($_POST['education']))
    $education = $_POST['education'];

//MARITAL STATUS
$maritalStatus = "%";
if (!empty($_POST['maritalStatus']) AND ($_POST['maritalStatus'] != "Any") )
    $maritalStatus = $_POST['maritalStatus'];

//INTERESTS
$interests = array();
$interests = $_POST['interests'];

//Find users based on search input(except interests). Don't show those who already sent request.
// Don't show those where are already matched
$sql = $conn -> query("CREATE TEMPORARY TABLE IF NOT EXISTS temp_table AS (SELECT * FROM users WHERE ( Birthdate > '$minDate' AND Birthdate < '$maxDate' ) AND 
                                                        (Gender = '$gender1' OR Gender = '$gender2') AND 
                                                        (District LIKE '$district') AND 
                                                        (Education LIKE '$education') AND 
                                                        (MaritalStatus LIKE '$maritalStatus') AND 
                                                        (ID != $_SESSION[user_id]) AND 
                                                        (ID NOT IN (SELECT ReceiverID FROM matching_requests
                                                                    WHERE SenderID = $_SESSION[user_id]) ) AND
                                                        (ID NOT IN (SELECT User1 FROM matches WHERE User1 = $_SESSION[user_id]
                                                                    OR User2 = $_SESSION[user_id]) ) AND 
                                                        (ID NOT IN (SELECT User2 FROM matches WHERE User1 = $_SESSION[user_id]
                                                                    OR User2 = $_SESSION[user_id])) )");

$sql3 = $conn -> query("SELECT * FROM temp_table");
$sql4 = $conn -> query(" ALTER TABLE temp_table ADD numOfInterests smallint, ADD commonInterests text");

while($data = mysqli_fetch_assoc($sql3))
{
    //Check if user has common interests with the ones in the search input.
    $commonInterests = "";
    $numOfInterests =0; // number of common interests
    foreach ($interests as $interest){
        $sql2 = $conn -> query("SELECT InterestName FROM usersinterests WHERE UserID = '". $data['ID'] ."' AND InterestName = '".$interest."' ");
        $result = $sql2->fetch_assoc();
        if(!empty($result)) {
            $commonInterests .= $result['InterestName'] . ', ';
            $numOfInterests++;
        }
    }
    $commonInterests = rtrim($commonInterests,', ');//remove last comma + space
    // insert the number of common interests and the interests(names) in the temporary table
    $sql5 = $conn ->query("UPDATE temp_table SET numOfInterests = $numOfInterests, commonInterests = '".$commonInterests."' WHERE ID = $data[ID] ");
}

// select all users who have common interests, ordering them by the number of common interests
$sql6 = $conn ->query("SELECT * FROM temp_table WHERE numOfInterests != 0 ORDER BY numOfInterests DESC");
while ($data = mysqli_fetch_assoc($sql6)){
    //Calculate the age of the user
    $currentDate = new DateTime(date("Y-m-d"));
    $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
    $age = $age->y; // get the year difference

    echo "  <hr> 
        <div class='result'>
    
        <span class='fa fa-user-circle'></span>
        
        <button class='sendRequest-btn' onclick='sendRequest(this);'> Send request</button>
        
        <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
            <p class='userID' hidden>$data[ID]</p>
            <p style='margin-top: 3px;'>$data[District]</p>
            <p style='clear: left;'>$data[Gender] &nbsp;</p>
            <span style='float: left; padding-top: 1px;'> &#9642; </span>
            <p>&nbsp; $age years old</p>
            <p style='clear: left;'>$data[Education] &nbsp;</p>";
            if(!empty($data['MaritalStatus'])){
                echo "<span style='float: left; padding-top: 1px;'> &#9642; </span>
                <p>&nbsp; $data[MaritalStatus]</p>";
            }
            echo"
            <p style='color: #0066cc; clear: both;'>
                <strong>Interested in:&nbsp;</strong> <p class='commonInterests' style='color: #0066cc;'> $data[commonInterests]</p>
            </p>
        </div>
    
     </div>";
}

$conn->close();
?>
<script>

    var numOfResults = <?= $sql6 -> num_rows ?>;
    $("#results").prepend("<p style='margin: 0px 0px 15px 35px; color: #b1b1b1;'>"+ numOfResults +" results</p>");//show the number of results

</script>
