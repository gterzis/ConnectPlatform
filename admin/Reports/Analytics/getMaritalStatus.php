<?php // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

$maritalStatus = "%";
if (!empty($_POST['maritalStatus']))
    $maritalStatus=$_POST['maritalStatus'];

//ORDER BY
$orderByType = $_POST['orderByType'];
$orderBy = "MaritalStatus"; //default value
if (!empty($_POST['orderBy'])) {
    $orderBy = $_POST['orderBy'];
}

if ($sql = $conn -> query("SELECT MaritalStatus, COUNT(*) numOfUsers FROM users WHERE MaritalStatus LIKE '$maritalStatus' 
                                  GROUP BY MaritalStatus
                                  ORDER BY $orderBy $orderByType")){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>Marital status</th>
        <th>Number of users</th>
        </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {

            echo "
        <tr>
            <td>$data[MaritalStatus]</td>
            <td>$data[numOfUsers]</td>
        </tr>";
        }
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){

        while ($data = mysqli_fetch_assoc($sql))
        {

            $output[] = array(
                'maritalStatus'   => $data['MaritalStatus'],
                'users'  => $data["numOfUsers"]
            );
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}
