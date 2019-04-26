<?php   // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

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

//ORDER BY
$orderByType = $_POST['orderByType'];
$orderBy = "yearOfBirth"; //default value
if (!empty($_POST['orderBy'])) {
    $orderBy = $_POST['orderBy'];
    if ($orderBy == "yearOfBirth" && $orderByType == "ASC")
        $orderByType = "DESC";
    elseif ($orderBy == "yearOfBirth" && $orderByType == "DESC")
        $orderByType = "ASC";
}

if($sql = $conn ->query("SELECT YEAR(Birthdate) as yearOfBirth, COUNT(*) as numOfUsers FROM users 
                                WHERE Birthdate >= '$minDate' AND Birthdate <= '$maxDate'
                                GROUP BY YEAR(Birthdate)
                                ORDER BY $orderBy $orderByType;")) {
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>Age</th>
        <th>Number of users</th>
        </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {

            //Calculate the age
            $currentDate = date("Y");
            $age = $currentDate - $data['yearOfBirth'];

            echo "
        <tr>
            <td>$age</td>
            <td>$data[numOfUsers]</td>
        </tr>";
        }
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){

        while ($data = mysqli_fetch_assoc($sql))
        {

            //Calculate the age
            $currentDate = date("Y");
            $age = $currentDate - $data['yearOfBirth'];

            $output[] = array(
                'age'   => $age,
                'users'  => $data["numOfUsers"]
            );
        }
        echo json_encode($output);
    }

}
else {
    echo mysqli_error($conn);
}