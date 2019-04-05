<?php // called by UsersReports.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../../index.php");
    exit();
}

require_once '../../includes/Connection.php';
session_start();

if($getUsers = $conn ->query("SELECT * FROM users ORDER BY Name") ) {
    echo "<tr>
        <th hidden>ID</th>
        <th>A/A</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Age</th>
        <th>Gender</th>
        <th>District</th>
        <th>Education</th>
        <th>Occupation</th>
        <th>Marital Status</th>
        <th>Registration Date</th>
        <th>Last Login</th>
        <th># Matches</th>
    </tr>";
    $numberOfUser = 1;
    while ($data = mysqli_fetch_assoc($getUsers)) {

        //Format registration date
        $registrationDate = date_create($data['RegistrationDate']);
        $registrationDate = date_format($registrationDate,'d-M-y');

        //Format Last Login date
        $lastLogin = date_create($data['LastLogin']);
        $lastLogin = date_format($lastLogin,'d-M-y');

        //Calculate the age of the user
        $currentDate = new DateTime(date("Y-m-d"));
        $age = $currentDate->diff(new DateTime($data['Birthdate'])); // get the difference between birthday and current date
        $age = $age->y; // get the year difference

        // Get the number of matches the user has
        $getNumberOfMatches = $conn ->query("SELECT COUNT(*) FROM matches WHERE (User1 = $data[ID] AND Active=1) OR (User2 = $data[ID] AND Active=1) ");
        $numberOfMatches = mysqli_fetch_row($getNumberOfMatches);

        echo "
        <tr onclick='showProfile(this);'>
            <td class='reports-userID' hidden>$data[ID]</td>
            <td>$numberOfUser</td>
            <td class='reports-name'>$data[Name]</td>
            <td class='reports-surname'>$data[Surname]</td>
            <td class='reports-age'>$age</td>
            <td class='reports-gender'>$data[Gender]</td>
            <td class='reports-district'>$data[District]</td>
            <td class='reports-education'>$data[Education]</td>
            <td class='reports-occupation'>$data[Occupation]</td>
            <td class='reports-marital'>$data[MaritalStatus]</td>
            <td class='reports-registration'>$registrationDate</td>
            <td class='reports-login'>$lastLogin</td>
            <td class='reports-matches'>$numberOfMatches[0]</td>
        </tr>";
        $numberOfUser++;
    }

}
else {
    echo mysqli_error($conn);
}