<?php //called by Interests.php

// prevent users visit page improperly
if ( !$_SERVER["REQUEST_METHOD"] == "POST" ) {
    header("Location: ../../index.php");
    exit();
}

require_once '../../includes/Connection.php';
session_start();

$interestName ="%"; // if no interest name inserted
if (!empty($_POST['interestName'])){
    $interestName = $_POST['interestName'];
}

$interestCategory ="%";// if no category inserted
if (!empty($_POST['interestCategory'])){
    $interestCategory = $_POST['interestCategory'];
}

//Fetch interests based on input
$sql = $conn -> query("SELECT * FROM interests WHERE InterestName LIKE '$interestName' AND Category LIKE '$interestCategory' ORDER BY InterestName");

//Display interests for delete
if ($_GET['action'] == "delete") {
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<div class='deleteInterest' onclick='checkUncheck(this)'><p class='intrestName'><input type='checkbox'>" .
            "$r[InterestName]</p> &#9642;<p style='margin-left: 5px; color: #999999'>$r[Category]</p></div>";
    }
}
//Display interests for edit
else if ($_GET['action'] == "edit") {
    while ($r = mysqli_fetch_assoc($sql)) {
        echo "<div class='editInterest' onclick='checkUncheck(this); showToEdit(this);'><p style='display: inline-block;' class='intrestName'><input type='checkbox'>" .
            "$r[InterestName]</p> &#9642;<p style='margin-left: 5px; color: #999999; display: inline-block;'>$r[Category]</p></div>";
        echo "<div class='toEdit' hidden>
                                <!--INTEREST TITLE-->
            <div class=\"wrap-input wrap-login\" id=\"Title\" style=\"border: 2px solid #cccccc; width: 85%; margin-left: 3%;\">
                <label class=\"lbl\" for=\"title\" style=\"font-size: 14px;\">
                    <span>Title</span>
                </label>
                <input value='$r[InterestName]' class=\"inp\" style=\"margin: 10px; padding: 0px;\" id=\"title\" type=\"text\" name=\"title\" maxlength=\"35\" placeholder=\"Enter a title...\" required/>
            </div>
        
            <!--CATEGORY-->
            <div class=\"wrap-input wrap-login\" id=\"Category\" style=\"border: 2px solid #cccccc; width: 85%; margin-left: 3%;\">
                <label class=\"lbl\" for=\"category\" style=\"font-size: 14px;\">
                    <span>Category</span>
                </label>
                <input value='$r[Category]' class=\"inp\" id=\"category\" style=\"margin: 10px; padding: 0px; width: 68%;\" type=\"text\" name=\"title\" maxlength=\"35\" placeholder=\"Enter a title...\" required/>
            </div>
            
        </div>";
    }
}

$conn->close();
exit();