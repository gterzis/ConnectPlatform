<?php
    session_start();
    //check if user has the right to visit the page
    if (!isset($_SESSION['user_id'])){
        header("Location: http://localhost/Local%20Server/ConnectPlatform/index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Get in Touch - Matches</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/checkBoxStyle.css"><!--check box style-->
    <link rel="stylesheet" href="../indexStyle.css">
    <script>
        $(document).ready(function () {
            // Show matches
            fetchMatches();
            function fetchMatches() {
                $.ajax
                ({
                    method: "POST",
                    url: "http://localhost/Local%20Server/ConnectPlatform/Matches/fetchMatches.php",
                    success: function (response) {
                        $("#results").append(response);
                    }
                });
                return false;
            }

            // Dont let user uncheck both gender checkboxes
            $("#male, #female").click(function () {
                if($('input[type="checkbox"]:checked').length == 0) {
                    $(this).prop('checked', true);
                }
            });

        });
        
        //get filter results
        function getFilterResults() {

            //Get name and surname
            var name = $("#name").val();
            var surname = $("#surname").val();

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

            $.ajax
            ({
                method: "POST",
                url: "http://localhost/Local%20Server/ConnectPlatform/Matches/findFilteredUsers.php",
                data: {
                    name: name,
                    surname: surname,
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
                    $("#results").html(response);// append results
                    $("#results").fadeIn(500);// fade in results
                }
            });

            return false;
        }

        //delete match
        function deleteMatch(clickedBtn) {
            if (confirm('Are you sure you want to delete this match?')) {
                var matchedUserID = $(clickedBtn).siblings(".resultInformation").find(".userID").text(); // get request sender's id
                $.ajax({
                    method: "POST",
                    url: "http://localhost/Local%20Server/ConnectPlatform/Matches/deleteMatch.php",
                    data:{matchedUserID: matchedUserID},
                    success: function(response){
                        if (response == "success"){
                            $(clickedBtn).text("Deleted").prop('disabled', true);// change button's text and disable it
                            $(clickedBtn).siblings(".chat-btn").hide();// hide decline button
                        }
                        else {
                            alert(response);
                        }
                    }
                });
            }
            else {// Do nothing!
                }

            return false;
        }
        //show filters field
        function showFilters() {
            $("#filters").fadeToggle();
            return false;
        }
        //show user's profile
        var userID;
        function showProfile(e) {
             userID = $(e).parent().find(".userID").text(); // get the user's id whose profile is going to be shown
            $('#modal-box').load("http://localhost/Local%20Server/ConnectPlatform/Matches/viewProfile.php");
            return false;
        }

        //Hide spinner and show page
        $(function() {
            $(".preload").fadeOut(500, function() {
                $("#Matches-pagecontent").fadeIn(500);
            });
        });
    </script>
</head>
<body id="matches-pagecontent">
<!--Loading spinner-->
<div class="preload"><img src="../images/Spinner.gif">
</div>

<div id="Matches-pagecontent" hidden>

    <!--HEADER-->
    <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/userHeader.php"); ?>

    <!--Place modal box-->
    <div id="modal-box"></div>

    <div id="matches-main">
        <h2>Matches</h2>
        <a id="search-filters" onclick="showFilters();">Search with filters</a>

        <div id="filters" style="margin: 15px;" hidden>

            <!--SEARCH FORM-->
            <form style="float: left;" onsubmit="return getFilterResults();">
                <fieldset style="background-color: #e6e6e6; padding-top: 20px; border: #cccccc 1px solid;border-radius: 5px;">

                <!--NAME-->
                <div class="wrap-input" id="Name" style="float: left;">
                    <label class="lbl" for="name">
                        <span class="fa fa-user-o"></span>
                    </label>
                    <input class="inp" id="name" type="text" name="name" maxlength="20" placeholder="Name">
                </div>

                <!-- SURNAME-->
                <div class="wrap-input" id="Surname" style="float: left;">
                    <label class="lbl" for="surname">
                        <span class="fa fa-user-o"></span>
                    </label>
                    <input class="inp" id="surname" type="text" name="surname" maxlength="25" placeholder="Surname" >
                </div>

                <!--AGE-->
                <div class="wrap-input" id="Bday" style="float: left;">
                    <label class="lbl" for="bday">
                        <span >Age</span>
                    </label>
                    <input class="inp" type="number" id="minAge" style="border: #cccccc solid 1px; width: 20%" min="18"  placeholder="From" required>
                    <input class="inp" type="number" id="maxAge" style="border: #cccccc solid 1px; width: 20%"  max="99"  placeholder="To" required>
                </div>

                <!--GENDER-->
                <div class="wrap-input" id="Gender" style="float: left; padding: 17px 0px;">

                    <label class="lbl" for="gender">
                        <span class="fa fa-venus-mars"></span>
                    </label>

                    <label class="pure-material-checkbox">
                        <input type="checkbox" name="gender" id="male" checked="checked">
                        <span>Male</span>
                    </label>

                    <label class="pure-material-checkbox">
                        <input type="checkbox" name="gender" id="female" checked="checked">
                        <span>Female</span>
                    </label>

                </div>

                <!-- DISTRICT-->
                <div class="wrap-input" id="District" style="float: left;">
                    <label class="lbl" for="autocomplete">
                        <span class="fa fa-home"></span>
                    </label>
                    <input class="inp" id="autocomplete" type="text" name="district" minlength="2" maxlength="100" placeholder="District">
                </div>
                <!-- Autocomplete places api -->
                <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/places.html"); ?>

                <!-- EDUCATION-->
                <div class="wrap-input" id="Education" style="float: left;">
                    <label class="lbl" for="education">
                        <span class="fa fa-mortar-board"></span>
                    </label>
                    <input class="inp" id="education" onFocus="geolocate()" type="text" name="education" minlength="2" maxlength="25" placeholder="Education">
                </div>

                <!--SEARCH INTEREST-->
                <div class="wrap-input" style="float: left;">
                    <label class="lbl" for="search">
                        <span class="fa fa-search"></span>
                    </label>
                    <input class="inp" id="search" maxlength="25" placeholder="Search for interest..." autocomplete="off"/>
                </div>

                <!-- MARITAL STATUS-->
                <div class="wrap-input" id="Marital-Status" style="float: left;" >
                    <label class="lbl" for="education">
                        <span class="fa fa-heart"></span>
                    </label>
                    <select class="inp" id="marital-status" name="marital-status" style="cursor: pointer">
                        <option value="" disabled selected>Select marital status</option>
                        <option value="Any">Any</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>

                <!--Autocomplete for interests-->
                <?php echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/Profile/autocomplete.php?all=true"); ?>

                <div id="chosen-interests" style="float: left; height: auto; width: inherit; margin: 0px 15px 15px 15px;">
                    <!-- User's chosen interests will be placed here-->
                </div>

                <!--BUTTON-->
                <div style="display: block; ">
                    <button class="btn" type="submit" style="float: right; margin: 15px 25px 0px 0px;">SEARCH</button>
                </div>

                </fieldset>
            </form>
        </div>

        <div id="results">

        </div>

    </div>

</div>
</body>
</html>
<script>
    //Add box shadow on input fields when focus
    $.getScript( "../includes/inputBoxShadow.js" );

    //Prevents user to enter any language except English
    $.getScript( "http://localhost/Local%20Server/ConnectPlatform/includes/onlyEnglish.js" );

    //All above do not work when put in <head> :(
</script>