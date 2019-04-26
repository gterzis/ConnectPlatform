<?php  // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

$occupation = "%";
if (!empty($_POST['occupation']))
    $occupation=$_POST['occupation'];

//ORDER BY
$orderByType = $_POST['orderByType'];
$orderBy = "Occupation"; //default value
if (!empty($_POST['orderBy'])) {
    $orderBy = $_POST['orderBy'];
}

if ($sql = $conn -> query("SELECT Occupation, COUNT(*) numOfUsers FROM users WHERE Occupation LIKE '$occupation' 
                                  GROUP BY Occupation
                                  ORDER BY $orderBy $orderByType")){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>Occupation</th>
        <th>Number of users</th>
        </tr>";
        while ($data = mysqli_fetch_assoc($sql)) {

            echo "
        <tr>
            <td>$data[Occupation]</td>
            <td>$data[numOfUsers]</td>
        </tr>";
        }
    }
    // return details for chart
    elseif ($_GET['data'] == "chart"){

        while ($data = mysqli_fetch_assoc($sql))
        {

            $output[] = array(
                'occupation'   => $data['Occupation'],
                'users'  => $data["numOfUsers"]
            );
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}