<?php
    session_start();
    $adult= date("Y") - 18;
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
<html style="height: 100%;">

    <head>
        <title>Get in Touch - Sign Up</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="indexStyle.css" >
        <script>
            $(document).ready(function(){

                //Set red shadow to the respective field.
                $("#<?php echo $field; ?>").css("box-shadow", "0 0 5px red");

                //Prevents user to enter any language except English
                $("input[type=text], input[type=email], input[type=password] ").keypress(function(event){
                    var ew = event.which;
                    if(ew == 32)
                        return true;
                    if(48 <= ew && ew <= 57)
                        return true;
                    if(65 <= ew && ew <= 90)
                        return true;
                    if(97 <= ew && ew <= 122)
                        return true;
                    return false;
                });

            });

        </script>
    </head>

    <body style="margin: 0px;">
        <!--HEADER-->
        <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/head.html"); ?>

        <!--SIGN UP FORM-->
        <form class="frm" action="Registration.php"  method="post">

            <h2>Sign Up</h2>

           <!--NAME-->
            <div class="wrap-input" id="Name" style="float: left;">
                <label class="lbl" for="name">
                    <span class="fa fa-user-o"></span>
                </label>
                <input class="inp" id="name" type="text" name="name" maxlength="20" placeholder="Name"
                       value="<?php if (isset($_SESSION['name'])) echo $_SESSION['name']; ?>">
            </div>

            <!-- SURNAME-->
            <div class="wrap-input" id="Surname" style="float: right;">
                <label class="lbl" for="surname">
                    <span class="fa fa-user-o"></span>
                </label>
                <input class="inp" id="surname" type="text" name="surname" maxlength="25" placeholder="Surname"
                       value="<?php if (isset($_SESSION['surname'])) echo $_SESSION['surname']; ?>">
            </div>

            <!--BIRTHDAY-->
            <div class="wrap-input" id="Bday" style="float: left;">
                <label class="lbl" for="bday">
                    <span class="fa fa-birthday-cake"></span>
                </label>
                <input class="inp" id="bday" type="text" onfocus="(this.type='date')" name="bday" required
                       min="1918-01-01" max="<?php echo date("$adult-m-d")?>" placeholder="Date of birth"
                       value="<?php if (isset($_SESSION['bday'])) echo $_SESSION['bday']; ?>">
            </div>

            <!--GENDER-->
            <div class="wrap-input" id="Gender" style="float: right;">
                <label class="lbl" for="gender">
                    <span class="fa fa-venus-mars"></span>
                </label>
                <input class="inp" type="radio" name="gender" id="male" value="male"
                    <?php if( ($_SESSION['gender']) == "male") { ?> checked <?php } ?> >
                <label class="lbl radio-lbl" for="male">Male</label>
                <input class="inp" type="radio" name="gender" id="female" value="female"
                    <?php if( ($_SESSION['gender']) == "female") { ?> checked <?php } ?>>
                <label class="lbl radio-lbl" for="female">Female</label>
            </div>

            <!-- DISTRICT-->
            <div class="wrap-input" id="District" style="float: left;">
                <label class="lbl" for="autocomplete">
                    <span class="fa fa-home"></span>
                </label>
                <input class="inp" id="autocomplete" type="text" name="district" minlength="2" maxlength="100" placeholder="District"
                       value="<?php if (isset($_SESSION['district'])) echo $_SESSION['district']; ?>">
            </div>
            <!-- Autocomplete places api -->
            <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/places.html"); ?>

            <!-- EDUCATION-->
            <div class="wrap-input" id="Education" style="float: right;">
                <label class="lbl" for="education">
                    <span class="fa fa-mortar-board"></span>
                </label>
                <input class="inp" id="education" onFocus="geolocate()" type="text" name="education" minlength="2" maxlength="25" placeholder="Education"
                       value="<?php if (isset($_SESSION['education'])) echo $_SESSION['education']; ?>">
            </div>

            <!-- EMAIL-->
            <div class="wrap-input" id="Email" style="float: left; margin-right: 25px;">
                <label class="lbl" for="email">
                    <span class="fa fa-at"></span>
                </label>
                <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email address"
                       value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
            </div>

            <!-- PASSWORD-->
            <div class="wrap-input" id="Password" style="float: left;">
                <label class="lbl" for="pass1">
                    <span class="fa fa-lock"></span>
                </label>
                <input class="inp" id="pass1" type="password" name="pass1" minlength="8" maxlength="25" placeholder="Password" >
            </div>

            <!-- CONFIRM PASSWORD-->
            <div class="wrap-input" style="float: right;">
                <label class="lbl" for="pass2">
                    <span class="fa fa-lock"></span>
                </label>
                <input class="inp" id="pass2" type="password" name="pass2" minlength="8" maxlength="25" placeholder="Confirm password">
            </div>

            <!--BUTTON-->
            <button class="btn" type="submit" style="float: left;">REGISTER</button>
            <p style="float: left; margin: 3% 0% 0% 5%;">Already registered ?
                <a href="Login.php" style="color: #0066cc; text-decoration: none;"> Sign In</a>
            </p>

        </form>

    </body>

</html>
<script>
    //Add box shadow on input fields when focus
    $.getScript( "includes/inputBoxShadow.js" );
    //Does not work when put in <head> :(
</script>