<?php
$oldTitles = $_REQUEST['oldTitles'];
$newTitles = $_REQUEST['newTitles'];
$newContents = $_REQUEST['newContents'];
$error = false;

for ($i=0; $i<count($oldTitles); $i++){

    //Data validation
    $newTitles[$i] = test_input($newTitles[$i]);
    $newContents[$i] = test_input($newContents[$i]);

    require '../../includes/Connection.php';
    // Check if announcement's title already exists, if new title is not equal to the respective old one.
    if ( ( $stmt = $conn->prepare("SELECT Title FROM bulletin_board WHERE Title=? ") ) AND ($newTitles[$i] != $oldTitles[$i]) )
    {
        /* bind parameters for markers */
        $stmt->bind_param("s",$newTitles[$i]);

        /* execute query */
        $stmt->execute();

        /* bind result variables */
        $stmt->bind_result($result);

        /* fetch value */
        $stmt->fetch();

        if (!empty($result)) {
            $stmt->close();
            $conn->close();

            echo " Title already exists. Please enter a new one.";
            $error = true;
            exit();
        }
    }

}

//If no error has occurred in validation update data
if (!$error){
    require_once '../../includes/Connection.php';
    for ($i = 0; $i < count($oldTitles); $i++){

        if ($stmt = $conn->prepare("UPDATE bulletin_board SET Title = ?, Content = ? WHERE Title = ?"))
        {
            // Bind the variables to the parameters.
            $stmt->bind_param("sss", $newTitles[$i], $newContents[$i], $oldTitles[$i]);

            // Execute the statement.
            $stmt->execute();

            // Close the prepared statement.
            $stmt->close();

            $response = "success";

        }
        else {
            $response = "fail";
            break;
        }
    }
    echo $response;
}

function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslashes
    $data = htmlspecialchars($data);
    return $data;
}