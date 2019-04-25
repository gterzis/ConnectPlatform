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
    <title>Get in Touch - Interests reports</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/radioButtonStyle.css"> <!--Radio button style-->
    <link rel="stylesheet" href="../../../indexStyle.css">
    <style>
        #interests {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        #interests td, #interests th {
            border: 1px solid #ddd;
            padding: 8px 2px;
            font-size: 14px;
            text-align: center;
        }


        #interests tr:nth-child(even){background-color: #f2f2f2;}

        #interests tr:hover {
            cursor: pointer;
            background-color: #ddd;
        }

        #interests th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #0073b1;
            color: white;
            cursor: initial;
        }
    </style>
    <script>
        $(document).ready(function () {
            fetchInterests();

            //Add box shadow on input fields when focus
            $.getScript( "../../../includes/inputBoxShadow.js" );

            //Prevents user to enter any language except English. No special characters are allowed except in passwords and emails
            $.getScript( "http://localhost/Local%20Server/ConnectPlatform/includes/onlyEnglish.js" );

        });

        // fetch interests
        function fetchInterests() {
            $.ajax({
                method: "POST",
                url: "fetchInterests.php",
                success: function (response) {
                    $("#interests").html(response);
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
                $("#interests-pagecontent").fadeIn(500);
            });
        });

        //get filter results
        function getFilterResults() {

            //Get interest name and category
            var interestName = $("#interestName").val();
            var category = $("#category").val();

            // //Get number of selected times range
            var selectedFrom = $("#selectedFrom").val();
            var selectedTo = $("#selectedTo").val();

            // //Get active matches range
            var activeFrom = $("#activeFrom").val();
            var activeTo = $("#activeTo").val();

            // //Get deactivated matches range
            var deactivatedFrom = $("#deactivatedFrom").val();
            var deactivatedTo = $("#deactivatedTo").val();

            // //Get total matches range
            var totalFrom = $("#totalFrom").val();
            var totalTo = $("#totalTo").val();

            //Get sorting type
            var groupBy=$("input[name=groupBy]:checked").val();

            //Get selected column for sorting
            var orderBy = $("#sorting").val();

            //Get sorting type
            var orderByType=$("input[name=sorting-type]:checked").val();


            $.ajax
            ({
                method: "POST",
                url: "findFilteredInterestsReports.php",
                data: {
                    interestName: interestName,
                    category: category,
                    selectedFrom: selectedFrom,
                    selectedTo: selectedTo,
                    activeFrom:activeFrom,
                    activeTo:activeTo,
                    deactivatedFrom:deactivatedFrom,
                    deactivatedTo:deactivatedTo,
                    totalFrom: totalFrom,
                    totalTo: totalTo,
                    groupBy: groupBy,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#interests").html(response);// append results
                }
            });

            return false;
        }
    </script>
</head>

<body>
<!--Loading spinner-->
<div class="preload"><img src="../../../images/Spinner.gif"></div>

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/adminHeader.php"); ?>

<!--Place modal box-->
<div id="modal-box"></div>

<div id="usersReports-filters" style="margin: 15px; width:75%; overflow: hidden; ">

    <!--SEARCH FORM-->
    <form id="reportsFilters-form" style="float: left;" onsubmit="return getFilterResults();">
        <fieldset style="background-color: #e6e6e6; padding-top: 20px; border: #999999 1px solid;border-radius: 5px;">

            <!--INTEREST NAME-->
            <div class="wrap-input" id="InterestName" style="float: left;">
                <label class="lbl" for="interestName">
                    <span class="fa fa-futbol-o"></span>
                </label>
                <input class="inp" id="interestName" type="text" name="interestName" maxlength="35" placeholder="Interest name">
            </div>

            <!-- CATEGORY-->
            <div class="wrap-input" id="Category" style="float: left;">
                <label class="lbl" for="category">
                    <span class="fa fa-futbol-o"></span>
                </label>
                <input class="inp" id="category" type="text" name="category" maxlength="35" placeholder="Category" >
            </div>

            <!--INTEREST NUMBER OF SELECTED TIMES-->
            <div class="wrap-input" id="Selected" style="float: left;">
                <label class="lbl" for="selected">
                    <span>Selected</span>
                </label>
                <input class="inp" type="number" id="selectedFrom" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="From">
                <input class="inp" type="number" id="selectedTo" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="To">
            </div>

            <!--ACTIVE MATCHES-->
            <div class="wrap-input" id="ActiveMatches" style="float: left;">
                <label class="lbl" for="activeMatches">
                    <span >Active M.</span>
                </label>
                <input class="inp" type="number" id="activeFrom" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="From">
                <input class="inp" type="number" id="activeTo" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="To">
            </div>

            <!--DEACTIVATED MATCHES-->
            <div class="wrap-input" id="DeactivatedMatches" style="float: left;">
                <label class="lbl" for="deactivatedMatches">
                    <span>Deactivated M.</span>
                </label>
                <input class="inp" type="number" id="deactivatedFrom" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="From">
                <input class="inp" type="number" id="deactivatedTo" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="To">
            </div>

            <!--TOTAL MATCHES-->
            <div class="wrap-input" id="TotalMatches" style="float: left;">
                <label class="lbl" for="totalMatches">
                    <span>Total M.</span>
                </label>
                <input class="inp" type="number" id="totalFrom" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="From">
                <input class="inp" type="number" id="totalTo" style="border: #cccccc solid 1px; width: 20%" min="0" placeholder="To">
            </div>

            <!--GROUP BY-->
            <div class="wrap-input" id="GroupBy" style="float: left; padding-bottom: 5px; width: 38%;">
                <label class="lbl" for="GroupBy">
                    <span>Group By </span>
                </label>

                <label class="pure-material-radio" style="margin-left: 5px; margin-right: 2px; font-size: 12px;">
                    <input class="inp" type="radio" name="groupBy" id="InterestName" value="InterestName" checked>
                    <span style="font-size: initial">InterestName</span>
                </label>

                <label class="pure-material-radio" style="margin-left: 5px; font-size: 12px; ">
                    <input class="inp" type="radio" name="groupBy" id="Category" value="Category">
                    <span style="font-size: initial">Category</span>
                </label>

            </div>

            <!--SORT BY-->
            <div class="wrap-input" id="Sorting" style="float: left; width: 52% !important; padding-bottom: 5px;">
                <label class="lbl" for="sorting">
                    <span>Sort By</span>
                </label>

                <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 34%;">
                    <option value="" disabled selected>Select column</option>
                    <option value="InterestName">Interest name</option>
                    <option value="Category">Category</option>
                    <option value="active">Active matches</option>
                    <option value="noActive">Deactivated matches</option>
                    <option value="total">Total matches</option>
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
                <button type="button" onclick="fetchInterests();document.getElementById('reportsFilters-form').reset();" class="btn" style="text-decoration: none; float: left; margin: 15px 0px 0px 90px;">RESET</button>
                <button class="btn" type="submit" style="float: right; margin: 15px 85px 0px 0px;">SEARCH</button>
            </div>

        </fieldset>
    </form>
</div>

<table id="interests">
</table>

</body>
</html>
