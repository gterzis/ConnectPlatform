<?php
session_start();
require './includes/Connection.php';

//$image = addslashes(file_get_contents($_FILES['image']['tmp_name'])); //SQL Injection defence!
//$image_name = addslashes($_FILES['image']['name']);

$uploadfile = $_SERVER['DOCUMENT_ROOT']. '/Local Server/ConnectPlatform/profile-pictures/' .
                basename($_FILES['image']['name']);

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Upload failed";
}

// Inserting data into database
if ($stmt = $conn->prepare("UPDATE users SET Photo = ? WHERE ID = ?")) {
    // Bind the variables to the parameters.
    $stmt->bind_param("si", $image,$_SESSION['user_id']);

    // Execute the statement.
    $stmt->execute();

    // Close the prepared statement.
    $stmt->close();

    echo "success";
}

echo mysqli_error($conn);