<?php
require '../includes/Connection.php';
$sql = $conn -> query("SELECT * FROM bulletin_board ");

while($data = mysqli_fetch_row($sql))
{
    echo "<div class='announcement'>
                <h2>$data[0]</h2>
                <p style='padding: 0px 15px;'>
                $data[1]
                </p>
            </div>";
}

$conn->close();

?>