<?php // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

//REGISTRATION DATE
//From
$lastLoginFrom = date("Y-m-d", strtotime('1920-01-01')); // if the user has no entered a value, this is the default.
if(!empty($_POST['lastLoginFrom']))
    $lastLoginFrom = $_POST['lastLoginFrom'];// get the value

//To
$lastLoginTo = date("Y-m-d");
if (!empty($_POST['lastLoginTo']))
    $lastLoginTo = $_POST['lastLoginTo'];

//ORDER BY
$orderByType = $_POST['orderByType'];
$orderBy = "LastLogin"; //default value
if (!empty($_POST['orderBy'])) {
    $orderBy = $_POST['orderBy'];
}

if ($sql = $conn -> query("SELECT LastLogin, COUNT(*) numOfUsers FROM users 
                                  WHERE (LastLogin >= '$lastLoginFrom' AND LastLogin <= '$lastLoginTo') 
                                  GROUP BY LastLogin
                                  ORDER BY $orderBy $orderByType")){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>Last log in Date</th>
        <th>Number of users</th>
        </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {

            $lastLoginDate = date("d-M-Y", strtotime($data['LastLogin']));
            echo "
        <tr>
            <td>$lastLoginDate</td>
            <td>$data[numOfUsers]</td>
        </tr>";
        }
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){

        while ($data = mysqli_fetch_assoc($sql))
        {

            $output[] = array(
                'year'   => date('Y', strtotime($data['LastLogin'])),
                'month'   => date('m', strtotime($data['LastLogin'])),
                'day'   => date('d', strtotime($data['LastLogin'])),
                'users'  => $data["numOfUsers"]
            );
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}