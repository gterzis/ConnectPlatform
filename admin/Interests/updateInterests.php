<?php

$names = $_REQUEST['oldNames'];
$newNames = $_REQUEST['newNames'];
$newCategories = $_REQUEST['newCategories'];
$error = false;

//Data validation
for ($i = 0; $i < count($names); $i++){

    $names[$i] = test_input($names[$i]);

    //TITLE validation
    $newNames[$i] = test_input($newNames[$i]);
    //Check if only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $newNames[$i])) {
        $error = true;
        echo " Title: only letters and white space allowed";
        exit();
    }

    //CATEGORY validation
    $newCategories[$i] = test_input($newCategories[$i]);
    //Check if only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $newCategories[$i])) {
        $error = true;
        echo " Category: only letters and white space allowed";
        exit();
    }
}

//If no error has occurred in validation update data
if (!$error){
    require_once '../../includes/Connection.php';
    for ($i = 0; $i < count($names); $i++){

        if ($stmt = $conn->prepare("UPDATE interests SET InterestName = ?, Category = ? WHERE InterestName = ?"))
        {
            // Bind the variables to the parameters.
            $stmt->bind_param("sss", $newNames[$i], $newCategories[$i], $names[$i]);

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

$conn->close();
exit();
?>