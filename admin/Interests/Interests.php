<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<script src="../includes/inputBoxShadow.js"></script> <!--Add box shadow on input fields when focus-->
<script src="../includes/tabsProperties.js"></script><!--Tabs properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/tabsStyle.css"><!--Tab style-->

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class="modalTitle">Interests</h2>
        </div>

        <!--BODY-->
        <div class="modal-body">

            <!--TAB BUTTONS-->
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Add')">Add</button>
                <button class="tablinks" onclick="openTab(event, 'Delete')">Delete</button>
                <button class="tablinks" onclick="openTab(event, 'Edit')">Edit</button>
            </div>

            <!--ADD-->
            <div id="Add" class="tabcontent">

                <h3 class="tabTitle">Add</h3>
                <p class="instruction">Fill in the fields below to add a new interest</p>

                <form onsubmit="return insertInterest();">

                    <div style="overflow: auto; max-height: 300px;">
                        <!--INTEREST TITLE-->
                        <div class="wrap-input wrap-login" id="Title" style="border: 2px solid #cccccc; width: 85%; margin-left: 3%;">
                            <label class="lbl" for="title">
                                <span>Title</span>
                            </label>
                            <input class="inp" style="margin: 10px; padding: 0px;" id="title" type="text" name="title" maxlength="35" placeholder="Enter a title..." required/>
                        </div>

                        <!--CATEGORY-->
                        <div class="wrap-input wrap-login" id="Category" style="border: 2px solid #cccccc; width: 85%; margin-left: 3%;">
                            <label class="lbl" for="category" style="font-size: 14px;">
                                <span>Category</span>
                            </label>
                            <input class="inp" id="category" style="margin: 10px; padding: 0px; width: 68%;" type="text" name="title" maxlength="35" placeholder="Enter a title..." required/>
                        </div>

                        <a onclick="addMore(this)" style="margin:5%; color:rgba(0,0,0,.8); cursor: pointer;"><i class="fa fa-plus"></i> Add more</a>

                        <div id="response"></div>

                    </div>

                    <!--FOOTER-->
                    <div class="tabsFooter">
                        <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                        <button class="btn-change" type="submit"> ADD</button>
                    </div>

                </form>

            </div>

            <!--DELETE-->
            <div id="Delete" class="tabcontent">
                <h3 class="tabTitle">Delete</h3>
                <p class="instruction">Select announcement(s) to delete</p>

                <form onsubmit="return deleteAnnounc();">

                    <div id="showAnnounc">
                        <!--Announcements will be placed here -->
                    </div>

                    <!--Display successful/error message-->
                    <div id="deleteResponse" style="margin-left: 4%;"></div>

                    <!--FOOTER-->
                    <div class="tabsFooter">
                        <button onclick="modal.style.display='none'" class="btn-change" type="button"> CANCEL</button>
                        <button class="btn-change" type="submit"> DELETE</button>
                    </div>

                </form>

            </div>

            <!--EDIT-->
            <div id="Edit" class="tabcontent">
                <h3>Edit</h3>
                <p>Tokyo is the capital of Japan.</p>

                <!--FOOTER-->
                <div class="tabsFooter">
                    <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                    <button class="btn-change" type="submit"> CHANGE</button>
                </div>

            </div>

        </div>

    </div>

    <script>

        function insertInterest() {
            //Get the titles of interests.
            var interestsTitle = [];
            $("#Title input").each(function () {
                interestsTitle.push($(this).val());
            });

            //Get the categories of interests.
            var interestsCategory = [];
            $("#Category input").each(function () {
                interestsCategory.push($(this).val());
            });

            if (interestsTitle != '' && interestsCategory != ''){
                $.ajax
                ({
                    type:'post', url:'http://localhost/Local%20Server/ConnectPlatform/admin/Interests/insertInterestAdmin.php',
                    data:{
                        titles:interestsTitle,
                        categories:interestsCategory,
                    },
                    success:function(response)
                    {
                        if(response == "success") {
                            //Display successful message and set green shadow to all the fields.
                            $('#response').html('<p style="color:#00b300; font-size:18px; margin-top: 2%;">' +
                                '<span class="fa fa-check-circle-o"> Interests have been added successfully !</span></p>');
                        }
                        else
                        {
                            //Display the error message and set red box shadow to the respective field.
                            $('#response').html('<p style="color:red; font-size:17px; margin:2%;">' +
                                '<span class="fa fa-exclamation-triangle">'+response+'</span></p>');
                            $("#"+response[1]+"").css("box-shadow", "0 0 5px red");
                        }
                    }
                });
            }
            else{
                $('#response').html('<p style="color:red; font-size:18px; margin:0;">' +
                    '<span class="fa fa-exclamation-triangle"> All fields are required !</span></p>');
                $("#Title").css("box-shadow", "0 0 5px red");
                $("#Content").css("box-shadow", "0 0 5px red");
            }

            return false;
        }

        //Delete selected announcements.
        function deleteAnnounc()
        {
            if (confirm('Are you sure you want to delete it?')) {

                var selectedAnnouns = [];
                //Get the checked checkboxes and put the corresponding announc title in a array.
                $(".deleteAnnoun p input:checked").each(function () {
                    selectedAnnouns.push($(this).parent().text());
                });
                if (selectedAnnouns.length < 1) {
                    alert("No announcements have been selected !")
                }
                else {
                    $.ajax
                    ({
                        type: 'post',
                        url: 'http://localhost/Local%20Server/ConnectPlatform/admin/BulletinBoard/deleteAnnouncement.php',
                        data: {announs: selectedAnnouns},
                        success: function (response) {
                            if (response == "success") {
                                //Display successful message and set green shadow to all the fields.
                                $('#deleteResponse').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                                    '<span class="fa fa-check-circle-o"> Announcement(s) deleted successfully !</span></p>');
                                //Remove selected announcement
                                $(".deleteAnnoun p input:checked").each(function () {
                                    $(this).parent().parent().remove();
                                });
                            }
                            else {
                                //Display the error message.
                                $('#deleteResponse').html('<p style="color:red; font-size:17px; margin:0;">' +
                                    '<span class="fa fa-exclamation-triangle"> ' + response + '</span></p>');
                            }
                        }
                    });
                }
            }

            return false;
        }


        //Fetch all admins.
        var announs = [];
        $.ajax({
            type: "GET",
            url: "http://localhost/Local%20Server/ConnectPlatform/admin/BulletinBoard/getAnnouncements.php",
            dataType: "json",
            success: function(response){
                announs = response;
                announs.forEach(myFunction);
                function myFunction(value) {
                    $("#showAnnounc").append('<div class="deleteAnnoun" onclick="checkUncheck(this)"><p><input type="checkbox">'+value+'</p></div>');
                }
            }
        });

        // Check/Uncheck ckeckbox when click on an admin
        function checkUncheck(x) {
            cb = $(x).find(':checkbox');
            if(cb.is(':checked')){
                cb.prop('checked', false);
            }
            else if(!cb.is(':checked')) {
                cb.prop('checked', true);
            }
        }
        
        function addMore(x) {

            $("<hr style='border-color: #e6e6e6;'>").insertBefore(x);

            $("<a onclick=\"removeInterest(this)\" style=\"margin-left: 5%; color:rgba(0,0,0,.8); cursor: pointer;\"><i class=\"fa fa-remove\"></i> Remove</a>\n").insertBefore(x);

            $("<div class=\"wrap-input wrap-login\" id=\"Title\" style=\"border: 2px solid #cccccc; width: 85%; margin-left: 3%;\">\n" +
                "                        <label class=\"lbl\" for=\"title\">\n" +
                "                            <span>Title</span>\n" +
                "                        </label>\n" +
                "                        <input class=\"inp\" style=\"margin: 10px; padding: 0px;\" id=\"title\" type=\"text\" name=\"title\" maxlength=\"35\" placeholder=\"Enter a title...\" required/>\n" +
                "                    </div>").insertBefore(x);

            $("<div class=\"wrap-input wrap-login\" id=\"Category\" style=\"border: 2px solid #cccccc; width: 85%; margin-left: 3%;\">\n" +
                "                        <label class=\"lbl\" for=\"category\" style=\"font-size: 14px;\">\n" +
                "                            <span>Category</span>\n" +
                "                        </label>\n" +
                "                        <input class=\"inp\" id=\"category\" style=\"margin: 10px; padding: 0px; width: 68%;\" type=\"text\" name=\"title\" maxlength=\"35\" placeholder=\"Enter a title...\" required/>\n" +
                "                    </div>").insertBefore(x);

        }

        function removeInterest(x) {
            $(x).prev().remove(); //remove <hr>
            $(x).nextAll().eq(0).remove(); //remove title
            $(x).nextAll().eq(0).remove(); //remove category
            $(x).remove(); //remove itself
        }

    </script>