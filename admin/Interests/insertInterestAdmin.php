<?php

$titles = $_REQUEST['titles'];
$categories = $_REQUEST['categories'];
$interests[] = array();
$interests = array_combine($titles, $categories);
$error = false;

//Data validation
foreach( $interests as $title => $category){

    //TITLE validation
    $title = test_input($title);
    //Check if only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $title)) {
        $error = true;
        echo " Title: only letters and white space allowed";
        exit();
    }

    //CATEGORY validation
    $category = test_input($category);
    //Check if only contains letters, whitespace and starts with letter.
    if (!preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $category)) {
        $error = true;
        echo " Category: only letters and white space allowed";
        exit();
    }

}

//If no error has occurred in validation insert data
if (!$error){
    require_once '../../includes/Connection.php';
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

    echo "success";
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