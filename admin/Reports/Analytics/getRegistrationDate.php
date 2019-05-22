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
$registrationDateFrom = date("Y-m-d", strtotime('1920-01-01')); // if the user has no entered a value, this is the default.
if(!empty($_POST['registrationDateFrom']))
    $registrationDateFrom = $_POST['registrationDateFrom'];// get the value

//To
$registrationDateTo = date("Y-m-d");
if (!empty($_POST['registrationDateTo']))
    $registrationDateTo = $_POST['registrationDateTo'];

//ORDER BY
$orderByType = $_POST['orderByType'];
$orderBy = "RegistrationDate"; //default value
if (!empty($_POST['orderBy'])) {
    $orderBy = $_POST['orderBy'];
}

//Registration date range
$range = $_POST['registrationDateRange'];

switch ($range) {
    case "custom":
        $rangeSql ="SELECT RegistrationDate, COUNT(*) numOfUsers FROM users
                                 WHERE (RegistrationDate >= '$registrationDateFrom' AND RegistrationDate <= '$registrationDateTo')
                                 GROUP BY RegistrationDate
                                 ORDER BY $orderBy $orderByType";
        break;
    case "lastWeek":
        $registrationDateFrom = date('Y-m-d', strtotime('-6 days')); //six days before
        $registrationDateTo = date("Y-m-d"); //today
        $rangeSql ="SELECT RegistrationDate, COUNT(*) numOfUsers FROM users
                                 WHERE (RegistrationDate >= '$registrationDateFrom' AND RegistrationDate <= '$registrationDateTo')
                                 GROUP BY RegistrationDate
                                 ORDER BY $orderBy $orderByType";
        break;
    case "lastMonth":
        $registrationDateFrom = date('Y-m-01'); //first day of current month
        $registrationDateTo = date("Y-m-d"); //today
        $rangeSql ="SELECT RegistrationDate, COUNT(*) numOfUsers FROM users
                                 WHERE (RegistrationDate >= '$registrationDateFrom' AND RegistrationDate <= '$registrationDateTo')
                                 GROUP BY RegistrationDate
                                 ORDER BY $orderBy $orderByType";
        break;
    case "lastYear":
        $registrationDateFrom = date('Y-m-d', strtotime('-1 year'));
        $registrationDateTo = date("Y-m-d"); //today
        $rangeSql = "SELECT MONTH(RegistrationDate) as perMonth, COUNT(*) numOfUsers FROM users 
                                  WHERE (RegistrationDate >= '$registrationDateFrom' AND RegistrationDate <= '$registrationDateTo') 
                                  GROUP BY perMonth
                                  ORDER BY $orderBy $orderByType";
        break;
        case "perYear":
        $registrationDateFrom = date('2017-01-01');
        $registrationDateTo = date("Y-m-d"); //today
        $rangeSql = "SELECT YEAR(RegistrationDate) as perYear, COUNT(*) numOfUsers FROM users 
                                  WHERE (RegistrationDate >= '$registrationDateFrom' AND RegistrationDate <= '$registrationDateTo') 
                                  GROUP BY perYear
                                  ORDER BY $orderBy $orderByType";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}


if ($sql = $conn -> query($rangeSql)){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>Registration Date</th>
        <th>Number of users</th>
        </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {
            $registrationDate = date("d-M-Y", strtotime($data['RegistrationDate']));

            if ($range == "lastYear"){
                $monthNum  = $data['perMonth'];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $registrationDate = $dateObj->format('F');
            }
            elseif ($range == "perYear"){
                $registrationDate = $data['perYear'];
            }
            echo "
            <tr>
                <td>$registrationDate</td>
                <td>$data[numOfUsers]</td>
            </tr>";
            }
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){

        while ($data = mysqli_fetch_assoc($sql))
        {
            if ($range == "lastYear"){
                $monthNum  = $data['perMonth'];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $registrationDate = $dateObj->format('F');
                $output[] = array(
                    'registrationDate' => $registrationDate,
                    'users' => $data["numOfUsers"]
                );
            }
            elseif ($range == "perYear"){
                $registrationDate = $data['perYear'];
                $output[] = array(
                    'registrationDate' => $registrationDate,
                    'users' => $data["numOfUsers"]
                );
            }
            else {
                $output[] = array(
                    'year' => date('Y', strtotime($data['RegistrationDate'])),
                    'month' => date('m', strtotime($data['RegistrationDate'])),
                    'day' => date('d', strtotime($data['RegistrationDate'])),
                    'users' => $data["numOfUsers"]
                );
            }
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}