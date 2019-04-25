<?php // called by InterestsReports.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../index.php");
    exit();
}

require_once '../../../includes/Connection.php';
session_start();

//Interest Name
$interestName = "%";// default value. If user has no entered any value
if (!empty($_POST['interestName']))
    $interestName = test_input($_POST['interestName']);

//Category
$category = "%";
if (!empty($_POST['category'])){
    $category = test_input($_POST['category']);
}

//Interest (or Category) number of selected times range
$selectedFrom = $_POST['selectedFrom'];
$selectedTo = $_POST['selectedTo'];
if (!is_numeric($_POST['selectedFrom'])){
    $selectedFrom = 0;
    $selectedTo = 1000000;
}

//ACTIVE Matches
$activeFrom = $_POST['activeFrom'];
$activeTo = $_POST['activeTo'];
if (!is_numeric($_POST['activeFrom'])) {// if user has no entered values
    $activeFrom = 0;
    $activeTo = 1000000;
}

//DEACTIVATED Matches
$deactivatedFrom = $_POST['deactivatedFrom'];
$deactivatedTo = $_POST['deactivatedTo'];
if (!is_numeric($_POST['deactivatedFrom'])) {// if user has no entered values
    $deactivatedFrom = 0;
    $deactivatedTo = 1000000;
}

//TOTAL Matches ( active + deactivated )
$totalFrom = $_POST['totalFrom'];
$totalTo = $_POST['totalTo'];
if (!is_numeric($_POST['totalFrom'])) { // if user has no entered values
    $totalFrom = 0;
    $totalTo = 1000000;
}

//GROUP BY
$groupBy = $_POST['groupBy'];

//ORDER BY
$orderByType = $_POST['orderByType']; // ascending or descending sorting
$orderBy = "InterestName"; //default value
if (!empty($_POST['orderBy']))
    $orderBy = $_POST['orderBy'];

function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslash
    $data = htmlspecialchars($data);
    return $data;
}

//Get all interests detailed. Count total matches, active matches and no active matches
if($getInterests = $conn ->query("SELECT *, COUNT(Active) total, 
                                    sum(case when Active = 1 then 1 else 0 end) active, 
                                    sum(case when Active = 0 then 1 else 0 end) noActive 
                                    FROM (SELECT interests.InterestName, sum(case when UIID is null then 0 else 1 end) selected FROM interests LEFT JOIN usersinterests ON interests.InterestName = usersinterests.InterestName 
                                          GROUP BY interests.$groupBy
                                          HAVING selected >= $selectedFrom AND selected <= $selectedTo) selectedInterests 
                                          NATURAL JOIN 
                                          interests LEFT JOIN matches ON interests.InterestName = matches.MatchInterest
                                    WHERE (InterestName LIKE '$interestName') AND (Category LIKE '$category') 
                                    GROUP BY $groupBy 
                                    HAVING (active >= $activeFrom AND active <= $activeTo) AND 
                                            (noActive >= $deactivatedFrom AND noActive <= $deactivatedTo) AND
                                            (total >= $totalFrom AND total <= $totalTo) 
                                     ORDER BY $orderBy $orderByType") ) {
    echo "<tr>
        <th hidden>ID</th>
        <th>#</th>";
        if ($groupBy == "InterestName") echo "<th>Interest Name</th>";
        echo"
        <th>Category</th>
        <th>Selected</th>
        <th>Active Matches</th>
        <th>Deactivated Matches</th>
        <th>Total Matches</th>
    </tr>";

    $numberOfRow = 1; $totalInterestSelectedTimes = 0; $totalActive = 0;$totalDeactivated = 0;$totalMatches = 0;
    while ($data = mysqli_fetch_assoc($getInterests)) {
        $totalActive += $data['active']; $totalDeactivated += $data['noActive']; $totalMatches += $data['total'];
        $totalInterestSelectedTimes += $data['selected'];
        echo "
        <tr>
            <td class='reports-interestID' hidden>$data[InterestID]</td>
            <td>$numberOfRow</td>";
            if ($groupBy == "InterestName") echo "<td class='reports-interestName'>$data[InterestName]</td>";
        echo"
            <td class='reports-category'>$data[Category]</td>
            <td class='reports-category'>$data[selected]</td>
            <td class='reports-active'>$data[active]</td>
            <td class='reports-noActive'>$data[noActive]</td>
            <td class='reports-total'>$data[total]</td>
        </tr>";
        $numberOfRow++;
    }
    //Print the footer of the table with the total numbers for each column
    $numberOfRow--;
    echo "<tr>
        <th hidden>ID</th>
        <th>Total</th>";
    if ($groupBy == "InterestName") echo "<th>$numberOfRow</th>";
    echo"
        <th>$numberOfRow</th>
        <th>$totalInterestSelectedTimes</th>
        <th>$totalActive</th>
        <th>$totalDeactivated</th>
        <th>$totalMatches</th>
    </tr>";

}
else {
    echo mysqli_error($conn);
}