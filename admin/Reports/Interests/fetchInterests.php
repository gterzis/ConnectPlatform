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
                                    FROM interests LEFT JOIN matches ON interests.InterestName = matches.MatchInterest 
                                    GROUP BY InterestName") ) {
    echo "<tr>
        <th hidden>ID</th>
        <th>#</th>
        <th>Interest Name</th>
        <th>Category</th>
        <th>Active Matches</th>
        <th>Deactivated Matches</th>
        <th>Total Matches</th>
    </tr>";
    $numberOfRow = 1; $totalActive = 0;$totalDeactivated = 0;$totalMatches = 0;
    while ($data = mysqli_fetch_assoc($getInterests)) {
        $totalActive += $data['active']; $totalDeactivated += $data['noActive']; $totalMatches += $data['total'];
        echo "
        <tr>
            <td class='reports-userID' hidden>$data[InterestID]</td>
            <td>$numberOfRow</td>
            <td class='reports-name'>$data[InterestName]</td>
            <td class='reports-surname'>$data[Category]</td>
            <td class='reports-age'>$data[active]</td>
            <td class='reports-gender'>$data[noActive]</td>
            <td class='reports-district'>$data[total]</td>
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
        <th>$totalActive</th>
        <th>$totalDeactivated</th>
        <th>$totalMatches</th>
    </tr>";
}
else {
    echo mysqli_error($conn);
}