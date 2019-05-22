<?php
    session_start();
    $adult= date("Y") - 18;
?>

<!DOCTYPE html>
<html style="background-color: #f2f2f2; overflow: auto;">

    <head>
        <title>Get in Touch - Sign Up</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/radioButtonStyle.css"> <!--Radio button style-->
        <link rel="stylesheet" href="indexStyle.css" >
        <script>
            $(document).ready(function() {
                //show page's content
                $(".register-pagecontent").fadeIn(1000);

                $("#cookiesMessage").load("http://localhost/Local%20Server/ConnectPlatform/includes/cookiesMessage.html");

            });

            //Form submission
            function registration(){
                var name = $("#name").val();
                var surname = $("#surname").val();
                var bday = $("#bday").val();
                var gender = $("input[name=gender]:checked").val();
                var district = $("input[name=district]").val();
                var education = $("#education").val();
                var occupation = $("#occupation").val();
                var email = $("#email").val();
                var pass1 = $("#pass1").val();
                var pass2 = $("#pass2").val();


                //Remove any error messages and error styles.
                $("#errorMessages").html("");
                $(".wrap-input").css("box-shadow", "none");

                $.ajax
                ({
                    type: 'post', url: 'Registration.php',
                    data: {
                        name: name,
                        surname: surname,
                        bday: bday,
                        gender: gender,
                        district: district,
                        education: education,
                        occupation: occupation,
                        email: email,
                        pass1: pass1,
                        pass2: pass2
                    },
                    dataType: "json",
                    success: function (response) {
                        $.each(response, function (i, response) {
                            //Registered successfully, redirect to log-in page
                            if (response.errorMessage == "success" ) {
                                window.location.href = "./Login/Login.php?registered=success";
                                return false;
                            }
                            else {
                                // Display error messages
                                $("#" + response.field + "").css("box-shadow", "0 0 5px red");
                                $("#errorMessages").append('<p class="errorResponse" style=" width: 43%; margin:0 0 5px 15px; color: red; font-size: 14px; display: inline-block;">' + response.errorMessage + '</p>');
                                if (i == 1) {
                                    return false;
                                }
                            }
                        });
                    }
                });
                return false;
            }


        </script>
    </head>

    <body style="margin: 0px;">
    <div class="register-pagecontent" hidden>
        <!--HEADER-->
        <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/head.html"); ?>

        <!--Display cookies message-->
        <div id="cookiesMessage"></div>

        <!--SIGN UP FORM-->
        <form id="registrationForm" class="frm" onsubmit="return registration();">

            <h2>Sign Up</h2>
            <div id="errorMessages"></div>

           <!--NAME-->
            <div class="wrap-input" id="Name" style="float: left;">
                <label class="lbl" for="name">
                    <span class="fa fa-user-o"></span>
                </label>
                <input class="inp" id="name" type="text" name="name" maxlength="20" placeholder="Name" autofocus required >
            </div>

            <!-- SURNAME-->
            <div class="wrap-input" id="Surname" style="float: right;">
                <label class="lbl" for="surname">
                    <span class="fa fa-user-o"></span>
                </label>
                <input class="inp" id="surname" type="text" name="surname" maxlength="25" placeholder="Surname" required >
            </div>

            <!--BIRTHDAY-->
            <div class="wrap-input" id="Bday" style="float: left;">
                <label class="lbl" for="bday">
                    <span class="fa fa-birthday-cake"></span>
                </label>
                <input class="inp" id="bday" type="text" onfocus="(this.type='date')" name="bday" required
                       min="1918-01-01" max="<?php echo date("$adult-m-d")?>" placeholder="Date of birth" >
            </div>

            <!--GENDER-->
            <div class="wrap-input" id="Gender" style="float: right;">
                <label class="lbl" for="gender">
                    <span class="fa fa-venus-mars"></span>
                </label>
                <label class="pure-material-radio" style="margin: 12px;">
                    <input class="inp" type="radio" name="gender" id="male" value="male" >
                    <span style="font-size: initial">Male</span>
                </label>

                <label class="pure-material-radio" style="margin: 12px;">
                    <input class="inp" type="radio" name="gender" id="female" value="female" >
                    <span style="font-size: initial">Female</span>
                </label>
            </div>

            <!-- DISTRICT-->
            <div class="wrap-input" id="District" style="float: left;">
                <label class="lbl" for="autocomplete">
                    <span class="fa fa-home"></span>
                </label>
                <input class="inp" id="autocomplete" type="text" name="district" minlength="2" maxlength="100" placeholder="District" required >
            </div>
            <!-- Autocomplete places api -->
            <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/places.html"); ?>

            <!-- EDUCATION-->
            <div class="wrap-input" id="Education" style="float: right;">
                <label class="lbl" for="education">
                    <span class="fa fa-mortar-board"></span>
                </label>
                <input class="inp" id="education" type="text" name="education" minlength="2" maxlength="25" placeholder="Education" required >
            </div>

            <!-- OCCUPATION-->
            <div class="wrap-input" id="Occupation" style="float: left;">
                <label class="lbl" for="occupation">
                    <span class="fa fa-briefcase"></span>
                </label>
                <input class="inp" id="occupation" type="text" name="occupation" minlength="2" maxlength="25" placeholder="Occupation" required >
            </div>

            <!-- EMAIL-->
            <div class="wrap-input" id="Email" style="float: right;">
                <label class="lbl" for="email">
                    <span class="fa fa-at"></span>
                </label>
                <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email address" required >
            </div>

            <!-- PASSWORD-->
            <div class="wrap-input" id="Password" style="float: left;">
                <label class="lbl" for="pass1">
                    <span class="fa fa-lock"></span>
                </label>
                <input class="inp" id="pass1" type="password" name="pass1" minlength="8" maxlength="25" placeholder="Password" required >
            </div>

            <!-- CONFIRM PASSWORD-->
            <div class="wrap-input" style="float: right;">
                <label class="lbl" for="pass2">
                    <span class="fa fa-lock"></span>
                </label>
                <input class="inp" id="pass2" type="password" name="pass2" minlength="8" maxlength="25" placeholder="Confirm password" required>
            </div>

            <!--BUTTON-->
            <button class="btn" type="submit" style="float: left;">REGISTER</button>
            <p style="float: left; margin: 2% 0% 0% 5%; font-family: 'Roboto', sans-serif">Already registered ?
                <a href="Login/Login.php" style="color: #0066cc; text-decoration: none; font-weight: bold;"> Sign In</a>
            </p>

        </form>
    </div>
    </body>

</html>
<script>
    //Add box shadow on input fields when focus
    $.getScript( "includes/inputBoxShadow.js" );

    //Prevents user to enter any language except English
    $.getScript( "http://localhost/Local%20Server/ConnectPlatform/includes/onlyEnglish.js" );

    //All above do not work when put in <head> :(
</script>