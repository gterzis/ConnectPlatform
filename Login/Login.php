<?php
	session_start();
	if (isset($_GET['registered']))
        $registered = "success";
	else
	    $registered = "false";
?>
<!DOCTYPE html>
<html style="background-color: #f2f2f2;">

    <head>
        <title>Get in Touch - Login</title>
        <link rel="stylesheet" href="../indexStyle.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/checkBoxStyle.css"><!--check box style-->
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
                        success:function(response) {
                            if(response == "admin") { //Correct input. Redirect to the admin's home page
                                window.location.href="http://localhost/Local%20Server/ConnectPlatform/admin/admin.php";
                            }
                            else if(response == "success"){ //Correct input. Redirect to the user's home page
                                window.location.href="../Profile.php";
                            }
                            else{//Something went wrong. Show error message.
                            $('#result').load("http://localhost/Local%20Server/ConnectPlatform/includes/DialogBox.php?Error="+response+"");
                            }
                        }
                    });
                }
                return false;
            }


            function forgotPassword(){
                $('#result').load("http://localhost/Local%20Server/ConnectPlatform/ForgottenPassword/forgotPassword.php");
                return false;
            }

            $(document).ready(function() {
                //show shadow on input focus
                $.getScript( "../includes/inputBoxShadow.js" );

                // Show succeed registration pop up window message
                var registered = "<?= $registered; ?>";
                if (registered == "success"){
                    $('#result').load("http://localhost/Local%20Server/ConnectPlatform/includes/RegisteredSuccesfully.php");
                    $(".login-pagecontent").fadeIn(1000);
                    return false;
                }

                //show page's content
                $(".login-pagecontent").fadeIn(1000);
            });

        </script>

<style>
    input, p{
        font-family: 'Roboto', sans-serif;
    }
</style>
    </head>

    <body style="margin: 0;">

    <!--Place error message box, forgot password window-->
    <div id="result"></div>

    <!--HEADER-->

    <div class="login-pagecontent" hidden>
        <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/head.html"); ?>

        <!--LOGIN FORM-->
        <form class="frm frm-login" method="post" action="Identification.php" onsubmit="return do_login();">

            <h2 style="margin-left: 45px;">Sign in</h2>

            <!--EMAIL-->
            <div class="wrap-input wrap-login" style="float: left;">
                <label class="lbl" for="email">
                    <span class="fa fa-at" style="padding-top: 20px;"></span>
                </label>
                <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email" required
                       value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"];}
                       elseif (isset($_SESSION['email'])) { echo $_SESSION['email'];} ?>" />
            </div>

            <!--PASSWORD-->
            <div class="wrap-input wrap-login" style="float: left;">
                <label class="lbl" for="pass">
                    <span class="fa fa-unlock" style="padding-top: 20px;"></span>
                </label>
                <input class="inp" id="pass" type="password" name="pass" maxlength="25" placeholder="Password" required
                       value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"];} ?>">
            </div>

            <!--REMEMBER ME-->
            <label class="pure-material-checkbox" style="margin-left: 60px;">
                <input type="checkbox" name="rememberme" id="rememberme"
                    <?php if(isset($_COOKIE["email"])) { ?> checked <?php } ?> >
                <span style="font-weight: initial; font-family: 'Roboto', sans-serif;">Remember me</span>
            </label>

            <button class="btn" style="width: 75%; margin: 8px 15px 15px 45px;">LOGIN</button>
            <p style="margin: 5px 10%; text-align: center;">Forgot your passwrod ?<button style="font-size: 15px;" type="button" class="forgot-btn" onclick="forgotPassword()"> Click here</button></p>
            <p style="margin: 10px 10%; text-align: center;">Not registered ?<a href="../Register.php" style="font-size: 15px; color: #0066cc; font-weight: bold; text-decoration: none;"> Sign up</a></p>

        </form>

    </div>

    </body>

</html>
<script>

</script>