<?php   // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

$district = "%";
if (!empty($_POST['district']))
    $district=$_POST['district'];

if ($sql = $conn -> query("SELECT District, COUNT(*) numOfUsers FROM users WHERE District LIKE '$district' GROUP BY District")){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>District</th>
        <th>Number of users</th>
        </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {

            echo "
        <tr>
            <td>$data[District]</td>
            <td>$data[numOfUsers]</td>
        </tr>";
        }
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){

        while ($data = mysqli_fetch_assoc($sql))
        {

            $output[] = array(
                'district'   => $data['District'],
                'users'  => $data["numOfUsers"]
            );
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}