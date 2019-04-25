<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        // on load draw charts
        google.charts.setOnLoadCallback(drawAgeChart);
        google.charts.setOnLoadCallback(drawDistrictChart);
        google.charts.setOnLoadCallback(drawEducationChart);
        google.charts.setOnLoadCallback(drawOccupationChart);
        google.charts.setOnLoadCallback(drawMaritalStatusChart);

        //AGE table
        function fetchAge() {
            var minAge = $("#minAge").val();
            var maxAge = $("#maxAge").val();

            $.ajax({
                method: "POST",
                url: "getAge.php?data=table",
                data:{
                    minAge: minAge,
                    maxAge: maxAge
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

            $.ajax({
                method: "POST",
                url: "getDistrict.php?data=table",
                data:{
                    district:district
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

            $.ajax({
                method: "POST",
                url: "getEducation.php?data=table",
                data:{
                    education:education
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

            $.ajax({
                method: "POST",
                url: "getOccupation.php?data=table",
                data:{
                    occupation:occupation
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
            $.ajax({
                method: "POST",
                url: "getMaritalStatus.php?data=table",
                data:{
                    maritalStatus: maritalStatus
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
            $.ajax({
                method: "POST",
                url: "getRegistrationDate.php?data=table",
                data:{
                    registrationDateFrom: registrationDateFrom,
                    registrationDateTo: registrationDateTo
                },
                success: function (response) {
                    $("#registrationDateTable").html(response);
                }
            });

            return false;
        }

        //Draw age chart
        function drawAgeChart() {
            fetchAge();//show table
            var minAge = $("#minAge").val();
            var maxAge = $("#maxAge").val();
            $.ajax({
                method: "POST",
                url: "getAge.php?data=chart",
                dataType: "JSON",
                data: {
                    minAge: minAge,
                    maxAge: maxAge
                },
                success: function (data) {

                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('number', 'Age');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function (i, jsonData) {
                        var age = jsonData.age;
                        var users = jsonData.users;
                        Data.addRows([[age, Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Age"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: {groupWidth: "100%"},
                        width: 900
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('ageChart'));
                    chart.draw(Data, Options);
                }
            });

            return false;
        }

        //Draw District Chart
        function drawDistrictChart(){
            fetchDistrict();// show table
            var district = $("input[name=district]").val();
            $.ajax({
                method: "POST",
                url: "getDistrict.php?data=chart",
                dataType:"JSON",
                data:{
                    district:district
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
                        width: 900
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('districtChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Education Chart
        function drawEducationChart(){
            fetchEducation();// show table
            var education = $("input[name=education]").val();
            $.ajax({
                method: "POST",
                url: "getEducation.php?data=chart",
                dataType:"JSON",
                data:{
                    education:education
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
                        width: 900
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('educationChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Occupation Chart
        function drawOccupationChart(){
            fetchOccupation();// show table
            var occupation = $("input[name=occupation]").val();
            $.ajax({
                method: "POST",
                url: "getOccupation.php?data=chart",
                dataType:"JSON",
                data:{
                    occupation:occupation
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
                        width: 900
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('occupationChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

        //Draw Marital status Chart
        function drawMaritalStatusChart(){
            fetchMaritalStatus();// show table
            var maritalStatus= $("#marital-status").val();
            $.ajax({
                method: "POST",
                url: "getMaritalStatus.php?data=chart",
                dataType:"JSON",
                data:{
                    maritalStatus: maritalStatus
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
                        width: 900
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('maritalStatusChart'));
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
            $.ajax({
                method: "POST",
                url: "getRegistrationDate.php?data=chart",
                dataType:"JSON",
                data:{
                    registrationDateFrom:registrationDateFrom,
                    registrationDateTo:registrationDateTo
                },
                success: function (data) {
                    var jsonData = data;
                    var Data = new google.visualization.DataTable();
                    Data.addColumn('string', 'Registration Date');
                    Data.addColumn('number', 'Users');
                    $.each(jsonData, function(  i, jsonData){
                        var registrationDate = jsonData.registrationDate;
                        var users = jsonData.users;
                        Data.addRows([[registrationDate, Number(users)]]);
                    });

                    var Options = {
                        hAxis: {
                            title: "Registration date"
                        },
                        vAxis: {
                            title: 'Users'
                        },
                        bar: { groupWidth: "100%" },
                        width: 900
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('registrationDateChart'));
                    chart.draw(Data, Options);
                }
            });
            return false;
        }

    </script>
</head>
<body>

<!--HEADER-->
<?php   echo file_get_contents("http://localhost/Local%20Server/ConnectPlatform/includes/adminHeader.php"); ?>

<h2>Analytics</h2>

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
        <div class="wrap-input" id="Age" style="border: #999999 1px solid; margin-left: 0px; width: 30%; display: inline-block;">
            <label class="lbl" for="age">
                <span >Range</span>
            </label>
            <input class="inp" type="number" id="minAge" style="border: #cccccc solid 1px; width: 20%" min="18" max="99"  placeholder="From">
            <input class="inp" type="number" id="maxAge" style="border: #cccccc solid 1px; width: 20%" min="18"  max="99"  placeholder="To">
        </div>

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>

    </form>

    <!--TABLE-->
    <table id="ageTable" style="float: left;"></table>

    <!--CHART -->
    <div id="ageChart" style="width: 700px; height: 400px; display: inline-block;"></div>

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

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>

    </form>

    <!--TABLE-->
    <table id="districtTable" style="float: left;"></table>

    <!--CHART -->
    <div id="districtChart" style="width: 700px; height: 400px; display: inline-block;"></div>

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

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>

    </form>

    <!--TABLE-->
    <table id="educationTable" style="float: left;"></table>

    <!--CHART -->
    <div id="educationChart" style="width: 700px; height: 400px; display: inline-block;"></div>

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

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>

    </form>

    <!--TABLE-->
    <table id="occupationTable" style="float: left;"></table>

    <!--CHART -->
    <div id="occupationChart" style="width: 700px; height: 400px; display: inline-block;"></div>
</div>

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


        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>

    </form>

    <!--TABLE-->
    <table id="maritalStatusTable" style="float: left;"></table>

    <!--CHART -->
    <div id="maritalStatusChart" style="width: 700px; height: 400px; display: inline-block;"></div>
</div>

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

        <!--BUTTON-->
        <button class="btn" type="submit" style="display: inline-block; margin-left: 5px;">SEARCH</button>

    </form>

    <!--TABLE-->
    <table id="registrationDateTable" style="float: left;"></table>

    <!--CHART -->
    <div id="registrationDateChart" style="width: 700px; height: 400px; display: inline-block;"></div>
</div>

<div id="LastLoginDate" class="tabcontent">
    <h3>Last Log in</h3>
    <p>Tokyo is the capital of Japan.</p>
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