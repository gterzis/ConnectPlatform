<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/radioButtonStyle.css">
    <link rel="stylesheet" href="../../../indexStyle.css">
    <style>

        table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 30%;
            margin-top: 10px;
            background-color: #fefefe;
        }

        td, th {
            border: 1px solid #ddd;
            padding: 8px 2px;
            font-size: 14px;
            text-align: center;
        }


        tr:nth-child(even){background-color: #f2f2f2;}

        tr:hover {
            cursor: pointer;
            background-color: #ddd;
        }

        th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #0073b1;
            color: white;
            cursor: initial;
        }

        body {font-family: Arial;}

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            /*border: 1px solid #ccc;*/
            border-top: none;

        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        //CHARTS
        google.charts.load('current', {packages: ['corechart', 'bar']});
        // on page loading draw charts
        google.charts.setOnLoadCallback(drawAgeChart);
        google.charts.setOnLoadCallback(drawDistrictChart);
        google.charts.setOnLoadCallback(drawEducationChart);
        google.charts.setOnLoadCallback(drawOccupationChart);
        google.charts.setOnLoadCallback(drawMaritalStatusChart);
        google.charts.setOnLoadCallback(drawRegistrationDateChart);
        google.charts.setOnLoadCallback(drawLastLoginDateChart);

        //AGE table
        function fetchAge() {
            var minAge = $("#minAge").val();
            var maxAge = $("#maxAge").val();

            //Get selected column for sorting
            var orderBy = $("#Age #sorting").val();

            //Get sorting type
            var orderByType=$("#Age input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getAge.php?data=table",
                data:{
                    minAge: minAge,
                    maxAge: maxAge,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#ageTable").html(response);
                }
            });

            return false;
        }

        //DISTRICT table
        function fetchDistrict() {
            var district = $("input[name=district]").val();

            //Get selected column for sorting
            var orderBy = $("#District #sorting").val();

            //Get sorting type
            var orderByType=$("#District input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getDistrict.php?data=table",
                data:{
                    district:district,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#districtTable").html(response);
                }
            });

            return false;
        }

        //EDUCATION table
        function fetchEducation() {
            var education = $("input[name=education]").val();

            //Get selected column for sorting
            var orderBy = $("#Education #sorting").val();
            //Get sorting type
            var orderByType=$("#Education input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getEducation.php?data=table",
                data:{
                    education:education,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#educationTable").html(response);
                }
            });

            return false;
        }

        //OCCUPATION table
        function fetchOccupation() {
            var occupation = $("input[name=occupation]").val();

            //Get selected column for sorting
            var orderBy = $("#Occupation #sorting").val();
            //Get sorting type
            var orderByType=$("#Occupation input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getOccupation.php?data=table",
                data:{
                    occupation:occupation,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#occupationTable").html(response);
                }
            });

            return false;
        }

        //MARITAL STATUS table
        function fetchMaritalStatus() {
            var maritalStatus= $("#marital-status").val();

            //Get selected column for sorting
            var orderBy = $("#MaritalStatus #sorting").val();
            //Get sorting type
            var orderByType=$("#MaritalStatus input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getMaritalStatus.php?data=table",
                data:{
                    maritalStatus: maritalStatus,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#maritalStatusTable").html(response);
                }
            });

            return false;
        }

        //REGISTRATION DATE table
        function fetchRegistrationDate() {
            //Registration Date
            var registrationDateFrom = $("#registration-from").val();
            var registrationDateTo = $("#registration-to").val();

            //Get selected column for sorting
            var orderBy = $("#RegistrationDate #sorting").val();
            //Get sorting type
            var orderByType=$("#RegistrationDate input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getRegistrationDate.php?data=table",
                data:{
                    registrationDateFrom: registrationDateFrom,
                    registrationDateTo: registrationDateTo,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#registrationDateTable").html(response);
                }
            });

            return false;
        }

        //LAST LOG IN DATE table
        function fetchLastLoginDate() {
            var lastLoginFrom = $("#lastLogin-from").val();
            var lastLoginTo = $("#lastLogin-to").val();

            //Get selected column for sorting
            var orderBy = $("#LastLoginDate #sorting").val();
            //Get sorting type
            var orderByType=$("#LastLoginDate input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getLastLoginDate.php?data=table",
                data:{
                    lastLoginFrom: lastLoginFrom,
                    lastLoginTo:lastLoginTo,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (response) {
                    $("#lastLoginDateTable").html(response);
                }
            });

            return false;
        }

        //Draw age chart
        function drawAgeChart() {
            fetchAge();//show table
            var minAge = $("#minAge").val();
            var maxAge = $("#maxAge").val();

            //Get selected column for sorting
            var orderBy = $("#Age #sorting").val();
            //Get sorting type
            var orderByType=$("#Age input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getAge.php?data=chart",
                dataType: "JSON",
                data: {
                    minAge: minAge,
                    maxAge: maxAge,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (data) {

                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('string', 'Age');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function (i, jsonData) {
                        var age = jsonData.age;
                        var users = jsonData.users;
                        Data.addRows([[String(age), Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Age"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: {groupWidth: "100%"},
                        width: 700,
                        height:500
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('ageChart'));
                    chart.draw(Data, Options);
                }
            });

            return false;
        }

        //Draw District Chart
        function drawDistrictChart(){
            fetchDistrict();// show table
            var district = $("input[name=district]").val();

            //Get selected column for sorting
            var orderBy = $("#District #sorting").val();
            //Get sorting type
            var orderByType=$("#District input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getDistrict.php?data=chart",
                dataType:"JSON",
                data:{
                    district:district,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (data) {
                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('string', 'District');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function(  i, jsonData){
                        var district = jsonData.district;
                        var users = jsonData.users;
                        Data.addRows([[district, Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "District"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: { groupWidth: "100%" },
                        width: 700,
                        height:500
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('districtChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Education Chart
        function drawEducationChart(){
            fetchEducation();// show table
            var education = $("input[name=education]").val();

            //Get selected column for sorting
            var orderBy = $("#Education #sorting").val();
            //Get sorting type
            var orderByType=$("#Education input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getEducation.php?data=chart",
                dataType:"JSON",
                data:{
                    education:education,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (data) {
                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('string', 'Education');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function(  i, jsonData){
                        var education = jsonData.education;
                        var users = jsonData.users;
                        Data.addRows([[education, Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Education"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: { groupWidth: "100%" },
                        width: 700,
                        height:500
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('educationChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Occupation Chart
        function drawOccupationChart(){
            fetchOccupation();// show table
            var occupation = $("input[name=occupation]").val();

            //Get selected column for sorting
            var orderBy = $("#Education #sorting").val();
            //Get sorting type
            var orderByType=$("#Education input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getOccupation.php?data=chart",
                dataType:"JSON",
                data:{
                    occupation:occupation,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (data) {
                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('string', 'Occupation');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function(  i, jsonData){
                        var occupation = jsonData.occupation;
                        var users = jsonData.users;
                        Data.addRows([[occupation, Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Occupation"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: { groupWidth: "100%" },
                        width: 700,
                        height:500
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('occupationChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Marital status Chart
        function drawMaritalStatusChart(){
            fetchMaritalStatus();// show table
            var maritalStatus= $("#marital-status").val();

            //Get selected column for sorting
            var orderBy = $("#MaritalStatus #sorting").val();
            //Get sorting type
            var orderByType=$("#MaritalStatus input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getMaritalStatus.php?data=chart",
                dataType:"JSON",
                data:{
                    maritalStatus: maritalStatus,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (data) {
                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('string', 'Marital Status');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function(  i, jsonData){
                        var maritalStatus = jsonData.maritalStatus;
                        var users = jsonData.users;
                        Data.addRows([[maritalStatus, Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Marital status"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: { groupWidth: "100%" },
                        width: 700,
                        height:500
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('maritalStatusChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Registration Date Chart
        function drawRegistrationDateChart(){
            fetchRegistrationDate();// show table
            var registrationDateFrom = $("#registration-from").val();
            var registrationDateTo = $("#registration-to").val();

            //Get selected column for sorting
            var orderBy = $("#RegistrationDate #sorting").val();
            //Get sorting type
            var orderByType=$("#RegistrationDate input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getRegistrationDate.php?data=chart",
                dataType:"JSON",
                data:{
                    registrationDateFrom:registrationDateFrom,
                    registrationDateTo:registrationDateTo,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (data) {
                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('date', 'Registration Date');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function(  i, jsonData){
                        var registrationDate = jsonData.registrationDate;
                        var users = jsonData.users;
                        Data.addRows([[new Date(jsonData.year, (jsonData.month)-1, jsonData.day), Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Registration date"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: { groupWidth: "100%" },
                        width: 700,
                        height:500
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('registrationDateChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Last Log in Date Chart
        function drawLastLoginDateChart(){
            fetchLastLoginDate();// show table
            var lastLoginFrom = $("#lastLogin-from").val();
            var lastLoginTo = $("#lastLogin-to").val();

            //Get selected column for sorting
            var orderBy = $("#LastLoginDate #sorting").val();
            //Get sorting type
            var orderByType=$("#LastLoginDate input[name=sorting-type]:checked").val();

            $.ajax({
                method: "POST",
                url: "getLastLoginDate.php?data=chart",
                dataType:"JSON",
                data:{
                    lastLoginFrom: lastLoginFrom,
                    lastLoginTo: lastLoginTo,
                    orderBy: orderBy,
                    orderByType: orderByType
                },
                success: function (data) {
                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('date', 'Last Login Date');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function(  i, jsonData){
                        var users = jsonData.users;
                        Data.addRows([[new Date(jsonData.year, (jsonData.month)-1, jsonData.day), Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Last Log-in date"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: { groupWidth: "100%" },
                        width: 700,
                        height:500
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('lastLoginDateChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //CURRENT DAY
        var currentDate = currentDate();
        function currentDate() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            today = dd + '/' + mm + '/' + yyyy;
            return today;
        }

        //print
        function printTable(printableArea, reportName) {

            // add header with date to the print page
            $("#"+printableArea+"").prepend("<h1 id='printHeader' style='text-align: center;'> Get In Touch - "+reportName+" Report</h1><h3 id='printDate' style='text-align: center;'>Date: "+currentDate+"</h3>");

            //get the contents for printing
            var printContents = document.getElementById(printableArea).innerHTML;

            //remove header
            $("#printHeader").hide();
            $("#printDate").hide();

            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    </script>
</head>
<body>

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/adminHeader.php"); ?>

<h2>Analytics</h2>
<!--TABS-->
<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'Age')">Age</button>
    <button class="tablinks" onclick="openTab(event, 'District')">District</button>
    <button class="tablinks" onclick="openTab(event, 'Education')">Education</button>
    <button class="tablinks" onclick="openTab(event, 'Occupation')">Occupation</button>
    <button class="tablinks" onclick="openTab(event, 'MaritalStatus')">Marital status</button>
    <button class="tablinks" onclick="openTab(event, 'RegistrationDate')">Registration Date</button>
    <button class="tablinks" onclick="openTab(event, 'LastLoginDate')">Last Log in Date</button>
</div>

<!-- AGE -->
<div id="Age" class="tabcontent">

    <form onsubmit="return drawAgeChart();">
        <!--SEARCH INPUT-->
        <div class="wrap-input" id="Age" style="border: #999999 1px solid; margin-left: 0px; width: 27%; display: inline-block;">
            <label class="lbl" for="age">
                <span >Range</span>
            </label>
            <input class="inp" type="number" id="minAge" style="border: #cccccc solid 1px; width: 20%" min="18" max="99"  placeholder="From">
            <input class="inp" type="number" id="maxAge" style="border: #cccccc solid 1px; width: 20%" min="18"  max="99"  placeholder="To">
        </div>

        <!--SORT BY-->
        <div class="wrap-input" id="Sorting" style="border: #999999 1px solid;display: inline-block; width: 37% !important; padding-bottom: 5px;">
            <label class="lbl">
                <span>Sort By</span>
            </label>

            <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 27%;">
                <option value="" disabled >Select column</option>
                <option value="yearOfBirth" selected>Age</option>
                <option value="numOfUsers">Users</option>
            </select>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC" checked>
                <span style="font-size: initial">Ascending</span>
            </label>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 0px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC">
                <span style="font-size: initial">Descending</span>
            </label>

        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>
        <button type="button" onclick="this.parentNode.reset(); drawAgeChart();" class="btn" style="display: inline-block; margin-left: 5px;">RESET</button>
        <button id="print" onclick="printTable('agePrintableArea','Age');" class="btn" type="button" style="margin: 5px 0px 5px 0px; white-space: nowrap;"><i class="fa fa-print"></i> PRINT</button>

    </form>

    <!-- PRINTABLE AREA -->
    <div id="agePrintableArea">

        <!--TABLE-->
        <table id="ageTable" style="float: left; margin-right: 1px;"></table>

        <!--CHART -->
        <div id="ageChart" style="display: inline-block;">
            <!--Loading spinner-->
            <div class="preload"><img src="../../../images/Spinner.gif"></div>
        </div>

    </div>

</div>

<!-- DISTRICT -->
<div id="District" class="tabcontent">

    <form onsubmit="return drawDistrictChart();">

        <!--SEARCH INPUT-->
        <div class="wrap-input" id="District" style="border: #999999 1px solid; margin-left: 0px; width: 30%; display: inline-block;">
            <label class="lbl" for="autocomplete">
                <span class="fa fa-home"></span>
            </label>
            <input class="inp" id="autocomplete" type="text" name="district" minlength="2" maxlength="100" placeholder="District">
        </div>
        <!-- Autocomplete places api -->
        <?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/places.html"); ?>

        <!--SORT BY-->
        <div class="wrap-input" id="Sorting" style="border: #999999 1px solid;display: inline-block; width: 37% !important; padding-bottom: 5px;">
            <label class="lbl">
                <span>Sort By</span>
            </label>

            <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 27%;">
                <option value="" disabled >Select column</option>
                <option value="District" selected>District</option>
                <option value="numOfUsers">Users</option>
            </select>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC" checked>
                <span style="font-size: initial">Ascending</span>
            </label>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 0px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC">
                <span style="font-size: initial">Descending</span>
            </label>

        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>
        <button type="button" onclick="this.parentNode.reset(); drawDistrictChart();" class="btn" style="display: inline-block; margin-left: 5px;">RESET</button>
        <button id="print" onclick="printTable('districtPrintableArea','District');" class="btn" type="button" style="margin: 5px 0px 5px 0px; white-space: nowrap;"><i class="fa fa-print"></i> PRINT</button>

    </form>

    <div id="districtPrintableArea">
        <!--TABLE-->
        <table id="districtTable" style="float: left;"></table>

        <!--CHART -->
        <div id="districtChart" style="width: 700px; height: 400px; display: inline-block;"></div>
    </div>

</div>

<!--EDUCATION-->
<div id="Education" class="tabcontent">
    <form onsubmit="return drawEducationChart();">

        <!--SEARCH INPUT-->
        <div class="wrap-input" id="Education" style="border: #999999 1px solid; margin-left: 0px; width: 30%; display: inline-block;">
            <label class="lbl" for="education">
                <span class="fa fa-mortar-board"></span>
            </label>
            <input class="inp" id="education" type="text" name="education" minlength="2" maxlength="65" placeholder="Education">
        </div>

        <!--SORT BY-->
        <div class="wrap-input" id="Sorting" style="border: #999999 1px solid;display: inline-block; width: 37% !important; padding-bottom: 5px;">
            <label class="lbl">
                <span>Sort By</span>
            </label>

            <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 27%;">
                <option value="" disabled >Select column</option>
                <option value="Education" selected>Education</option>
                <option value="numOfUsers">Users</option>
            </select>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC" checked>
                <span style="font-size: initial">Ascending</span>
            </label>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 0px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC">
                <span style="font-size: initial">Descending</span>
            </label>

        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>
        <button type="button" onclick="this.parentNode.reset(); drawEducationChart();" class="btn" style="display: inline-block; margin-left: 5px;">RESET</button>
        <button id="print" onclick="printTable('educationPrintableArea','Education');" class="btn" type="button" style="margin: 5px 0px 5px 0px; white-space: nowrap;"><i class="fa fa-print"></i> PRINT</button>

    </form>

    <div id="educationPrintableArea">
        <!--TABLE-->
        <table id="educationTable" style="float: left;"></table>

        <!--CHART -->
        <div id="educationChart" style="width: 700px; height: 400px; display: inline-block;"></div>
    </div>

</div>

<!--OCCUPATION-->
<div id="Occupation" class="tabcontent">
    <form onsubmit="return drawOccupationChart();">

        <!--SEARCH INPUT-->
        <div class="wrap-input" id="Occupation" style="border: #999999 1px solid; margin-left: 0px; width: 30%; display: inline-block;">
            <label class="lbl" for="occupation">
                <span class="fa fa-briefcase"></span>
            </label>
            <input class="inp" id="occupation" type="text" name="occupation" minlength="2" maxlength="65" placeholder="Occupation">
        </div>

        <!--SORT BY-->
        <div class="wrap-input" id="Sorting" style="border: #999999 1px solid;display: inline-block; width: 37% !important; padding-bottom: 5px;">
            <label class="lbl">
                <span>Sort By</span>
            </label>

            <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 27%;">
                <option value="" disabled >Select column</option>
                <option value="Occupation" selected>Occupation</option>
                <option value="numOfUsers">Users</option>
            </select>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC" checked>
                <span style="font-size: initial">Ascending</span>
            </label>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 0px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC">
                <span style="font-size: initial">Descending</span>
            </label>

        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>
        <button type="button" onclick="this.parentNode.reset(); drawOccupationChart();" class="btn" style="display: inline-block; margin-left: 5px;">RESET</button>
        <button id="print" onclick="printTable('occupationPrintableArea','Occupation');" class="btn" type="button" style="margin: 5px 0px 5px 0px; white-space: nowrap;"><i class="fa fa-print"></i> PRINT</button>

    </form>

    <div id="occupationPrintableArea">
        <!--TABLE-->
        <table id="occupationTable" style="float: left;"></table>

        <!--CHART -->
        <div id="occupationChart" style="width: 700px; height: 400px; display: inline-block;"></div>
    </div>

</div>

<!--MARITAL STATUS-->
<div id="MaritalStatus" class="tabcontent">
    <form onsubmit="return drawMaritalStatusChart();">

        <!--SEARCH INPUT-->
        <div class="wrap-input" id="Marital-Status" style="border: #999999 1px solid; margin-left: 0px; width: 30%; display: inline-block;" >
            <label class="lbl" for="marital-status">
                <span class="fa fa-heart"></span>
            </label>
            <select class="inp" id="marital-status" name="marital-status" style="cursor: pointer">
                <option value="" disabled selected>Select marital status</option>
                <option value="">Any</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
            </select>
        </div>

        <!--SORT BY-->
        <div class="wrap-input" id="Sorting" style="border: #999999 1px solid;display: inline-block; width: 37% !important; padding-bottom: 5px;">
            <label class="lbl">
                <span>Sort By</span>
            </label>

            <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 27%;">
                <option value="" disabled >Select column</option>
                <option value="MaritalStatus" selected>Marital Status</option>
                <option value="numOfUsers">Users</option>
            </select>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC" checked>
                <span style="font-size: initial">Ascending</span>
            </label>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 0px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC">
                <span style="font-size: initial">Descending</span>
            </label>

        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>
        <button type="button" onclick="this.parentNode.reset(); drawMaritalStatusChart();" class="btn" style="display: inline-block; margin-left: 5px;">RESET</button>
        <button id="print" onclick="printTable('maritalPrintableArea','Marital Status');" class="btn" type="button" style="margin: 5px 0px 5px 0px; white-space: nowrap;"><i class="fa fa-print"></i> PRINT</button>

    </form>

    <div id="maritalPrintableArea">
        <!--TABLE-->
        <table id="maritalStatusTable" style="float: left;"></table>

        <!--CHART -->
        <div id="maritalStatusChart" style="width: 700px; height: 400px; display: inline-block;"></div>
    </div>

</div>

<!--REGISTRATION DATE-->
<div id="RegistrationDate" class="tabcontent">

    <form onsubmit="return drawRegistrationDateChart();">

        <!--SEARCH INPUT-->
        <!--FROM-->
        <div class="wrap-input" id="Registration-from" style="border: #999999 1px solid; padding-bottom: 5px; margin-left: 0px; width: 20%; display: inline-block;">
            <label class="lbl" for="registration-from">
                <span style="font-size: 14px;">From</span>
            </label>
            <input class="inp" id="registration-from" type="date" name="registration-from"
                   min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 60%;">
        </div>

        <!--TO-->
        <div class="wrap-input" id="Registration-to" style="border: #999999 1px solid; margin-left: 0px; width: 20%; padding-bottom: 5px; display: inline-block;">
            <label class="lbl" for="registration-to">
                <span style="font-size: 14px;">To</span>
            </label>
            <input class="inp" id="registration-to" type="date" name="registration-to"
                   min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 65%;">
        </div>

        <!--SORT BY-->
        <div class="wrap-input" id="Sorting" style="border: #999999 1px solid;margin-left: 0; display: inline-block; width: 39% !important; padding-bottom: 5px;">
            <label class="lbl">
                <span>Sort By</span>
            </label>

            <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 27%;">
                <option value="" disabled >Select column</option>
                <option value="RegistrationDate" selected>Registration date</option>
                <option value="numOfUsers">Users</option>
            </select>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC">
                <span style="font-size: initial">Ascending</span>
            </label>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 0px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC" checked>
                <span style="font-size: initial">Descending</span>
            </label>

        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>
        <button type="button" onclick="this.parentNode.reset(); drawRegistrationDateChart();" class="btn" style="display: inline-block; margin-left: 5px;">RESET</button>
        <button id="print" onclick="printTable('registrationPrintableArea','Registration Date');" class="btn" type="button" style="margin: 5px 0px 5px 0px; white-space: nowrap;"><i class="fa fa-print"></i> PRINT</button>

    </form>

    <div id="registrationPrintableArea">
        <!--TABLE-->
        <table id="registrationDateTable" style="float: left;"></table>

        <!--CHART -->
        <div id="registrationDateChart" style="width: 700px; height: 400px; display: inline-block;"></div>
    </div>

</div>

<!--LAST LOGIN DATE-->
<div id="LastLoginDate" class="tabcontent">

    <form onsubmit="return drawLastLoginDateChart();">

        <!--FROM-->
        <div class="wrap-input" id="LastLogin-from" style="border: #999999 1px solid; padding-bottom: 5px; margin-left: 0px; width: 20%; display: inline-block;">
            <label class="lbl" for="lastLogin-from">
                <span style="font-size: 14px;">From</span>
            </label>
            <input class="inp" id="lastLogin-from" type="date" name="lastLogin-from"
                   min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 60%;">
        </div>

        <!--TO-->
        <div class="wrap-input" id="LastLogin-to" style="border: #999999 1px solid; padding-bottom: 5px; margin-left: 0px; width: 20%; display: inline-block;">
            <label class="lbl" for="lastLogin-to">
                <span style="font-size: 14px;">To</span>
            </label>
            <input class="inp" id="lastLogin-to" type="date" name="lastLogin-to"
                   min="1918-01-01" max="<?php echo date("Y-m-d")?>" style="width: 65%;">
        </div>

        <!--SORT BY-->
        <div class="wrap-input" id="Sorting" style="border: #999999 1px solid;margin-left: 0; display: inline-block; width: 39% !important; padding-bottom: 5px;">
            <label class="lbl">
                <span>Sort By</span>
            </label>

            <select class="inp" id="sorting" name="sorting" style="cursor: pointer; margin-right: 2px; width: 27%;">
                <option value="" disabled >Select column</option>
                <option value="LastLogin" selected>Last login</option>
                <option value="numOfUsers">Users</option>
            </select>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 2px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="asc" value="ASC">
                <span style="font-size: initial">Ascending</span>
            </label>

            <label class="pure-material-radio" style="margin-left: 0px; margin-right: 0px; font-size: 12px;">
                <input class="inp" type="radio" name="sorting-type" id="desc" value="DESC" checked>
                <span style="font-size: initial">Descending</span>
            </label>

        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>
        <button type="button" onclick="this.parentNode.reset(); drawLastLoginDateChart();" class="btn" style="display: inline-block; margin-left: 5px;">RESET</button>
        <button id="print" onclick="printTable('lastLoginPrintableArea','Last Log in Date');" class="btn" type="button" style="margin: 5px 0px 5px 0px; white-space: nowrap;"><i class="fa fa-print"></i> PRINT</button>

    </form>

    <div id="lastLoginPrintableArea">
        <!--TABLE-->
        <table id="lastLoginDateTable" style="float: left;"></table>

        <!--CHART -->
        <div id="lastLoginDateChart" style="display: inline-block;"></div>
    </div>

</div>

<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    // Show the default tab (first one).
    tabcontent = document.getElementsByClassName("tabcontent");
    tabcontent[0].style.display = "block";

    tablinks = document.getElementsByClassName("tablinks");
    tablinks[0].className += " active";
</script>

</body>
</html>