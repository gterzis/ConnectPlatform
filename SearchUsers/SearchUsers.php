<?php
session_start();

//if user is not logged-in is being redirected
if(!isset($_SESSION['user_id']))
{
    header("Location: index.php");
    exit();
}

$adult= date("Y") - 18;
$field="none";
//Show error message
if(!empty($_GET['ErrMess'])) {
    $error_msg = base64_decode($_GET['ErrMess']);
    $field = $_GET['field'];
    $dialogBox = preg_replace("/ /", "%20", "http://localhost/Local%20Server/ConnectPlatform/includes/DialogBox.php?Error=$error_msg");
    echo file_get_contents($dialogBox);
}

if (!isset($_SESSION['gender']))
    $_SESSION['gender'] = "";
?>

<!DOCTYPE html>
<html style="height: 100%; background-color: #f1f1f1;">

<head>
    <title>Get in Touch - Search for people</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/indexStyle.css" >
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/checkBoxStyle.css"><!--check box style-->
    <script>
        $(document).ready(function(){
            //Set red shadow to the respective field.
            $("#<?php echo $field; ?>").css("box-shadow", "0 0 5px red");

        });
    </script>
</head>
<style>
    .wrap-input{
        height: auto;
    }


</style>
<body style="margin: 0px;">

<!--Loading Spinner-->
<div class="preload"><img src="../images/Spinner.gif">
</div>

<!--PAGE'S CONTENT-->
<div class="SearchUsers-pagecontent" hidden>
<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/userHeader.php"); ?>

<!--Place change password, edit information window-->
<div id="modal-box"></div>

<!--SIGN UP FORM-->
<form class="frm" onsubmit="return showSearchResults();">

    <h2>Search for people</h2>

    <!--AGE-->
    <div class="wrap-input" id="Bday" style="float: left;">
        <label class="lbl" for="bday">
            <span >Age</span>
        </label>
        <input class="inp" type="number" id="minAge" style="border: #cccccc solid 1px; width: 20%" min="18"  placeholder="From" required>
        <input class="inp" type="number" id="maxAge" style="border: #cccccc solid 1px; width: 20%"  max="99"  placeholder="To" required>
    </div>

    <!--GENDER-->
    <div class="wrap-input" id="Gender" style="float: left; padding: 17px 0px;">

        <label class="lbl" for="gender">
            <span class="fa fa-venus-mars"></span>
        </label>

        <label class="pure-material-checkbox">
            <input type="checkbox" name="gender" id="male" checked="checked">
            <span>Male</span>
        </label>

        <label class="pure-material-checkbox">
            <input type="checkbox" name="gender" id="female" checked="checked">
            <span>Female</span>
        </label>

    </div>

    <!-- DISTRICT-->
    <div class="wrap-input" id="District" style="float: left;">
        <label class="lbl" for="autocomplete">
            <span class="fa fa-home"></span>
        </label>
        <input class="inp" id="autocomplete" type="text" name="district" minlength="2" maxlength="100" placeholder="District">
    </div>
    <!-- Autocomplete places api -->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/places.html"); ?>

    <!-- EDUCATION-->
    <div class="wrap-input" id="Education" style="float: left;">
        <label class="lbl" for="education">
            <span class="fa fa-mortar-board"></span>
        </label>
        <input class="inp" id="education" onFocus="geolocate()" type="text" name="education" minlength="2" maxlength="25" placeholder="Education">
    </div>

    <!--SEARCH INTEREST-->
    <div class="wrap-input" style="float: left;">
        <label class="lbl" for="search">
            <span class="fa fa-search"></span>
        </label>
        <input class="inp" id="search" maxlength="25" placeholder="Search for interest..." autocomplete="off"/>
    </div>

    <!-- MARITAL STATUS-->
    <div class="wrap-input" id="Marital-Status" style="float: left;" >
        <label class="lbl" for="education">
            <span class="fa fa-heart"></span>
        </label>
        <select class="inp" id="marital-status" name="marital-status" style="cursor: pointer">
            <option value="" disabled selected>Select marital status</option>
            <option value="Any">Any</option>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
            <option value="Widowed">Widowed</option>
        </select>
    </div>

    <!--Autocomplete for interests-->
    <?php echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/Profile/autocomplete.php?all=true"); ?>

    <div id="chosen-interests" style="float: left; height: auto; width: inherit; margin: 0px 15px 15px 15px;">
        <!-- User's chosen interests will be placed here-->
    </div>

    <!--BUTTON-->
    <div style="display: block; ">
        <button type="button" onclick="location.href='http://localhost/Local%20Server/ConnectPlatform/Profile.php';" class="btn" style="text-decoration: none; float: left; margin-left: 90px;">
            <i class="fa fa-arrow-left"></i> BACK</button>
        <button class="btn" type="submit" style="float: left;">SEARCH</button>
    </div>


</form>

</div>

</body>

</html>
<script>
    //Add box shadow on input fields when focus
    $.getScript( "http://localhost/Local%20Server/ConnectPlatform/includes/inputBoxShadow.js" );

    //Prevents user to enter any language except English
    $.getScript( "http://localhost/Local%20Server/ConnectPlatform/includes/onlyEnglish.js" );
    //All above do not work when put in <head> :(

    function showSearchResults() {
        $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/SearchUsers/searchResults.php");
        return false;
    }

    //Hide spinner and show page
    $(function() {
        $(".preload").fadeOut(500, function() {
            $(".SearchUsers-pagecontent").fadeIn(500);
        });
    });

    var minFirstClick = true;
    //Dont let min age surpass max age
    $("#minAge").on('keyup mouseup', function () {
        var minAge = $(this).val();
        var maxAge = $(this).siblings("input").val();
        if (minAge >= maxAge){
            $(this).prop('max', maxAge);
        }
        if (minAge > maxAge){
            $(this).siblings("input").prop('min', minAge);
        }
    });

    var maxFirstClick = true;
    //Dont let max age go under min age
    $("#maxAge").on('keydown mousedown', function () {
        var maxAge = $(this).val();
        var minAge = $(this).siblings("input").val();
        if (maxFirstClick){
            $(this).prop('min', minAge);
            maxFirstClick = false;
        }

        if (maxAge == minAge){
            $(this).prop('min', minAge);
        }
    });

    // Dont let user uncheck both gender checkboxes
    $("#male, #female").click(function () {
        if($('input[type="checkbox"]:checked').length == 0) {
            $(this).prop('checked', true);
        }

    });

</script>