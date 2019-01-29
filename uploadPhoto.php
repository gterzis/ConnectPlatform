<?php
session_start();
require './includes/Connection.php';

//$image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); //SQL Injection defence!
//$image_name = addslashes($_FILES['image']['name']);
$temp = explode(".", $_FILES["image"]["name"]);
$newfilename = $_SESSION['user_id'] . '.' . end($temp);

$uploadfile = $_SERVER['DOCUMENT_ROOT']. '/Local Server/ConnectPlatform/profile-pictures/' .
                $newfilename;

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