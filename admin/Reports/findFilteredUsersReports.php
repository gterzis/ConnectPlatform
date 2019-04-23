<?php // called by Interests.php
require '../../includes/Connection.php';
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
    $minDate = strtotime(''.date("Y-m-d").'-'.($maxAge+1).'years');
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

//OCCUPATION
$occupation = "%";//If no occupation entered.
if (!empty($_POST['occupation']))
    $occupation = test_input($_POST['occupation']);

//EMAIL
$email = "%";
if(!empty($_POST['email'])) {
    $email = test_input($_POST['email']);
    //Check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email error";
        exit();
    }
}

//MARITAL STATUS
$maritalStatus = "%";
if (!empty($_POST['maritalStatus']) AND ($_POST['maritalStatus'] != "Any") )
    $maritalStatus = $_POST['maritalStatus'];

//REGISTRATION DATE
//From
$registrationDateFrom = date("Y-m-d", strtotime('1920-01-01')); // if the user has no entered a value, this is the default.
if(!empty($_POST['registrationDateFrom']))
    $registrationDateFrom = $_POST['registrationDateFrom'];// get the value

//To
$registrationDateTo = date("Y-m-d");
if (!empty($_POST['registrationDateTo']))
    $registrationDateTo = $_POST['registrationDateTo'];

//LAST LOGIN DATE
//From
$lastLoginDateFrom = date("Y-m-d", strtotime('1920-01-01')); // if the user has no entered a value, this is the default.
if(!empty($_POST['lastLoginDateFrom']))
    $lastLoginDateFrom = $_POST['lastLoginDateFrom'];// get the value

//To
$lastLoginDateTo = date("Y-m-d");
if (!empty($_POST['lastLoginDateTo']))
    $lastLoginDateTo = $_POST['lastLoginDateTo'];

//ORDER BY
$orderByType = $_POST['orderByType'];
$orderBy = "Name"; //default value
if (!empty($_POST['orderBy'])) {
    $orderBy = $_POST['orderBy'];
    if ($orderBy == "Birthdate" && $orderByType == "DESC")
        $orderByType = "ASC";
    elseif ($orderBy == "Birthdate" && $orderByType == "ASC")
        $orderByType = "DESC";
}


function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslashes
    $data = htmlspecialchars($data);
    return $data;
}

//Find users based on search input
$sql = $conn->query("SELECT * FROM users WHERE (Name LIKE '$name') AND (Surname LIKE '$surname') AND 
                                                    (Birthdate >= '$minDate' AND Birthdate <= '$maxDate') AND 
                                                    (Gender = '$gender1' OR Gender = '$gender2') AND 
                                                    (District LIKE '$district') AND 
                                                    (Education LIKE '$education') AND
                                                    (Occupation LIKE '$occupation') AND
                                                    (Email LIKE '$email') AND 
                                                    (MaritalStatus LIKE '$maritalStatus') AND 
                                                    (RegistrationDate >= '$registrationDateFrom' AND RegistrationDate <= '$registrationDateTo') AND
                                                    (LastLogin >= '$lastLoginDateFrom' AND LastLogin <= '$lastLoginDateTo') ORDER BY $orderBy $orderByType;");
echo "<tr>
        <th hidden>ID</th>
        <th>#</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Age</th>
        <th>Gender</th>
        <th>District</th>
        <th>Education</th>
        <th>Occupation</th>
        <th>Marital Status</th>
        <th>Email</th>
        <th>Registration Date</th>
        <th>Last Login</th>
        <th># Matches</th>
    </tr>";
$numberOfUser = 1;
while ($data = mysqli_fetch_assoc($sql)) {

    //Format registration date
    $registrationDate = date_create($data['RegistrationDate']);
    $registrationDate = date_format($registrationDate,'d-M-y');

    //Format Last Login date
    $lastLogin = date_create($data['LastLogin']);
    $lastLogin = date_format($lastLogin,'d-M-y');

    //Calculate the age of the user
    $currentDate = new DateTime(date("Y-m-d"));
    $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
    $age = $age->y; // get the year difference

    // Get the number of matches the user has
    $getNumberOfMatches = $conn ->query("SELECT COUNT(*) FROM matches WHERE (User1 = $data[ID] AND Active=1) OR (User2 = $data[ID] AND Active=1) ");
    $numberOfMatches = mysqli_fetch_row($getNumberOfMatches);

    echo "
        <tr onclick='showProfile(this);'>
            <td class='reports-userID' hidden>$data[ID]</td>
            <td>$numberOfUser</td>
            <td class='reports-name'>$data[Name]</td>
            <td class='reports-surname'>$data[Surname]</td>
            <td class='reports-age'>$age</td>
            <td class='reports-gender'>$data[Gender]</td>
            <td class='reports-district'>$data[District]</td>
            <td class='reports-education'>$data[Education]</td>
            <td class='reports-occupation'>$data[Occupation]</td>
            <td class='reports-marital'>$data[MaritalStatus]</td>
            <td class='reports-email'>$data[Email]</td>
            <td class='reports-registration'>$registrationDate</td>
            <td class='reports-login'>$lastLogin</td>
            <td class='reports-matches'>$numberOfMatches[0]</td>
        </tr>";
    $numberOfUser++;
}

$conn->close();
?>

