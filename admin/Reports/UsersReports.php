<?php
session_start();
//check if user has the right to visit the page
if (!isset($_SESSION['user_id'])){
    header("Location: http://localhost/Local%20Server/ConnectPlatform/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html style="background-color: #f1f1f1;">
<head>
    <title>Get in Touch - Users reports</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/checkBoxStyle.css"><!--check box style-->
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/radioButtonStyle.css"> <!--Radio button style-->
    <link rel="stylesheet" href="../../indexStyle.css">
    <style>
        #users {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            background-color: #fefefe;
        }

        #users td, #users th {
            border: 1px solid #ddd;
            padding: 8px 2px;
            font-size: 14px;
            text-align: center;
        }


        #users tr:nth-child(even){background-color: #f2f2f2;}

        #users tr:hover {
            cursor: pointer;
            background-color: #ddd;
        }

        #users th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #0073b1;
            color: white;
            cursor: initial;
        }

        .wrap-input{
            width: 30% !important;
        }
    </style>
    <script>
        $(document).ready(function () {
           fetchUsers();

            // Dont let user uncheck both gender checkboxes. One must be always checked.
            $("#male, #female").click(function () {
                if($('input[type="checkbox"]:checked').length == 0) {
                    $(this).prop('checked', true);
                }
            });

            //Add box shadow on input fields when focus
            $.getScript( "../../includes/inputBoxShadow.js" );

            //Prevents user to enter any language except English. No special characters are allowed except in passwords and emails
            $.getScript( "http://localhost/Local%20Server/ConnectPlatform/includes/onlyEnglish.js" );

        });



        function fetchUsers() {
            $.ajax({
                method: "POST",
                url: "fetchUsers.php",
                success: function (response) {
                    $("#users").html(response);
                }
            });
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
            userID = $(e).find(".reports-userID").text(); // get the user's id whose profile is going to be shown
            $('#modal-box').load("viewUsersProfile.php");
            return false;
        }

        //Hide spinner and show page
        $(function() {
            $(".preload").fadeOut(500, function() {
                $("#Matches-pagecontent").fadeIn(500);
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

            if (minAge > maxAge){
                alert("Minumum age must be less than maximum age");
                return false;
            }

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

            //Get Occupation
            var occupation = $("input[name=occupation]").val();

            //Get Email
            var email = $("#email").val();

            //Get Marital Status
            var maritalStatus= $("#marital-status").val();

            //Registration Date
            var registrationDateFrom = $("#registration-from").val();
            var registrationDateTo = $("#registration-to").val();

            //Last Login Date
            var lastLoginDateFrom = $("#lastLogin-from").val();
            var lastLoginDateTo = $("#lastLogin-to").val();

            //Get selected column for sorting
            var orderBy = $("#sorting").val();

            //Get sorting type
            var orderByType=$("input[name=sorting-type]:checked").val();


            $.ajax
            ({
                method: "POST",
                url: "findFilteredUsersReports.php",
                data: {
                    name: name,
                    surname: surname,
                    minAge: minAge,
                    maxAge: maxAge,
                    gender1: gender1,
                    gender2: gender2,
                    district: district,
                    education: education,
                    occupation: occupation,
                    email:email,
                    maritalStatus: maritalStatus,
                    registrationDateFrom:registrationDateFrom,
                    registrationDateTo:registrationDateTo,
                    lastLoginDateFrom:lastLoginDateFrom,
                    lastLoginDateTo: lastLoginDateTo,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#users").html(response);// append results
                }
            });

            return false;
        }
    </script>
</head>

<body>
<!--Loading spinner-->
<div class="preload"><img src="../../images/Spinner.gif"></div>

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/adminHeader.php"); ?>

<!--Place modal box-->
<div id="modal-box"></div>

<div id="usersReports-filters" style="margin: 15px; width:81%; overflow: hidden; ">

    <!--SEARCH FORM-->
    <form id="reportsFilters-form" style="float: left;" onsubmit="return getFilterResults();">
        <fieldset style="background-color: #e6e6e6; padding-top: 20px; border: #999999 1px solid;border-radius: 5px;">

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
                <input class="inp" type="number" id="minAge" style="border: #cccccc solid 1px; width: 20%" min="18" max="99"  placeholder="From">
                <input class="inp" type="number" id="maxAge" style="border: #cccccc solid 1px; width: 20%" min="18"  max="99"  placeholder="To">
            </div>

            <!--GENDER-->
            <div class="wrap-input" id="Gender" style="float: left;">

                <label class="lbl" for="gender">
                    <span class="fa fa-venus-mars" style="margin-top: 15px;"></span>
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
                <input class="inp" id="education" type="text" name="education" minlength="2" maxlength="65" placeholder="Education">
            </div>

            <!-- OCCUPATION-->
            <div class="wrap-input" id="Occupation" style="float: left;">
                <label class="lbl" for="occupation">
                    <span class="fa fa-briefcase"></span>
                </label>
                <input class="inp" id="occupation" type="text" name="occupation" minlength="2" maxlength="65" placeholder="Occupation">
            </div>

            <!-- EMAIL-->
            <div class="wrap-input" id="Email" style="float: left;">
                <label class="lbl" for="email">
                    <span class="fa fa-at"></span>
                </label>
                <input class="inp" id="email" type="email" name="email" minlength="2" maxlength="65" placeholder="Email">
            </div>

            <!-- MARITAL STATUS-->
            <div class="wrap-input" id="Marital-Status" style="float: left;" >
                <label class="lbl" for="marital-status">
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

            <!--REGISTRATION DATE-->
            <div id="Registration-Date" style="float: left; width: 48%; margin: 2px 0px 15px 0px; position: relative;">
                <fieldset>

                    <legend>Registration date</legend>

                    <!--FROM-->
                    <div class="wrap-input" id="Registration-from" style="margin:0 0 0 0; float: left; width: auto !important; padding-bottom: 5px;">
                        <label class="lbl" for="registration-from">
                            <span style="font-size: 14px;">From</span>
                        </label>
                        <input class="inp" id="registration-from" type="date" name="registration-from"
                               min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 60%;">
                    </div>

                    <!--TO-->
                    <div class="wrap-input" id="Registration-to" style="margin:0 0 0 5px; float: left; width: auto !important; padding-bottom: 5px;">
                        <label class="lbl" for="registration-to">
                            <span style="font-size: 14px;">To</span>
                        </label>
                        <input class="inp" id="registration-to" type="date" name="registration-to"
                               min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 65%;">
                    </div>

                </fieldset>

            </div>

            <div id="Last-Login" style="float: left; width: 48%; margin: 2px 0px 15px 25px; position: relative;">
                <fieldset>

                    <legend>Last Login date</legend>

                    <!--FROM-->
                    <div class="wrap-input" id="LastLogin-from" style="margin:0 0 0 0;float: left; width: auto !important; padding-bottom: 5px;">
                        <label class="lbl" for="lastLogin-from">
                            <span style="font-size: 14px;">From</span>
                        </label>
                        <input class="inp" id="lastLogin-from" type="date" name="lastLogin-from"
                               min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 60%;">
                    </div>

                    <!--TO-->
                    <div class="wrap-input" id="LastLogin-to" style="margin:0 0 0 5px; float: left; width: auto!important; padding-bottom: 5px;">
                        <label class="lbl" for="lastLogin-to">
                            <span style="font-size: 14px;">To</span>
                        </label>
                        <input class="inp" id="lastLogin-to" type="date" name="lastLogin-to"
                               min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 65%;">
                    </div>

                </fieldset>

            </div>

            <!--SORT BY-->
            <div class="wrap-input" id="Sorting" style="float: left; width: 47% !important; padding-bottom: 5px;">
                <label class="lbl" for="gender">
                    <span>Sort By</span>
                </label>

                <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 28%;">
                    <option value="" disabled selected>Select column</option>
                    <option value="Name">Name</option>
                    <option value="Surname">Surname</option>
                    <option value="Birthdate">Age</option>
                    <option value="Gender">Gender</option>
                    <option value="District">District</option>
                    <option value="Education">Education</option>
                    <option value="Occupation">Occupation</option>
                    <option value="MaritalStatus">Marital status</option>
                    <option value="Email">Email</option>
                    <option value="RegistrationDate">Registration Date</option>
                    <option value="LastLogin">Last Login</option>
                </select>

                <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                    <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC" checked>
                    <span style="font-size: initial">Ascending</span>
                </label>

                <label class="pure-material-radio" style="margin-left: 0px; font-size: 12px;">
                    <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC">
                    <span style="font-size: initial">Descending</span>
                </label>

            </div>

            <!--BUTTON-->
            <div style="display: block; width: 100%; clear: both;">
                <button type="button" onclick="fetchUsers();document.getElementById('reportsFilters-form').reset();" class="btn" style="text-decoration: none; float: left; margin: 15px 0px 0px 90px;">RESET</button>
                <button class="btn" type="submit" style="float: right; margin: 15px 85px 0px 0px;">SEARCH</button>
            </div>

        </fieldset>
    </form>
</div>


<table id="users">
</table>




</body>
</html>
