<?php
$array = json_decode($_GET['array']);
$adult= date("Y") - 18;
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    /*body {font-family: Arial, Helvetica, sans-serif;}*/

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 30px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 53%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    #icon{
        color: white;
        float: left;
        font-size: 24px;
        font-weight: bold;
        margin: 20px 10px 20px 0px;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        padding: 2px 16px;
        background-color: #bcbcbc;
        color: white;
    }

    .modal-body {
        padding: 22px 16px;*/
        font-family: Arial, Helvetica, sans-serif;
        height: 400px;
        width: 692px;
        overflow-y: scroll;
    }

    .modal-footer {
        padding: 25px 16px;
        background-color: #bcbcbc;
        color: white;
    }

    .wrap-input{
        width: 45%;
        display: block;
        float: left;
        border: #cccccc 1px solid;
        padding-bottom: 10px;
    }

    .btn-edit{
        background-color: #4d4d4d;
        color: ivory;
        padding: 6px 12px;
        position: relative;
        bottom: 10px; right: 25px;
        float: right;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 4px;
        font-weight: bold;
        height: 40px;
        width: 150px;
        font-family: "Roboto", sans-serif;
        transition: 0.2s;
        transition-timing-function: ease-in-out;
        outline: 0;
    }

    .btn-edit:hover{
        background-color: #333333;
    }

    #response{
        color: red;
        width: 62%;
        display: inline-block;
        margin-left: 20px;
    }
</style>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <span class="fa fa-edit" id="icon"></span> <h2>Edit information</h2>
        </div>

        <div class="modal-body">
            <!--NAME-->
            <div class="wrap-input" id="Name">
                <label class="lbl" for="name">
                    <span class="fa fa-user-o"></span>
                </label>
                <input class="inp" id="name" type="text" name="name" maxlength="20" placeholder="Name" value="<?= $array[0]?>" >
                <i style='color:red; position: relative; right: 5px;'>*</i>
            </div>

            <!-- SURNAME-->
            <div class="wrap-input" id="Surname">
                <label class="lbl" for="surname">
                    <span class="fa fa-user-o"></span>
                </label>
                <input class="inp" id="surname" type="text" name="surname" maxlength="25" placeholder="Surname" value="<?= $array[1]?>">
                <i style='color:red; position: relative; right: 5px;'>*</i>
            </div>

            <!--BIRTHDAY-->
            <div class="wrap-input" id="Bday">
                <label class="lbl" for="bday">
                    <span class="fa fa-birthday-cake"></span>
                </label>
                <input class="inp" id="bday" type="text" onfocus="(this.type='date')" name="bday" required
                       min="1918-01-01" max="<?php echo date("$adult-m-d")?>" placeholder="Date of birth" value="<?= $array[2]?>">
                <i style='color:red; position: relative; right: 5px;'>*</i>
            </div>

            <!--GENDER-->
            <div class="wrap-input" id="Gender">
                <label class="lbl" for="gender">
                    <span class="fa fa-venus-mars"></span>
                </label>
                <input class="inp" type="radio" name="gender" id="male" value="male"
                    <?php if( ($array[3]) == "Male") { ?> checked <?php } ?> >
                <label class="lbl radio-lbl" for="male">Male</label>
                <input class="inp" type="radio" name="gender" id="female" value="female"
                    <?php if( ($array[3]) == "Female") { ?> checked <?php } ?>>
                <label class="lbl radio-lbl" for="female">Female</label>
                <i style='color:red; position: relative; left: 45px;'>*</i>
            </div>

            <!-- DISTRICT-->
            <div class="wrap-input" id="District">
                <label class="lbl" for="autocomplete">
                    <span class="fa fa-home"></span>
                </label>
                <input class="inp" id="autocomplete" type="text" name="district" minlength="2" maxlength="100" placeholder="District" value="<?= $array[4]?>">
                <i style='color:red; position: relative; right: 5px;'>*</i>
            </div>
            <!-- Autocomplete places api -->
            <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/places.html"); ?>

            <!-- EDUCATION-->
            <div class="wrap-input" id="Education" >
                <label class="lbl" for="education">
                    <span class="fa fa-mortar-board"></span>
                </label>
                <input class="inp" id="education" onFocus="geolocate()" type="text" name="education" minlength="2" maxlength="25" placeholder="Education" value="<?= $array[5]?>">
                <i style='color:red; position: relative; right: 15px;'>*</i>
            </div>

            <!-- EMAIL-->
            <div class="wrap-input" id="Email" >
                <label class="lbl" for="email">
                    <span class="fa fa-at"></span>
                </label>
                <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email address" value="<?= $array[6]?>">
                <i style='color:red; position: relative; right: 5px;'>*</i>
            </div>

            <!-- DESCRIPTION-->
            <div style="float: left; clear: left; margin-left: 20px;">
                <label style=" float:left; clear: left; color: #999999;">Description</label>
                <textarea rows="6" cols="60" id="description" placeholder="Description" maxlength="276" style=" float:left; clear: left;"><?= $array[7]?>
                </textarea>
            </div>

        </div>

        <!--FOOTER-->
        <div class="modal-footer">
            <div id="response"">* Required fields</div>
            <button class="btn-edit" onclick="updateInformation()"> SAVE CHANGES</button>
        </div>
    </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Open the modal
    modal.style.display = "block";

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function updateInformation() {

        var name=$("#name").val();
        var surname=$("#surname").val();
        var birthday=$("#bday").val();
        var gender=$("input[name=gender]:checked").val();
        var district=$("input[name=district]").val();
        var education=$("#education").val();
        var email=$("#email").val();
        var description=$("#description").val();

        $.ajax
            ({
                type:'post', url:'updateInformation.php',
                data:{
                    name:name,
                    surname:surname,
                    bday:birthday,
                    gender:gender,
                    district:district,
                    education:education,
                    email:email,
                    description:description
                },

                success:function(response)
                {
                    if(response == "success") {
                        $('#response').html('<p style="color:#009933; font-size:18px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Your personal information has been saved successfully !</span></p>');
                        //After 3 seconds exit window and reload page
                        setTimeout(function(){
                                modal.style.display = "none";
                                location.reload();
                            }, 3000);
                    }
                    else{
                        $('#response').html('<p style="color:red; font-size:17px; margin:0;">' +
                            '<span class="fa fa-exclamation-triangle">'+ response+'</span></p>');
                    }
                }
            });

        return false;
    }

    //Add box shadow on input fields when focus
    $.getScript( "includes/inputBoxShadow.js" );
</script>