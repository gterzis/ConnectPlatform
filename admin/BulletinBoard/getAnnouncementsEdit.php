<?php
require '../../includes/Connection.php';
$sql = $conn -> query("SELECT Title, Content FROM bulletin_board ");

while($r = mysqli_fetch_row($sql))
{
    echo "<div class='editAnnoun' onclick='checkUncheck(this); showToEdit(this);'><p><input type='checkbox'>$r[0]</p></div>";
echo "  <div class='toEdit' hidden>  
            <!--ANNOUNCEMENT TITLE-->
            <div class='wrap-input wrap-login' id='Title' style='border: 2px solid #cccccc; width: 85%; margin-left: 3%;'>
                <label class='lbl' for='title'>
                    <span>Title</span>
                </label>
                <input class='inp' id='title' type='text' name='title' maxlength='35' value='$r[0]' required/>
    
            </div>
            <!--CONTENT-->
            <div class='wrap-input wrap-login' id='Content' style='border: 2px solid #cccccc; width: 85%; margin-left: 3%;'>
                <label class='lbl' for='content'></label>
                <textarea class='inp' style='width: 80%;' id='content' rows='6' cols='40' name='content' required >$r[1]</textarea>
            </div>
        </div>
        ";
}

$conn->close();
exit();