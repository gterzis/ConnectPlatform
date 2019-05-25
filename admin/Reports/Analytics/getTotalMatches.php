<?php   // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

//Interest (or Category) number of selected times range
$totalFrom = $_POST['totalFrom'];
$totalTo = $_POST['totalTo'];
if (!is_numeric($_POST['totalFrom'])){
    $totalFrom = 0;
    $totalTo = 1000000;
}

//Group By
$groupBy = $_POST['groupBy'];

//ORDER BY
$orderByType = $_POST['orderByType']; // ascending or descending sorting
$orderBy = "InterestName"; //default value
if (!empty($_POST['orderBy']))
    $orderBy = $_POST['orderBy'];

if($sql = $conn ->query("SELECT interests.$groupBy interestName, COUNT(Active) total 
                                  FROM interests LEFT JOIN matches ON interests.InterestName = matches.MatchInterest 
                                  GROUP BY $groupBy
                                  HAVING total >= $totalFrom AND total <= $totalTo
                                  ORDER BY $orderBy $orderByType")) {
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "
        <tr>
            <th>Interest</th>
            <th>Total Matches</th>
        </tr>";
        $total = 0;
        while ($data = mysqli_fetch_assoc($sql)) {
            $total += $data['total'];
            echo "
            <tr>
                <td>$data[interestName]</td>
                <td>$data[total]</td>
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
                'interest'   => $data["interestName"],
                'total'  => $data["total"]
            );
        }
        echo json_encode($output);
    }

}
else {
    echo mysqli_error($conn);
}