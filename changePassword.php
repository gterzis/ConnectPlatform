<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/inputBoxShadow.js"></script> <!--Add box shadow on input fields when focus-->

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Change password</h2>
        </div>

        <form onsubmit="return updatePassword();">
        <!--BODY-->
        <div class="modal-body">

            <p style="font-size: 15px; margin-left: 20px;">Fill in the fields below in order to change your password</p>

                <!--OLD PASSWORD-->
                <div class="wrap-input wrap-login" id="Old-pass" style="border: 2px solid #cccccc; width: 85%; margin-left: 7%;">
                    <label class="lbl" for="old-pass">
                        <span class="fa fa-unlock-alt"></span>
                    </label>
                    <input class="inp" id="old-pass" type="password" name="old-pass" maxlength="25" placeholder="Old password" required/>
                </div>

                <!--NEW PASSWORD-->
                <div class="wrap-input wrap-login" id="New-pass" style="border: 2px solid #cccccc; width: 85%; margin-left: 7%;">
                    <label class="lbl" for="new-pass">
                        <span class="fa fa-lock"></span>
                    </label>
                    <input class="inp" id="new-pass" type="password" name="new-pass" maxlength="25" placeholder="New password" required/>
                </div>

                <!--OLD PASSWORD-->
                <div class="wrap-input wrap-login" id="Confirm-pass" style="border: 2px solid #cccccc; width: 85%; margin-left: 7%;">
                    <label class="lbl" for="confirm-pass">
                        <span class="fa fa-lock"></span>
                    </label>
                    <input class="inp" id="confirm-pass" type="password" name="confirm-pass" maxlength="25" placeholder="Confirm new password" requiredx/>
                </div>

            </div>

            <!--Place succeed/error message-->
            <div id="response"></div>

            <!--FOOTER-->
            <div class="modal-footer">
                <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                <button class="btn-change" name="changePass" type="submit"> CHANGE</button>
            </div>

        </form>
    </div>

</div>

<script>

    function updatePassword() {
        var oldPass=$("#old-pass").val();
        var newPass=$("#new-pass").val();
        var confirmPass=$("#confirm-pass").val();
        if (oldPass != '' && newPass != '' && confirmPass !=''){
            $.ajax
            ({
                type:'post', url:'http://localhost/Local%20Server/ConnectPlatform/updatePassword.php',
                data:{
                    oldPass:oldPass,
                    newPass:newPass,
                    confirmPass:confirmPass
                },

                success:function(response)
                {
                    if(response == "success") {
                        $('#response').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Password has been changed successfully !</span></p>').removeClass("errorResponse").addClass("successResponse");
                        $("#Old-pass, #New-pass, #Confirm-pass").css("box-shadow", "0 0 5px green");
                        setTimeout(
                            function()
                            {
                                modal.style.display = "none";
                            }, 4000);
                    }
                    else{
                        $('#response').html('<p style="color:red; font-size:17px; margin:0;">' +
                            '<span class="fa fa-exclamation-triangle">'+ response+'</span></p>').addClass("errorResponse");
                        if (response == " Wrong old password") {
                            $("#Old-pass").css("box-shadow", "0 0 5px red");
                            $("#New-pass, #Confirm-pass").css("box-shadow", "none");
                        }
                        else {
                            $("#New-pass, #Confirm-pass").css("box-shadow", "0 0 5px red");
                            $("#Old-pass").css("box-shadow", "none");
                        }
                    }
                }
            });
        }
        else{
            $('#response').html('<p style="color:red; font-size:18px; margin:0;">' +
                '<span class="fa fa-exclamation-triangle"> All fields are required !</span></p>').addClass("errorResponse");
            $("#Email").css("box-shadow", "0 0 5px red");
        }

        return false;
    }

</script>