<?php   // called by Analytics.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../../index.php");
    exit();
}

require '../../../includes/Connection.php';
session_start();

//Interest (or Category) number of selected times range
$selectedFrom = $_POST['selectedFrom'];
$selectedTo = $_POST['selectedTo'];
if (!is_numeric($_POST['selectedFrom'])){
    $selectedFrom = 0;
    $selectedTo = 1000000;
}

//Group By
$groupBy = $_POST['groupBy'];

//ORDER BY
$orderByType = $_POST['orderByType']; // ascending or descending sorting
$orderBy = "InterestName"; //default value
if (!empty($_POST['orderBy']))
    $orderBy = $_POST['orderBy'];

if($sql = $conn ->query("SELECT interests.$groupBy interestName, sum(case when UIID is null then 0 else 1 end) selected 
                                  FROM interests LEFT JOIN usersinterests ON interests.InterestName = usersinterests.InterestName  
                                  GROUP BY $groupBy
                                  HAVING selected >= $selectedFrom AND selected <= $selectedTo
                                  ORDER BY $orderBy $orderByType")) {
    //echo table details
    if ($_GET['data'] == "table")
    {
        echo "
        <tr>
            <th>Interest</th>
            <th>Selected</th>
        </tr>";
        $total = 0;
        while ($data = mysqli_fetch_assoc($sql)) {
            $total += $data['selected'];
            echo "
            <tr>
                <td>$data[interestName]</td>
                <td>$data[selected]</td>
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
                'selected'  => $data["selected"]
            );
        }
        echo json_encode($output);
    }

}
else {
    echo mysqli_error($conn);
}