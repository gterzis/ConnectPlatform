<?php
	session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Get in Touch - Login</title>
        <link rel="stylesheet" href="indexStyle.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
            function do_login() {

                var email=$("#email").val();
                var pass=$("#pass").val();
                var rememberme = $("#rememberme").is(":checked");
                if(email!="" && pass!="")
                {
                    $.ajax
                    ({
                        type:'post', url:'Identification.php',
                        data:{
                            email:email,
                            password:pass,
                            rememberme:rememberme
                        },
                        success:function(response)
                        {
                            if(response == "success") {
                                window.location.href="Profile.php";
                            }
                            else{
                                $('#result').load("http://localhost/Local%20Server/ConnectPlatform/includes/DialogBox.php?Error="+response+"");
                            }
                        }
                    });
                }

                return false;
            }

            function forgotPassword(){
                $('#result').load("http://localhost/Local%20Server/ConnectPlatform/forgotPassword.php");
                return false;
            }

        </script>


    </head>

    <body style="margin: 0px; background-color: ivory;">

    <!--Place error message box, forgot password window-->
    <div id="result"></div>

    <!--HEADER-->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/head.html"); ?>

    <!--LOGIN FORM-->
    <form class="frm frm-login" method="post" action="Identification.php" onsubmit="return do_login();">

        <h2 style="margin-left: 45px;">Sign in</h2>

        <!--EMAIL-->
        <div class="wrap-input wrap-login" style="float: left;">
            <label class="lbl" for="email">
                <span class="fa fa-at"></span>
            </label>
            <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email" required
                   value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"];}
                   elseif (isset($_SESSION['email'])) { echo $_SESSION['email'];} ?>" />

        </div>

        <!--PASSWORD-->
        <div class="wrap-input wrap-login" style="float: left;">
            <label class="lbl" for="pass">
                <span class="fa fa-unlock"></span>
            </label>
            <input class="inp" id="pass" type="password" name="pass" maxlength="25" placeholder="Password" required
                   value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"];} ?>">
        </div>

        <!--REMEMBER ME-->
        <label class="rememberme">
            <input type="checkbox" name="rememberme" id="rememberme"
                <?php if(isset($_COOKIE["email"])) { ?> checked <?php } ?> >
            <span class="checkmark"></span> Remember me
        </label>

        <button class="btn" style="width: 75%; margin: 8px 15px 15px 45px;">LOGIN</button>
        <p style="margin: 5px 10%; text-align: center;">Forgot your passwrod ?<button style="font-size: 15px;" type="button" class="forgot-btn" onclick="forgotPassword()"> Click here</button></p>
        <p style="margin: 10px 10%; text-align: center;">Not registered ?<a href="Register.php" style="color: #0066cc; text-decoration: none;"> Sign up</a></p>

    </form>

    </body>
</html>
