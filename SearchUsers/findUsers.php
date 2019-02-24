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
$rows = array();
while($data = mysqli_fetch_row($sql))
{
    $rows[] = $data[1];
}

$conn->close();
echo json_encode($rows);