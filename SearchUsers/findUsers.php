<?php
require '../includes/Connection.php';

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

$sql = $conn -> query("SELECT * FROM users WHERE ( Birthdate > '$minDate' AND Birthdate < '$maxDate' ) AND 
                                                        (Gender = '$gender1' OR Gender = '$gender2') AND 
                                                        (District LIKE '$district') AND 
                                                        (Education LIKE '$education') AND 
                                                        (MaritalStatus LIKE '$maritalStatus') ");

echo "<p style='margin: 0px 0px 15px 35px; color: #b1b1b1;'>21 results</p>";
while($data = mysqli_fetch_row($sql))
{
    //Calculate the age of the user
    $currentDate = new DateTime(date("Y-m-d"));
    $age = $currentDate->diff(new DateTime($data[3])); // get the difference between birthday and current date
    $age =  $age->y; // get the year difference

    echo "  <hr> 
            <div class='result'>

            <span class='fa fa-user-circle'></span>
    
            <button class='sendRequest-btn' onclick='sendRequest();'> Send request</button>
    
            <div class='resultInformation' style='display: inline-block; margin-left: 15px;'>
                <p class='userID' hidden>$data[0]</p>
                <p style='margin-top: 3px;'>$data[5] &nbsp;</p>
                <p style='clear: left;'>$data[4] &nbsp;</p>
                <span style='float: left; padding-top: 1px;'> &#9642; </span>
                <p>&nbsp; $age years old</p>
                <p style='color: #0066cc; clear: both;'>Interested in: Tennis, Music</p>
            </div>

         </div>";
}

$conn->close();