<?php // called by InterestsReports.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../index.php");
    exit();
}

require_once '../../../includes/Connection.php';
session_start();

//Get all interests detailed. Count total matches, active matches and no active matches
if($getInterests = $conn ->query("SELECT *, COUNT(Active) total, 
                                    sum(case when Active = 1 then 1 else 0 end) active, 
                                    sum(case when Active = 0 then 1 else 0 end) noActive 
                                    FROM (SELECT interests.InterestName, sum(case when UIID is null then 0 else 1 end) selected FROM interests LEFT JOIN usersinterests ON interests.InterestName = usersinterests.InterestName 
                                          GROUP BY interests.InterestName) selectedInterests
                                          NATURAL JOIN 
                                          interests LEFT JOIN matches ON interests.InterestName = matches.MatchInterest 
                                    GROUP BY InterestName") ) {
    echo "<tr>
        <th hidden>ID</th>
        <th>#</th>
        <th>Interest Name</th>
        <th>Category</th>
        <th>Selected</th>
        <th>Active Matches</th>
        <th>Deactivated Matches</th>
        <th>Total Matches</th>
    </tr>";
    $numberOfRow = 1; $totalInterestSelectedTimes = 0; $totalActive = 0;$totalDeactivated = 0;$totalMatches = 0;
    while ($data = mysqli_fetch_assoc($getInterests)) {
        $totalInterestSelectedTimes += $data['selected']; $totalActive += $data['active']; $totalDeactivated += $data['noActive']; $totalMatches += $data['total'];
        echo "
        <tr>
            <td class='reports-userID' hidden>$data[InterestID]</td>
            <td>$numberOfRow</td>
            <td class='reports-interestName'>$data[InterestName]</td>
            <td class='reports-category'>$data[Category]</td>
            <td class='reports-selected'>$data[selected]</td>
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
        <th>Total</th>
        <th>$numberOfRow</th>
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