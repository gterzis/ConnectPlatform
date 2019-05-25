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


//Registration date range
$range = $_POST['lastLoginRange'];

switch ($range) {
    case "custom":
        $rangeSql ="SELECT LastLogin, COUNT(*) numOfUsers FROM users 
                                  WHERE (LastLogin >= '$lastLoginFrom' AND LastLogin <= '$lastLoginTo') 
                                  GROUP BY LastLogin
                                  ORDER BY $orderBy $orderByType";
        break;
    case "lastWeek":
        $lastLoginFrom = date('Y-m-d', strtotime('-6 days')); //six days before
        $lastLoginTo = date("Y-m-d"); //today
        $rangeSql ="SELECT LastLogin, COUNT(*) numOfUsers FROM users 
                                  WHERE (LastLogin >= '$lastLoginFrom' AND LastLogin <= '$lastLoginTo') 
                                  GROUP BY LastLogin
                                  ORDER BY $orderBy $orderByType";
        break;
    case "lastMonth":
        $lastLoginFrom = date('Y-m-01'); //first day of current month
        $lastLoginTo = date("Y-m-d"); //today
        $rangeSql ="SELECT LastLogin, COUNT(*) numOfUsers FROM users 
                                  WHERE (LastLogin >= '$lastLoginFrom' AND LastLogin <= '$lastLoginTo') 
                                  GROUP BY LastLogin
                                  ORDER BY $orderBy $orderByType";

        break;
    case "lastYear":
        $lastLoginFrom = date('Y-m-d', strtotime('-1 year'));
        $lastLoginTo = date("Y-m-d"); //today
        $rangeSql ="SELECT MONTH(LastLogin) perMonth, COUNT(*) numOfUsers FROM users 
                                  WHERE (LastLogin >= '$lastLoginFrom' AND LastLogin <= '$lastLoginTo') 
                                  GROUP BY perMonth
                                  ORDER BY $orderBy $orderByType";

        break;
    case "perYear":
        $lastLoginFrom = date('2017-01-01');
        $lastLoginTo = date("Y-m-d"); //today
        $rangeSql ="SELECT YEAR(LastLogin) perYear, COUNT(*) numOfUsers FROM users 
                                  WHERE (LastLogin >= '$lastLoginFrom' AND LastLogin <= '$lastLoginTo') 
                                  GROUP BY perYear
                                  ORDER BY $orderBy $orderByType";
        break;
    default:
        echo "Something went wrong !";
}

if ($sql = $conn -> query($rangeSql)){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "
        <tr>
            <th>Last log in Date</th>
            <th>Number of users</th>
        </tr>";
        $total = 0;
        while ($data = mysqli_fetch_assoc($sql)) {

            $lastLoginDate = date("d-M-Y", strtotime($data['LastLogin']));
            $total += $data['numOfUsers'];

            if ($range == "lastYear"){
                $monthNum  = $data['perMonth'];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $lastLoginDate = $dateObj->format('F');
            }
            elseif ($range == "perYear"){
                $lastLoginDate = $data['perYear'];
            }
            echo "
            <tr>
                <td>$lastLoginDate</td>
                <td>$data[numOfUsers]</td>
            </tr>";
        }
        echo "
        <tr>
            <th>Total</th>
            <th>$total</th>
        </tr>";
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){

        while ($data = mysqli_fetch_assoc($sql))
        {
            if ($range == "lastYear"){
                $monthNum  = $data['perMonth'];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $lastLoginDate = $dateObj->format('F');
                $output[] = array(
                    'lastLoginDate' => $lastLoginDate,
                    'users' => $data["numOfUsers"]
                );
            }
            elseif ($range == "perYear"){
                $lastLoginDate = $data['perYear'];
                $output[] = array(
                    'lastLoginDate' => $lastLoginDate,
                    'users' => $data["numOfUsers"]
                );
            }
            else {
                $output[] = array(
                    'year' => date('Y', strtotime($data['LastLogin'])),
                    'month' => date('m', strtotime($data['LastLogin'])),
                    'day' => date('d', strtotime($data['LastLogin'])),
                    'users' => $data["numOfUsers"]
                );
            }
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}