<?php
require '../includes/Connection.php';
$sql = $conn -> query("SELECT * FROM bulletin_board ORDER BY CreationDate DESC ");

while($data = mysqli_fetch_assoc($sql))
{
    $creationDate = date( "d-M-Y H:i", strtotime($data['CreationDate']));
    echo "<div class='announcement'>
                <h2>$data[Title]</h2>
                <p class='creationDate'>$creationDate</p>";
    if (!empty($data['Picture'])){
        echo "<img class='announcement-picture' src = 'http://localhost/Local%20Server/ConnectPlatform/BulletinBoard-images/$data[Picture]' alt = '' >";
    }
    echo "<p style='padding: 0px 15px;'>
                $data[Content]
                </p>
            </div>";
}

$conn->close();

?>