<?php
$array = json_decode($_GET['array']);
$adult= date("Y") - 18;
if (empty($array[9])){ // marital status
    $array[9] = "none";
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/radioButtonStyle.css"> <!--Radio button style-->
<style>
    .wrap-input{
        width: 46%;
        display: block;
        float: left;
        border: #cccccc 1px solid;
        padding-bottom: 10px;
    }

    .wrap-input span{
        font-size: 14px;
    }

    #response{
        color: red;
        width: 62%;
        display: inline-block;
        margin-left: 20px;
    }
</style>

<!-- The Modal -->
<div id="myModal" class="modal" style="padding-top: 20px;">

    <!-- Modal content -->
    <div class="modal-content" style="width: 63.2%;">
        <div class="modal-header">
            <span class="close">&times;</span>
            <span class="fa fa-edit" id="icon"></span> <h2>Edit information</h2>
        </div>

        <div class="modal-body" style="padding: 22px 16px; height: 400px; width: 820px; overflow-y: scroll; background-color: #f2f2f2;">
            <!--NAME-->
            <div class="wrap-input" id="Name">
                <label class="lbl" for="name">
                    <span>Name <i style=' color:red;'> *</i></span>
                </label>
                <input class="inp" id="name" type="text" name="name" maxlength="20" placeholder="Name" value="<?= $array[0]?>" >
            </div>

            <!-- SURNAME-->
            <div class="wrap-input" id="Surname">
                <label class="lbl" for="surname">
                    <span>Surname <i style=' color:red;'> *</i></span>
                </label>
                <input class="inp" id="surname" style="width: 65%;" type="text" name="surname" maxlength="25" placeholder="Surname" value="<?= $array[1]?>">
            </div>

            <!--BIRTHDAY-->
            <div class="wrap-input" id="Bday">
                <label class="lbl" for="bday">
                    <span>Birthday <i style=' color:red;'> *</i></span>
                </label>
                <input class="inp" id="bday" type="text" onfocus="(this.type='date')" name="bday" required
                       min="1918-01-01" max="<?php echo date("$adult-m-d")?>" placeholder="Date of birth" value="<?= $array[2]?>">
            </div>

            <!--GENDER-->
            <div class="wrap-input" id="Gender">
                <label class="lbl" for="gender">
                    <span>Gender <i style=' color:red;'> *</i></span>
                </label>
                <label class="pure-material-radio">
                    <input class="inp" type="radio" name="gender" id="male" value="male"
                        <?php if( ($array[3]) == "Male") { ?> checked <?php } ?> >
                    <span style="font-size: initial">Male</span>
                </label>

                <label class="pure-material-radio">
                    <input class="inp" type="radio" name="gender" id="female" value="female"
                        <?php if( ($array[3]) == "Female") { ?> checked <?php } ?>>
                    <span style="font-size: initial">Female</span>
                </label>

            </div>

            <!-- DISTRICT-->
            <div class="wrap-input" id="District">
                <label class="lbl" for="autocomplete">
                    <span>District <i style=' color:red;'> *</i></span>
                </label>
                <input class="inp" id="autocomplete" type="text" name="district" minlength="2" maxlength="100" placeholder="District" value="<?= $array[4]?>">
            </div>
            <!-- Autocomplete places api -->
            <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/places.html"); ?>

            <!-- EDUCATION-->
            <div class="wrap-input" id="Education" >
                <label class="lbl" for="education">
                    <span>Education <i style=' color:red;'> *</i></span>
                </label>
                <input class="inp" style="width: 65%;" id="education" type="text" name="education" minlength="2" maxlength="35" placeholder="Education" value="<?= $array[5]?>">
            </div>

            <!-- OCCUPATION-->
            <div class="wrap-input" id="Occupation" >
                <label class="lbl" for="occupation">
                    <span>Occupation <i style=' color:red;'> *</i></span>
                </label>
                <input class="inp" style="width: 65%;" id="occupation" type="text" name="occupation" minlength="2" maxlength="35" placeholder="Occupation" value="<?= $array[6]?>">
            </div>

            <!-- EMAIL-->
            <div class="wrap-input" id="Email" >
                <label class="lbl" for="email">
                    <span>Email <i style=' color:red;'> *</i></span>
                </label>
                <input class="inp" id="email" type="email" name="email" maxlength="65" placeholder="Email address" value="<?= $array[7]?>">
            </div>

            <!-- MARITAL STATUS-->
            <div class="wrap-input" id="Marital-Status" >
                <label class="lbl" for="marital-status">
                    <span>Mar. Status</span>
                </label>
                <select class="inp" id="marital-status" name="marital-status" style="cursor: pointer">
                    <option value="" disabled selected>Select your marital status</option>
                    <option value="">Do not show</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>

            <!-- DESCRIPTION-->
            <div style="float: left; clear: left; margin-left: 20px;">
                <label style=" float:left; clear: left; color: #999999;">Description (max. 300 characters)</label>
                <textarea rows="6" cols="60" id="description" placeholder="Description" maxlength="300" style=" float:left; clear: left;"><?= $array[8]?>
                </textarea>
            </div>

        </div>

        <!--FOOTER-->
        <div class="modal-footer">
            <div id="response">* Required fields</div>
<!--            <button class="btn-change" id="cancel"> CANCEL</button>-->
            <button class="btn-change" onclick="updateInformation()"> SAVE CHANGES</button>
        </div>
    </div>

</div>

<script>
    //Set the marital status field
    var maritalStatus = "<?= $array[9]; ?>";
    $("#marital-status option:contains("+maritalStatus+")").attr('selected', 'selected');

    //Update information
    function updateInformation() {

        var name=$("#name").val();
        var surname=$("#surname").val();
        var birthday=$("#bday").val();
        var gender=$("input[name=gender]:checked").val();
        var district=$("input[name=district]").val();
        var education=$("#education").val();
        var occupation=$("#occupation").val();
        var email=$("#email").val();
        var description=$("#description").val();
        var maritalStatus=$("#marital-status").val();

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
                    occupation:occupation,
                    email:email,
                    description:description,
                    maritalStatus:maritalStatus
                },
                success:function(response) {
                    if(response == "success") {
                        $('#response').html('<p style="color:#009933; font-size:17px; margin:0;">' +
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

</script>