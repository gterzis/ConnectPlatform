<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<style>
    .sendRequest-btn{
        float: right;
        margin-top: 3px; margin-right: 25px;
        color: #0066cc;
        border: #0066cc 1px solid;
        background-color: #fefefe;
        border-radius: 5px;
        padding: 7px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        outline: 0;
    }

    .sendRequest-btn:hover{
        background-color: #e6f2ff;
    }

    .resultInformation p{
        float: left; margin-top: 0px; margin-bottom: 5px;
    }

    .result{
        margin: 15px 15px 0px 30px;
    }

    .result .fa{
        color: #0066cc; font-size: 24px; float: left;
    }

    #results{
        font-family: Verdana, Helvetica, Arial;
        font-size: 15px;
    }

    #results hr{
        border: none; height: 1px; background-color: #e6e6e6; width: 95%; margin-top: 6px;
    }
</style>
<script>
    findUsers();
    function findUsers() {
        //Get age range
        var minAge = $("#minAge").val();
        var maxAge = $("#maxAge").val();

        //Get selected gender(s)
        var gender1 = "Female";
        var gender2 = "Male";
        if( $("#male").is(":checked") ){
            gender1 = "Male";
        }
        if ( $("#female").is(":checked") ){
            gender2 = "Female";
        }

        //Get District
        var district = $("input[name=district]").val();

        //Get Education
        var education = $("input[name=education]").val();

        //Get Marital Status
        var maritalStatus= $("#marital-status").val();

        //Get the names of the selected interests and put them in a array.
        var interests = new Array();
        $(".chosen-interest p").each(function(){
            var interestName = $(this).text();
            interests.push(interestName);
        });
        if (interests.length > 0 && interests.length < 6) {
            $.ajax
            ({
                method: "POST",
                url: "http://localhost/Local%20Server/ConnectPlatform/SearchUsers/findUsers.php",
                data: {
                    minAge: minAge,
                    maxAge: maxAge,
                    gender1: gender1,
                    gender2: gender2,
                    district: district,
                    education: education,
                    maritalStatus: maritalStatus,
                    interests: interests
                },
                success: function (response) {
                    $("#results").append(response);
                }
            });
        }
        else {
            alert("You must select at least one to five interests");
            modal.style.display='none'; //dont show modal
        }

        return false;
    }

    // Sending matching request
    function sendRequest(clickedBtn) {
        var receiverID = $(clickedBtn).siblings(".resultInformation").find(".userID").text();
        var commonInterests = $(clickedBtn).siblings(".resultInformation").find(".commonInterests").text();
        $.ajax({
            method: "POST",
            url: "http://localhost/Local%20Server/ConnectPlatform/SearchUsers/requestRegistration.php",
            data: {receiverID:receiverID, commonInterests: commonInterests},
            success: function(response){
                if (response == "success"){
                    $(clickedBtn).text("SENT").prop('disabled', true);// change button's text and disable it
                    alert("Request sent successfully !");
                }
                else {
                    alert(response);
                }
            }
        });
        return false;
    }
</script>
<!-- The Modal -->
<div id="myModal" class="modal" style="padding-top: 35px;">

    <!-- Modal content -->
    <div class="modal-content" style="width: 50%;">

        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Search results</h2>
        </div>

        <div class="modal-body">

            <div id="results" style="max-height: 420px; overflow: auto;">
            </div>

        </div>

        <!--FOOTER-->
        <div class="modal-footer">
            <button class="btn-change" style="margin-left: 73.5%;" onclick="modal.style.display='none';"> CLOSE</button>
        </div>

    </div>

</div>


