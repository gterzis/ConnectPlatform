<?php
session_start();
require './includes/Connection.php';

$temp = explode(".", $_FILES["image"]["name"]); // get the extension of the image
$newfilename = $_SESSION['user_id'] . '.' . end($temp);// name image
// define the path which image is going to be stored
$uploadfile = $_SERVER['DOCUMENT_ROOT']. '/Local Server/ConnectPlatform/profile-pictures/' .
                $newfilename;

//store image in the defined path-directory
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {

    // Inserting data into database
    if ($stmt = $conn->prepare("UPDATE users SET Photo = ? WHERE ID = ?")) {
        // Bind the variables to the parameters.
        $stmt->bind_param("si", $newfilename,$_SESSION['user_id']);

        // Execute the statement.
        $stmt->execute();

        // Close the prepared statement.
        $stmt->close();

        $conn->close();
    }
    header("Location: /Local Server/ConnectPlatform/Profile.php?success=true");
    die();
}
else
{
    echo "Upload failed";
}



echo mysqli_error($conn);