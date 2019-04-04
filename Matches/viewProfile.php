<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/indexStyle.css">
<script>
    // Show notifications
    getInformations();
    function getInformations() {
        $.ajax
        ({
            method: "POST",
            data:{userID: userID},
            url: "http://localhost/Local%20Server/ConnectPlatform/Matches/getInformations.php",
            success: function (response) {
                $("#results").append(response);
            }
        });
        return false;
    }

</script>
<style>
    .profile-Picture{
        border-radius: 50%;
        border: solid 2px #d9d9d9;
        width: 100px; height: 100px;
        margin-bottom:2%;
        object-fit: cover;
    }

    .profileInformation p{
        font-size: 18px;
        float: left; margin-top: 0px; margin-bottom: 5px;
    }

    .profileInformation{
        margin-bottom: 20px;
    }

    #description-content{
        font-size: 14px;
    }

    .more-details span{
        font-size: 18px !important;
        float: left; clear: left;
        color: #999999 !important;
    }

    .more-details p{
        display: inline-block;
        margin-left: 10px;
        margin-top: 5px;
        color: initial;
        font-family: "Roboto", sans-serif;
    }

    .viewProfile-interests{
        float: left; clear: left; width: 100%; margin-bottom: 5px;
    }

    .viewProfile-interests .interest{
        margin-left: 0;
    }

    .viewProfile-interests .viewProfile-chosen-interest{
        width: auto;
        background-color: #fefefe !important;
        border: #0066cc 1.5px solid !important;
        border-radius: 50px;
        color: #0066cc !important;
        padding: 10px;
        margin: 3px;
        font-size: 16px;
        outline: 0;
        transition: 0.2s;
        transition-timing-function: ease-in-out;
    }

    .viewProfile-chosen-interest span{
        font-size: 18px;
        margin-left: 5px;
    }

    .viewProfile-chosen-interest p{
        display: inline;
    }

</style>
<!-- The Modal -->
<div id="myModal" class="modal" style="padding-top: 30px;">

    <!-- Modal content -->
    <div class="modal-content" style="width: 50%;">

        <div class="modal-header">
            <span class="close">&times;</span>
        </div>

        <div class="modal-body" style="max-height: 470px; overflow: auto; margin-top: 30px;">

            <div id="results">

            </div>

        </div>

        <!--FOOTER-->
        <div class="modal-footer">
            <button class="btn-change" style="margin-left: 73.5%;" onclick="modal.style.display='none';"> CLOSE</button>
        </div>

    </div>

</div>


