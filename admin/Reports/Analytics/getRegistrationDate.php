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

if ($sql = $conn -> query("SELECT RegistrationDate, COUNT(*) numOfUsers FROM users 
                                  WHERE (RegistrationDate >= '$registrationDateFrom' AND RegistrationDate <= '$registrationDateTo') 
                                  GROUP BY RegistrationDate
                                  ORDER BY $orderBy $orderByType")){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>Registration Date</th>
        <th>Number of users</th>
        </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {

        $registrationDate = date("d-M-Y", strtotime($data['RegistrationDate']));
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

            $output[] = array(
                'year'   => date('Y', strtotime($data['RegistrationDate'])),
                'month'   => date('m', strtotime($data['RegistrationDate'])),
                'day'   => date('d', strtotime($data['RegistrationDate'])),
                'users'  => $data["numOfUsers"]
            );
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}