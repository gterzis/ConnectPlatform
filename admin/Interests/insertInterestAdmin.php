<?php

$titles = $_REQUEST['titles'];
$categories = $_REQUEST['categories'];
$interests[] = array();
$interests = array_combine($titles, $categories);
$error = false;
require_once '../../includes/Connection.php';

$index =0;
//Data validation
foreach( $interests as $title => $category){

    //TITLE validation
    $title = test_input($title);
    //Check if only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $title)) {
        $error = true;
        $responseArray=["errorMessage" => " Title: only letters and white space allowed", "field"=>"Title", "index" => $index ];
        echo json_encode($responseArray);
        $conn->close();
        exit();
    }

    //check if the name of the interest already exists
    if ($sql = $conn->prepare("SELECT InterestName FROM interests WHERE InterestName = ? "))
    {
        // Bind the variables to the parameters.
        $sql->bind_param("s", $title);

        // Execute the statement.
        $sql->execute();

        /* Bind results */
        $sql -> bind_result($result);

        /* Fetch the value */
        $sql -> fetch();

        if (!empty($result)){
            $error = true;
            $sql->close();
            $responseArray=["errorMessage" => " Interest name already exists", "field"=>"Title", "index" => $index ];
            echo json_encode($responseArray);
            $conn->close();
            exit();
        }
        // Close the prepared statement.
        $sql->close();

    }
    //CATEGORY validation
    $category = test_input($category);
    //Check if only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $category)) {
        $error = true;
        $responseArray=["errorMessage"=>" Category: only letters and white space allowed", "field"=>"Category", "index" => $index];
        echo json_encode($responseArray);
        $conn->close();
        exit();
    }
    $index++;
}

//If no error has occurred in validation insert data
if (!$error){
    foreach( $interests as $title => $category){

        if ($stmt = $conn->prepare("INSERT INTO interests (InterestName, Category) VALUES (?,?)"))
        {
            // Bind the variables to the parameters.
            $stmt->bind_param("ss", $title, $category);

            // Execute the statement.
            $stmt->execute();

            // Close the prepared statement.
            $stmt->close();

        }
        else
            echo "fail";
    }

    $responseArray=["result" => "success"];
    echo json_encode($responseArray);
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

