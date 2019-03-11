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
$sql = $conn -> query("SELECT * FROM users WHERE ( Birthdate > '$minDate' AND Birthdate < '$maxDate' ) AND 
                                                        (Gender = '$gender1' OR Gender = '$gender2') AND 
                                                        (District LIKE '$district') AND 
                                                        (Education LIKE '$education') AND 
                                                        (MaritalStatus LIKE '$maritalStatus') AND 
                                                        (ID != $_SESSION[user_id]) AND 
                                                        ID NOT IN (SELECT ReceiverID FROM matching_requests
                                                                    WHERE SenderID = $_SESSION[user_id] )");

$numOfResults = 0;
while($data = mysqli_fetch_assoc($sql))
{
    $numOfResults += 1;
    //Check if user has common interests with the ones in the search input.
    $commonInterests = "";
    foreach ($interests as $interest){
        $sql2 = $conn -> query("SELECT InterestName FROM usersinterests WHERE UserID = '". $data['ID'] ."' AND InterestName = '".$interest."' ");
        $result = $sql2->fetch_assoc();
        if(!empty($result))
            $commonInterests .=  $result['InterestName'].', ';
    }

    //if user has no common interests with the ones in the search input is not showing in the results.
    if(!empty($commonInterests)) {
        $commonInterests = rtrim($commonInterests,', ');//remove last comma + space

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
                <p style='clear: left;'>$data[Education] &nbsp;</p>
                <span style='float: left; padding-top: 1px;'> &#9642; </span>
                <p>&nbsp; $data[MaritalStatus]</p>
                <p style='color: #0066cc; clear: both;'>
                    Interested in: <p class='commonInterests' style='color: #0066cc;'> $commonInterests</p>
                </p>
            </div>

         </div>";
    }
    else
        $numOfResults -= 1;

}

$conn->close();
?>
<script>

    var numOfResults = <?= $numOfResults ?>;
    $("#results").prepend("<p style='margin: 0px 0px 15px 35px; color: #b1b1b1;'>"+ numOfResults +" results</p>");//show the number of results

</script>
