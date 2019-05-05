<?php

if (!empty($_POST["title"])) {
    $title = test_input($_POST["title"]);
}

if (!empty($_POST["content"])) {
    $content = test_input($_POST["content"]);
}

function test_input($data)
{
    $data = trim($data); //removes whitespace from both sides
    $data = stripslashes($data); //removes backslashes
    $data = htmlspecialchars($data);
    return $data;
}

require '../../includes/Connection.php';
// Check if announcement's title already exists
if ($stmt = $conn->prepare("SELECT Title FROM bulletin_board WHERE Title=? ") )
{
    /* bind parameters for markers */
    $stmt->bind_param("s",$title);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($result);

    /* fetch value */
    $stmt->fetch();

    if (!empty($result)) {
        $stmt->close();
        $conn->close();

        echo json_encode($array = array(" Title already exists. Please enter a new one.","Title"));
        exit();
    }

}
else {
    echo " Something went wrong. Try again later";
    $conn->close();
    exit();
}

// Insert new announcement (image not included)
if ($stmt = $conn->prepare("INSERT INTO bulletin_board (Title, Content ) VALUES (?,?)")) {
    // Bind the variables to the parameters.
    $stmt->bind_param("ss",$title, $content);

    // Execute the statement.
    $stmt->execute();

    // Close the prepared statement.
    $stmt->close();

    if (empty($_FILES["image"]["name"])) {
        echo json_encode("success");
        $conn->close();
        exit();
    }
}
else {
    echo json_encode(" Something went wrong. Try again later");
    $conn->close();
    exit();
}

if (!empty($_FILES["image"]["name"])) {
    // name the image with the announcement's id.
    // get the announcement's id.
    $sql = $conn->query("SELECT LAST_INSERT_ID() AS AnnouncementID");
    $annID = $sql->fetch_assoc();

    //IMAGE
    $temp = explode(".", $_FILES["image"]["name"]); // get the extension of the image
    $newfilename = $annID['AnnouncementID'] . '.' . end($temp);// name image
    // define the path which image is going to be stored
    $uploadfile = $_SERVER['DOCUMENT_ROOT'] . '/Local Server/ConnectPlatform/BulletinBoard-images/' .
        $newfilename;

    //store image in the defined path-directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {

        // Inserting data into database
        if ($stmt = $conn->prepare("UPDATE bulletin_board SET Picture = ? WHERE AnnouncementID = ?")) {
            // Bind the variables to the parameters.
            $stmt->bind_param("si", $newfilename, $annID['AnnouncementID']);

            // Execute the statement.
            $stmt->execute();

            // Close the prepared statement.
            $stmt->close();

            $conn->close();
        }
        echo json_encode("success");
        exit();
    } else {
        echo "Upload failed";
    }
}