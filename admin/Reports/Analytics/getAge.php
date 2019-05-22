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
        $totalUsers = 0;
        while ($data = mysqli_fetch_assoc($sql)) {

            //Calculate the age
            $currentDate = date("Y");
            $age = $currentDate - $data['yearOfBirth'];
            $totalUsers += $data['numOfUsers'];
            echo "
        <tr>
            <td>$age</td>
            <td>$data[numOfUsers]</td>
        </tr>";
        }
        echo "
        <tr>
            <th>Total</th>
            <th>$totalUsers</th>
        </tr>";
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){
        $ageRanges = array("25" => 0, "40" => 0, "60" =>0, "100" => 0 );
        while ($data = mysqli_fetch_assoc($sql))
        {

            //Calculate the age
            $currentDate = date("Y");
            $age = $currentDate - $data['yearOfBirth'];

            if ($age <= 25)
                $ageRanges["25"]+= $data['numOfUsers'];
            elseif ($age >25 && $age <=40)
                $ageRanges["40"]+= $data['numOfUsers'];
            elseif ($age >40 && $age<=60 )
                $ageRanges["60"]+= $data['numOfUsers'];
            elseif ($age>60)
                $ageRanges["100"]+= $data['numOfUsers'];

        }

        foreach( $ageRanges as $key => $val ){
            if ($key == "25" ){
                $output[] = array(
                    'age'   => "18-25",
                    'users'  => $val
                );
            }
            elseif ($key == "40" ){
                $output[] = array(
                    'age'   => "26-40",
                    'users'  => $val
                );
            }
            elseif ($key == "60" ){
                $output[] = array(
                    'age'   => "41-60",
                    'users'  => $val
                );
            }
            elseif ($key == "100" ){
                $output[] = array(
                    'age'   => "60<",
                    'users'  => $val
                );
            }
        }
        echo json_encode($output);
    }

}
else {
    echo mysqli_error($conn);
}