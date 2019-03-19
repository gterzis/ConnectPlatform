<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="http://localhost/Local%20Server/ConnectPlatform/includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/indexStyle.css">
<script>
    // Show notifications
    // getInformations();
    // function getInformations() {
    //     $.ajax
    //     ({
    //         method: "POST",
    //         url: "http://localhost/Local%20Server/ConnectPlatform/Profile/Notifications/fetchNotifications.php",
    //         success: function (response) {
    //             $("#results").append(response);
    //         }
    //     });
    //     return false;
    // }


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
        margin-bottom: 30px;
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

    .chosen-interest{
        width: auto;
        background-color: #fefefe;
        border: #0066cc 1.5px solid;
        border-radius: 50px;
        color: #0066cc;
        padding: 10px;
        margin: 3px;
        font-size: 16px;
        outline: 0;
        transition: 0.2s;
        transition-timing-function: ease-in-out;
    }

    .chosen-interest span{
        font-size: 18px;
        margin-left: 5px;
    }

    .chosen-interest p{
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

                <div class='result'>

                    <img class='profile-Picture' src='http://localhost/Local%20Server/ConnectPlatform/profile-pictures/17.jpg' alt='' width='25' height=50' >

                    <div class='profileInformation' style='display: inline-block; margin-left: 15px;'>
                        <p class='userID' hidden>$data[ID]</p>
                        <p style='font-weight: bold; font-size: 22px; color: #0066cc;'> George Terzis</p>
                        <p style='clear: left;'>Male &nbsp;</p>
                        <span style='float: left; padding-top: 1px;'> &#9642; </span>
                        <p>&nbsp; 26 years old</p>
                        <span style='float: left; padding-top: 1px;'> &nbsp; &#9642; </span>
                        <p>&nbsp; Single</p>
                    </div>

                    <hr style="width: 100%; margin-top: 3px">

                    <div id="description">
                        <p id="description-content">
                            Experienced Shipping Specialist with a demonstrated history of working in the logistics and supply chain industry. Skilled in Operations Management, Microsoft Excel, Customer Service, Microsoft Word, and Inventory Management. Strong operations professional with a High School Diploma focused in Business Administration and Management, General from Intercollege.
                        </p>
                    </div>

                    <hr style="width: 100%; margin-top: 3px">

                    <!--PERSONAL INFORMATION-->
                    <div class="more-details">
                        <span class="fa fa-home"><p> Tseri, Nicosia</p></span>
                        <span class="fa fa-mortar-board"><p> Cyprus University of Technology</p></span>
                        <span class="fa fa-briefcase"><p> Senior Programmer at Google</p></span>
                    </div>

                    <!--INTERESTS-->
                    <div class="viewProfile-interests" >
                        <h2 style="margin-left: 0px; margin-top: 0;">Interests</h2>
                        <!--Any user's interests will be placed here-->
                        <button class="chosen-interest" type="button"><p>Football</p></button>
                        <button class="chosen-interest" type="button"><p>Football</p></button>
                        <button class="chosen-interest" type="button"><p>Football</p></button>
                        <button class="chosen-interest" type="button"><p>Football</p></button>
                        <button class="chosen-interest" type="button"><p>Board games</p></button>
                        <button class="chosen-interest" type="button"><p>Board games</p></button>
                        <button class="chosen-interest" type="button"><p>Board games</p></button>
                        <button class="chosen-interest" type="button"><p>Board games</p></button>
                        <button class="chosen-interest" type="button"><p>Board games</p></button>
                    </div>

                </div>
            </div>

        </div>

        <!--FOOTER-->
        <div class="modal-footer">
            <button class="btn-change" style="margin-left: 73.5%;" onclick="modal.style.display='none';"> CLOSE</button>
        </div>

    </div>

</div>


