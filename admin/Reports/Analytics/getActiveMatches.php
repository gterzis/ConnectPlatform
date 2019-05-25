<?php   // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

//Interest (or Category) number of selected times range
$activeFrom = $_POST['activeFrom'];
$activeTo = $_POST['activeTo'];
if (!is_numeric($_POST['activeFrom'])){
    $activeFrom = 0;
    $activeTo = 1000000;
}

//GROUP BY
$groupBy = $_POST['groupBy'];

//ORDER BY
$orderByType = $_POST['orderByType']; // ascending or descending sorting
$orderBy = "InterestName"; //default value
if (!empty($_POST['orderBy']))
    $orderBy = $_POST['orderBy'];

if($sql = $conn ->query("SELECT interests.$groupBy interestName, sum(case when Active = 1 then 1 else 0 end) active 
                                  FROM interests LEFT JOIN matches ON interests.InterestName = matches.MatchInterest 
                                  GROUP BY $groupBy
                                  HAVING active >= $activeFrom AND active <= $activeTo
                                  ORDER BY $orderBy $orderByType")) {
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "
        <tr>
            <th>Interest</th>
            <th>Active Matches</th>
        </tr>";
        $total = 0;
        while ($data = mysqli_fetch_assoc($sql)) {
            $total += $data['active'];
            echo "
            <tr>
                <td>$data[interestName]</td>
                <td>$data[active]</td>
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
                'active'  => $data["active"]
            );
        }
        echo json_encode($output);
    }

}
else {
    echo mysqli_error($conn);
}