<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    /*body {font-family: Arial, Helvetica, sans-serif;}*/

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
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
        width: 30%;
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
        padding: 15px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .modal-footer {
        padding: 12px 16px;
        background-color: #bcbcbc;
        color: white;
    }

    .btn-change{
        background-color: #4d4d4d;
        color: ivory;
        display: inline-block;
        padding: 6px 12px;
        margin: 1% 0% 0% 7%;
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

    .btn-change:hover{
        background-color: #333333;
    }

    .chosen-interest{
        width: auto;
        cursor: pointer;
        background-color:#0066cc;
        border: none;
        border-radius: 50px;
        color: ivory;
        padding: 10px;
        margin: 3px;
        font-size: 16px;
        outline: 0;
        transition: 0.2s;
        transition-timing-function: ease-in-out;
    }

    .chosen-interest:hover{
        background-color: #004d99;
    }

    .chosen-interest span{
        font-size: 18px;
        margin-left: 5px;
    }

    .chosen-interest p{
        display: inline;
    }

    #chosen-interests{
        min-height: 150px;
    }

</style>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Add Interest</h2>
        </div>

        <form onsubmit="return addInterests();">
            <!--BODY-->
            <div class="modal-body">

                <!--SEARCH INTEREST-->
                <?php echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/Profile/autocomplete.html"); ?>
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

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Get the cancel button
    var cancel = document.getElementById('cancel');

    // Open the modal
    modal.style.display = "block";

    // When the user clicks on <span> (x), close the modal
    span.onclick= function() {
        modal.style.display = "none";
    }

    cancel.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


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
                        $('#response').html('<p style="color:#009933; font-size:17px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Selected interests have been added successfully !</span></p>');
                        //After 3 seconds exit window and reload page
                        setTimeout(function(){
                            modal.style.display = "none";
                            location.reload();
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