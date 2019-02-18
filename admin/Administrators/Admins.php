<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/inputBoxShadow.js"></script> <!--Add box shadow on input fields when focus-->
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/tabsProperties.js"></script><!--Tabs properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/tabsStyle.css"><!--Tab style-->
<script></script>
<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class="modalTitle">Administrators</h2>
        </div>


        <!--BODY-->
        <div class="modal-body">

            <!--TAB BUTTONS-->
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Add')" style="padding: 14px 81px;">Add</button>
                <button class="tablinks" onclick="openTab(event, 'Delete')" style="padding: 14px 80px;">Delete</button>
            </div>

            <!--ADD-->
            <div id="Add" class="tabcontent">

                <h3 class="tabTitle">Add</h3>
                <p class="instruction">Fill in the fields below to add a new admin</p>

                <form onsubmit="return insertAdmin();">
                    <!--EMAIL-->
                    <div class="wrap-input wrap-login" id="Email" style="border: 2px solid #cccccc; width: 85%; margin-left: 3%;">
                        <label class="lbl" for="email">
                            <span class="fa fa-at"></span>
                        </label>
                        <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email" required/>

                    </div>

                    <!--PASSWORD-->
                    <div class="wrap-input wrap-login" id="Password" style="border: 2px solid #cccccc; width: 85%; margin-left: 3%;">
                        <label class="lbl" for="pass1">
                            <span class="fa fa-lock"></span>
                        </label>
                        <input class="inp" id="pass1" type="password" name="pass1" minlength="8" maxlength="25" placeholder="Password" required >
                    </div>

                    <!--CONFIRM PASSWORD-->
                    <div class="wrap-input wrap-login" id="Confirm-pass" style="border: 2px solid #cccccc; width: 85%; margin-left: 3%;">
                        <label class="lbl" for="pass2">
                            <span class="fa fa-lock"></span>
                        </label>
                        <input class="inp" id="pass2" type="password" name="pass2" minlength="8" maxlength="25" placeholder="Confirm password" required>
                    </div>

                    <div id="response"></div>

                    <!--FOOTER-->
                    <div class="tabsFooter">
                        <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                        <button class="btn-change" type="submit"> ADD</button>
                    </div>

                </form>

            </div>

            <!--DELETE-->
            <div id="Delete" class="tabcontent">

                <h3 class="tabTitle">Delete</h3>
                <p class="instruction">Select admin(s) to delete</p>

                <form onsubmit="return deleteAdmins();">

                    <div id="showAdmins">
                        <!--Admins's details will be placed here -->
                    </div>

                    <!--Display successful/error message-->
                    <div id="deleteResponse" style="margin-left: 4%;"></div>

                    <!--FOOTER-->
                    <div class="tabsFooter">
                        <button onclick="modal.style.display='none'" class="btn-change" type="button"> CANCEL</button>
                        <button class="btn-change" type="submit"> DELETE</button>
                    </div>

                </form>

            </div>

    </div>

</div>

<script>

    function insertAdmin() {
        var Email=$("#email").val();
        var Pass=$("#pass1").val();
        var confirmPass=$("#pass2").val();
        if (Email != '' && Pass != '' && confirmPass !=''){
            $.ajax
            ({
                type:'post', url:'http://localhost/Local%20Server/ConnectPlatform/admin/Administrators/insertAdmin.php',
                data:{
                    email:Email,
                    pass1:Pass,
                    pass2:confirmPass
                },
                dataType:"json",
                success:function(response)
                {
                    if(response == "success") {
                        //Display successful message and set green shadow to all the fields.
                        $('#response').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Admin has been added successfully !</span></p>');
                        $("#Email, #Password, #Confirm-pass").css("box-shadow", "0 0 5px green");
                        $("#showAdmins").append('<div class="deleteAdmin" onclick="checkUncheck(this)"><p><input type="checkbox">'+Email+'</p></div>');
                    }
                    else if (response[1] == "Password"){
                        //Display the error message and set red box shadow to password and confirm password.
                        $('#response').html('<p style="color:red; font-size:17px; margin:0;">' +
                            '<span class="fa fa-exclamation-triangle">'+response[0]+'</span></p>');
                        $("#Password").css("box-shadow", "0 0 5px red");
                        $("#Confirm-pass").css("box-shadow", "0 0 5px red");
                    }
                    else
                    {
                        //Display the error message and set red box shadow to the respective field.
                        $('#response').html('<p style="color:red; font-size:17px; margin:0;">' +
                            '<span class="fa fa-exclamation-triangle">'+response[0]+'</span></p>');
                        $("#"+response[1]+"").css("box-shadow", "0 0 5px red");
                    }
                }
            });
        }
        else{
            $('#response').html('<p style="color:red; font-size:18px; margin:0;">' +
                '<span class="fa fa-exclamation-triangle"> All fields are required !</span></p>');
            $("#Email").css("box-shadow", "0 0 5px red");
        }

        return false;
    }

    //Fetch all admins.
    var admins = [];
    $.ajax({
        type: "GET",
        url: "http://localhost/Local%20Server/ConnectPlatform/admin/Administrators/getAdmins.php",
        dataType: "json",
        success: function(response){
            admins = response;
            admins.forEach(myFunction);
            function myFunction(value) {
                $("#showAdmins").append('<div class="deleteAdmin" onclick="checkUncheck(this)"><p><input type="checkbox">'+value+'</p></div>');
            }
        }
    });

    //Delete selected admins.
    function deleteAdmins()
    {
        if (confirm('Are you sure you want to delete it?')) {
            //Check if only one admin is existed.
            if ($(".deleteAdmin").length < 2) {
                alert("Always must be existed at least one admin !");
            }
            else {
                var selectedAdmins = [];
                //Get the checked checkboxes and put the corresponding admin's email in a array.
                $(".deleteAdmin p input:checked").each(function () {
                    selectedAdmins.push($(this).parent().text());
                });
                if (selectedAdmins.length < 1) {
                    alert("No admins have been selected !")
                }
                else {
                    $.ajax
                    ({
                        type: 'post',
                        url: 'http://localhost/Local%20Server/ConnectPlatform/admin/Administrators/deleteAdmin.php',
                        data: {admins: selectedAdmins},
                        success: function (response) {
                            if (response == "success") {
                                //Display successful message and set green shadow to all the fields.
                                $('#deleteResponse').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                                    '<span class="fa fa-check-circle-o"> Admin(s) deleted successfully !</span></p>');
                                //Remove selected admin
                                $(".deleteAdmin p input:checked").each(function () {
                                    $(this).parent().parent().remove();
                                });
                            }
                            else {
                                //Display the error message.
                                $('#deleteResponse').html('<p style="color:red; font-size:17px; margin:0;">' +
                                    '<span class="fa fa-exclamation-triangle"> ' + response + '</span></p>');
                            }
                        }
                    });
                }
            }
        }
        return false;
    }

    // Check/Uncheck ckeckbox when click on an admin
    function checkUncheck(x) {
        cb = $(x).find(':checkbox');
        if(cb.is(':checked')){
            cb.prop('checked', false);
        }
        else if(!cb.is(':checked')) {
            cb.prop('checked', true);
        }
    }

</script>