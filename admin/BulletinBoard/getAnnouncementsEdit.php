<?php
require '../../includes/Connection.php';
$sql = $conn -> query("SELECT * FROM bulletin_board ORDER BY CreationDate DESC");

while($r = mysqli_fetch_assoc($sql))
{
    $creationDate = date( "d-M-Y H:i", strtotime($r['CreationDate']));
    echo "<div class='editAnnoun' onclick='checkUncheck(this); showToEdit(this);'><p><input type='checkbox'>$r[Title]</p><p style='color: #999999; font-size: 14px;'>". $creationDate ."</p></div>";
    echo "  <div class='toEdit' hidden>  
                <!--ANNOUNCEMENT TITLE-->
                <div class='wrap-input wrap-login' id='Title' style='border: 2px solid #cccccc; width: 85%; margin-left: 3%;'>
                    <label class='lbl' for='title'>
                        <span>Title</span>
                    </label>
                    <input class='inp' id='title' type='text' name='title' maxlength='35' value='$r[Title]' required/>
        
                </div>
                <!--CONTENT-->
                <div class='wrap-input wrap-login' id='Content' style='border: 2px solid #cccccc; width: 85%; margin-left: 3%;'>
                    <label class='lbl' for='content'></label>
                    <textarea class='inp' style='width: 80%;' id='content' rows='6' cols='40' name='content' required >$r[Content]</textarea>
                </div>
                
                <img class='announcement-picture' src = 'http://localhost/Local%20Server/ConnectPlatform/BulletinBoard-images/$r[Picture]' alt = '' >
                
            </div>
            ";
}

$conn->close();
exit();