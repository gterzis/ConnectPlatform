<?php // called by UsersReports.php

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
        <th>Name</th>
        <th>Category</th>
        <th>Active Matches</th>
        <th>Deactivated Matches</th>
        <th>Total Matches</th>
    </tr>";
    $numberOfInterest = 1;
    while ($data = mysqli_fetch_assoc($getInterests)) {

        echo "
        <tr>
            <td class='reports-userID' hidden>$data[InterestID]</td>
            <td>$numberOfInterest</td>
            <td class='reports-name'>$data[InterestName]</td>
            <td class='reports-surname'>$data[Category]</td>
            <td class='reports-age'>$data[active]</td>
            <td class='reports-gender'>$data[noActive]</td>
            <td class='reports-district'>$data[total]</td>
        </tr>";
        $numberOfInterest++;
    }

}
else {
    echo mysqli_error($conn);
}