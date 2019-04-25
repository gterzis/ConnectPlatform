<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {margin:0;font-family:Arial}

        .topnav {
            overflow: hidden;
            background-color: #0073b1;
        }

        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            text-decoration: none;
            font-size: 17px;
        }

        /*.active {*/
            /*background-color: #4CAF50;*/
            /*color: white;*/
        /*}*/

        .title2{
            margin: 10px 45px;
            font-family: "Maiandra GD";
            font-size: 45px;
            color: ivory;
            display: inline-block;
        }

        .topnav-menu p{
            margin-top: 5px;
            font-size: 14px;
            font-family: Verdana, Helvetica, Arial;
        }

        .topnav-menu a{
            margin-right: 25px;
        }

        .topnav-menu .fa{
            font-size: 25px;
            text-align: center;
            cursor: pointer;
            color: #c7d1d8;
            transition: 0.3s;
            transition-timing-function: ease-in-out;
        }

        .topnav-menu .fa:hover{
            color: ivory;

        }

        .topnav .icon {
            display: none;
        }

        .topnav-menu{
            float: right;
            margin: 15px 70px 0 0;
        }

        .dropdown {
            float: left;
            overflow: hidden;
            margin-right: 25px;
        }

        .dropdown .dropbtn {
            font-size: 17px;
            border: none;
            outline: none;
            color: white;
            padding: 0px 0px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            margin: 0;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
            color: black;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child), .dropdown .dropbtn {
                display: none;
            }
            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
            .topnav.responsive .dropdown {float: none;}
            .topnav.responsive .dropdown-content {position: relative;}
            .topnav.responsive .dropdown .dropbtn {
                display: block;
                width: 100%;
                text-align: left;
            }
        }
    </style>
</head>
<body>

<div class="topnav" id="myTopnav">
    <a href="http://localhost/Local%20Server/ConnectPlatform/index.php"><p class="title2">Get in Touch</p></a>
    <div class="topnav-menu">
        <a href="http://localhost/Local%20Server/ConnectPlatform/admin/admin.php"><span class="fa fa-home"><p>Home</p></span></a>
<!--        <a href="../../ConnectPlatform/Logout.php"><span class="fa fa-sign-out"><p>Log out</p></span></a>-->
        <div class="dropdown">
            <button class="dropbtn">
                <span class="fa fa-line-chart"><p>Reports</p></span>
            </button>
            <div class="dropdown-content">
                <a href="http://localhost/Local%20Server/ConnectPlatform/admin/Reports/UsersReports.php">Users</a>
                <a href="http://localhost/Local%20Server/ConnectPlatform/admin/Reports/Interests/InterestsReports.php">Interests</a>
                <a href="http://localhost/Local%20Server/ConnectPlatform/admin/Reports/Analytics/Analytics.php">Analytics</a>
            </div>
        </div>
        <a href="http://localhost/Local%20Server/ConnectPlatform/Logout.php"><span class="fa fa-sign-out"><p>Log out</p></span></a>
        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>

</body>
</html>
