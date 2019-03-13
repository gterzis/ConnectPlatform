<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<style>
    .declineRequest-btn,
    .acceptRequest-btn{
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

    .declineRequest-btn{
        color: #cc0000;
        border: #cc0000 1px solid;
    }

    .declineRequest-btn:hover{
        background-color: #ffcccc;
    }

    .acceptRequest-btn:hover{
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

    .notification-Picture{
        border-radius: 50%;
        border: solid 2px #d9d9d9;
        width: 75px; height: 75px;
        margin-bottom:6%;
        object-fit: cover;
    }
</style>
<script>
    // Show notifications
    fetchNotifications();
    function fetchNotifications() {
        $.ajax
        ({
            method: "POST",
            url: "http://localhost/Local%20Server/ConnectPlatform/Profile/Notifications/fetchNotifications.php",
            success: function (response) {
                $("#results").append(response);
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
            <h2>Notifications</h2>
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


