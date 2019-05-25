<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->

<!-- The Modal -->
<div id="myModal" class="modal" style="padding-top: 100px;">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Add your Interests</h2>
            <p class="instruction" style="color: black; font-size: 16px;">People can find you based on your interests</p>
        </div>

        <form onsubmit="return addInterests();">
            <!--BODY-->
            <div class="modal-body">

                <!--SEARCH INTEREST-->
                <div class="wrap-input wrap-login" style="border: 2px solid #cccccc; margin: 0px 10px 10px 20px; width: 90%;">
                    <label class="lbl" for="search">
                        <span class="fa fa-search"></span>
                    </label>
                    <input class="inp" id="search" maxlength="25" placeholder="Search for interest..." autocomplete="off"/>
                </div>
                <!--Autocomplete for interests-->
                <?php echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/Profile/autocomplete.php?all=false"); ?>

                <div id="chosen-interests">
                    <!-- User's chosen interests will be placed here-->
                </div>

                <div id="response"></div>

            </div>

            <!--FOOTER-->
            <div class="modal-footer">
                <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                <button id="add" class="btn-change" type="submit"> ADD</button>
            </div>

        </form>
    </div>

</div>

<script>

    function addInterests() {
        //Disable ADD button to prevent user to click it multiple times. This causes issue !
        $("#add").prop('disabled', true);

        //Get the names of the selected interests and put them in a array.
        var interests = new Array();
        $(".chosen-interest p").each(function(){
            var interestName = $(this).text();
            interests.push(interestName);
        });

        //If no interests selected show error message. Otherwise proceed to insert them.
         if (interests.length > 0){
            $.ajax
            ({
                type:'post', url:'Profile/insertInterests.php',
                data:{ interestsArray: interests },
                success:function(response)
                {
                    if(response == "success") {
                        //Display successful message.
                        $('#response').html('<p style="color:#009933; font-size:16px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Selected interests have been added successfully !</span></p>').addClass("successResponse");

                        //Add selected interests in the interests div on Profile.php page.
                        interests.forEach(myFunction);
                        function myFunction(value) {
                            $(".interests").append("<div class='interest'><p>"+value+"</p><i class='fa fa-trash-o' onclick='deleteInterest(this)'></i></div>")
                        }

                        //After 3 seconds exit window
                        setTimeout(function(){
                            modal.style.display = "none";
                        }, 3000);
                    }
                    else{
                        alert("fail");
                    }
                }
            });
        }
        else{
            alert("No interests have been selected !")
        }

        return false;
    }

    //Add box shadow on input fields when focus
    $.getScript( "includes/inputBoxShadow.js" );
</script>