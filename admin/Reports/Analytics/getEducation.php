<?php // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

$education = "%";
if (!empty($_POST['education']))
    $education=$_POST['education'];

//ORDER BY
$orderByType = $_POST['orderByType'];
$orderBy = "Education"; //default value
if (!empty($_POST['orderBy'])) {
    $orderBy = $_POST['orderBy'];
}

if ($sql = $conn -> query("SELECT Education, COUNT(*) numOfUsers FROM users WHERE Education LIKE '$education' 
                                  GROUP BY education
                                  ORDER BY $orderBy $orderByType")){
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "<tr>
        <th>Education</th>
        <th>Number of users</th>
        </tr>";
        $total = 0;
        while ($data = mysqli_fetch_assoc($sql)) {
            $total += $data['numOfUsers'];
            echo "
            <tr>
                <td>$data[Education]</td>
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

            $output[] = array(
                'education'   => $data['Education'],
                'users'  => $data["numOfUsers"]
            );
        }
        echo json_encode($output);
    }
}else {
    echo mysqli_error($conn);
}