<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->

<!-- The Modal -->
<div id="myModal" class="modal" style="padding-top: 105px;">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Forgotten password</h2>
        </div>

        <form onsubmit="return sendLink();">

            <!--BODY-->
            <div class="modal-body">

                <p class="instruction" style="margin-left: 8%;">Enter your email to receive a link in order to reset your password</p>

                <!--EMAIL-->
                <div class="wrap-input wrap-login" id="Email" style="border: 2px solid #cccccc; width: 85%; margin-left: 7%;">
                    <label class="lbl" for="email">
                        <span class="fa fa-at"></span>
                    </label>
                    <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email" required
                           value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"];}
                           elseif (isset($_SESSION['email'])) { echo $_SESSION['email'];} ?>" />
                </div>

            </div>

            <div id="response" style="font-family: 'Roboto', sans-serif;" hidden><div style="float: left;" class="loader"></div>&nbsp;Sending email...</div>

            <!--FOOTER-->
            <div class="modal-footer">
                <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                <button id="send" class="btn-change"> SEND</button>
            </div>

        </form>

    </div>

</div>

<script>

    // Get the loader element
    var loader = document.getElementsByClassName("loader")[0];

    //Hide loader spinner
    loader.style.display ="none";

    function sendLink() {
        //Disable SEND button to prevent user to click it multiple times. This causes issue !
        $("#send").prop('disabled', true);

        var email=$("#email").val();
        if (email != ''){
            $.ajax
            ({
                type:'post', url:'http://localhost/Local%20Server/ConnectPlatform/ForgottenPassword/sendLink.php',
                data:{
                    email:email,
                },
                beforeSend: function() {
                    //show loading spinner
                    $("#response").show();
                    loader.style.display = "block";
                },
                success:function(response)
                {
                    if(response == "success") {
                        // Link has been sent succesfully
                        $('#response').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Link has been sent successfully !</span></p>').removeClass("errorResponse").addClass("successResponse");
                        $("#Email").css("box-shadow", "0 0 5px green");
                        //After 2.5 seconds exit window
                        setTimeout(
                            function()
                            {
                                modal.style.display = "none";
                            }, 2500);
                    }
                    else{
                        //Error has occur.
                        $('#response').html('<p style="color:red; font-size:18px; margin:0;">' +
                            '<span class="fa fa-exclamation-triangle"> Invalid email</span></p>').addClass("errorResponse");
                        $("#Email").css("box-shadow", "0 0 5px red");
                    }
                    $("#send").prop('disabled', false);
                }
            });
        }
        else{
            $('#response').html('<p style="color:red; font-size:18px; margin:0;">' +
                '<span class="fa fa-exclamation-triangle"> No email has been entered</span></p>');
            $("#Email").css("box-shadow", "0 0 5px red");
        }

        return false;
    }

</script>