<script src="../includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Edit email</h2>
        </div>

        <form onsubmit="return updateEmail();">

            <!--BODY-->
            <div class="modal-body">

                <p style="font-size: 15px; margin-top: 10px; margin-left: 35px;">Edit your email and then click save</p>

                <!--EMAIL-->
                <div class="wrap-input wrap-login" id="Email" style="border: 2px solid #cccccc; width: 85%; margin-left: 7%;">
                    <label class="lbl" for="email">
                        <span class="fa fa-at"></span>
                    </label>
                    <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email" required
                           value="<?php session_start(); echo $_SESSION['user_email']; ?>" />
                </div>

                <div id="response"></div>

            </div>

            <!--FOOTER-->
            <div class="modal-footer">
                <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                <button id="save" class="btn-change"> SAVE</button>
            </div>

        </form>

    </div>

</div>

<script>
    function updateEmail() {
        var email=$("#email").val();
        if (email != ''){
            $.ajax
            ({
                type:'post', url:'http://localhost/Local%20Server/ConnectPlatform/admin/updateAdminEmail.php',
                data:{
                    email:email,
                },
                success:function(response)
                {
                    if(response == "success") {
                        // Email has been updated successfully
                        $('#response').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Email has been updated successfully !</span></p>');
                        $("#Email").css("box-shadow", "0 0 5px green");
                        $(".about span p").html(email);
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
                            '<span class="fa fa-exclamation-triangle"> Invalid email</span></p>');
                        $("#Email").css("box-shadow", "0 0 5px red");
                    }
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