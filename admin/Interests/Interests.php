<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<script src="../includes/inputBoxShadow.js"></script> <!--Add box shadow on input fields when focus-->
<script src="../includes/tabsProperties.js"></script><!--Tabs properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/tabsStyle.css"><!--Tab style-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/indexStyle.css">

<!-- The Modal -->
<div id="myModal" class="modal" style="overflow: hidden;">

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
                        <div style="margin-bottom: 3%;">
                            <a onclick="addMore(this)" style="margin:5%; color:#0066cc; cursor: pointer;"><i class="fa fa-plus"></i> Add more</a>
                        </div>
                    </div>

                    <div id="addResponse" style="font-family: 'Roboto', sans-serif;" hidden><div style="float: left;" class="loader"></div>&nbsp;Adding interests...</div>

                    <!--FOOTER-->
                    <div class="tabsFooter">
                        <button id="cancel" class="btn-change" type="button"> CANCEL</button>
                        <button class="btn-change" type="submit"> ADD</button>
                    </div>

                </form>

            </div>

            <!--DELETE-->
            <div id="Delete" class="tabcontent">
                <p class="instruction" style="display: inline-block;">Select interest(s) to delete</p>
                <a id="search-interests" onclick="showFilters();">Search</a>
                <!--Filters field-->
                <div id="interests-filters" style="margin-bottom: 10px;" hidden>
                    <form id="interests-filters-form" onsubmit="return searchInterests(this);">

                        <div class="interests-filters-input">
                            <input id="interests-filters-name" style="width: 90%; border: none; outline: 0;" type="text" placeholder="Interest name"/>
                        </div>

                        <div class="interests-filters-input" style="margin-left: 5px;">
                            <input id="interests-filters-category" style="width: 90%; border: none; outline: 0;" type="text" placeholder="Category"/>
                        </div>

                        <button>Search</button>

                    </form>
                </div>

                <form onsubmit="return deleteInterests();">

                    <div id="showInterests" style="overflow: auto; max-height: 290px;">
                        <!--Interests will be placed here -->
                    </div>

                    <!--Display successful/error message-->
                    <div id="deleteResponse" hidden></div>

                    <!--FOOTER-->
                    <div class="tabsFooter">
                        <button onclick="modal.style.display='none'" class="btn-change" type="button"> CANCEL</button>
                        <button class="btn-change" type="submit"> DELETE</button>
                    </div>

                </form>

            </div>

            <!--EDIT-->
            <div id="Edit" class="tabcontent">
                <p class="instruction" style="display: inline-block;">Click on an interest to edit it.</p>

                <a id="search-interests" onclick="showFilters();">Search</a>
                <!--Filters field-->
                <div id="interests-filters-edit" style="margin-bottom: 10px;" hidden>
                    <form id="interests-filters-form" onsubmit="return searchInterests(this);">

                        <div class="interests-filters-input">
                            <input id="interests-filters-name" style="width: 90%; border: none; outline: 0;" type="text" placeholder="Interest name"/>
                        </div>

                        <div class="interests-filters-input" style="margin-left: 5px;">
                            <input id="interests-filters-category" style="width: 90%; border: none; outline: 0;" type="text" placeholder="Category"/>
                        </div>

                        <button>Search</button>

                    </form>
                </div>

                <form onsubmit="return updateInterests();">

                    <div id="showInterestsEdit" style="overflow: auto; max-height: 290px;">
                        <!--Interests will be placed here -->
                    </div>

                    <!--Display successful/error message-->
                    <div id="editResponse" hidden ></div>

                    <!--FOOTER-->
                    <div class="tabsFooter">
                        <button onclick="modal.style.display='none'" class="btn-change" type="button"> CANCEL</button>
                        <button class="btn-change" type="submit"> SAVE SELECTED</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>

        // Get the loader element
        var loader = document.getElementsByClassName("loader")[0];

        //Hide loader spinner
        loader.style.display ="none";

        //show filters field
        function showFilters() {
            $("#interests-filters").fadeToggle();
            $("#interests-filters-edit").fadeToggle();
            return false;
        }

        function insertInterest() {
            //Get the titles of interests.
            var interestsTitle = [];
            $("#Add #Title input").each(function () {
                interestsTitle.push($(this).val());
            });

            //Get the categories of interests.
            var interestsCategory = [];
            $("#Add #Category input").each(function () {
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
                    dataType: "json",
                    beforeSend: function() {
                        //show loading spinner
                        $("#addResponse").show();
                        loader.style.display = "block";
                        $("#Add input").parent().css("box-shadow", "none");// remove any box shadow
                    },
                    success:function(response)
                    {
                        if(response.result == "success") {
                            //Display successful message and set green shadow to all the fields.
                            $('#addResponse').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                                '<span class="fa fa-check-circle-o"> Interests have been added successfully !</span></p>').show().removeClass("errorResponse").addClass("successResponse");
                            //Update interests
                            fetchInterestsDelete();
                            fetchInterestsEdit();
                            //Disappear message
                            setTimeout(function(){
                                $('#addResponse').html('').hide();
                            }, 5000);
                        }
                        else
                        {
                            //Display the error message and set red box shadow to the respective field.
                            $('#addResponse').html('<p style="color:red; font-size:17px; margin:0;">' +
                                '<span class="fa fa-exclamation-triangle">'+response.errorMessage+'</span></p>').show().addClass("errorResponse");
                            $('#Add #'+response.field+' .inp:eq('+response.index+')').parent().css("box-shadow", "0 0 5px red");
                        }
                    }
                });
            }
            else{
                $('#addResponse').html('<p style="color:red; font-size:18px; margin:0;">' +
                    '<span class="fa fa-exclamation-triangle"> All fields are required !</span></p>').show().addClass("errorResponse");
                $("#Title").css("box-shadow", "0 0 5px red");
                $("#Content").css("box-shadow", "0 0 5px red");
            }

            return false;
        }

        //Search interests with filters
        function searchInterests(frm) {
            var interestName = $(frm).find("#interests-filters-name").val();
            var interestCategory = $(frm).find("#interests-filters-category").val();
            var formID = $(frm).parent().is("#interests-filters"); // get the id of the submitted form parent
            if (formID){
                var action = "delete"; // if the submitted form is in the delete tab
            }
            else {
                var action = "edit"; // if the submitted form is in the edit tab
            }
            $.ajax({
                type: "POST",
                url: "Interests/searchInterests.php?action="+action+"",
                data:{interestName: interestName, interestCategory: interestCategory},
                success: function (response) {
                    if ( formID )
                        $("#showInterests").html(response);
                    else
                        $("#showInterestsEdit").html(response);
                }
            });

            return false;
        }

        //Delete selected interests.
        function deleteInterests()
        {
            if (confirm('Are you sure you want to delete it?')) {

                var selectedInterests = [];
                //Get the checked checkboxes and put the corresponding interest name in a array.
                $(".deleteInterest p input:checked").each(function () {
                    selectedInterests.push($(this).parent().text());
                });
                if (selectedInterests.length < 1) {
                    alert("No interests have been selected !")
                }
                else {
                    $.ajax
                    ({
                        type: 'post',
                        url: 'http://localhost/Local%20Server/ConnectPlatform/admin/Interests/deleteInterestsAdmin.php',
                        data: {interests: selectedInterests},
                        success: function (response) {
                            if (response == "success") {
                                //Display successful message
                                $('#deleteResponse').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                                    '<span class="fa fa-check-circle-o"> Interest(s) deleted successfully !</span></p>').show().removeClass("errorResponse").addClass("successResponse");
                                //Update interests
                                fetchInterestsEdit();
                                fetchInterestsDelete();
                                //Disappear message
                                setTimeout(function(){
                                    $('#deleteResponse').html('').hide();
                                }, 5000);
                            }
                            else
                                {
                                //Display the error message.
                                $('#deleteResponse').html('<p style="color:red; font-size:17px; margin:0;">' +
                                    '<span class="fa fa-exclamation-triangle"> ' + response +' is already selected by a user. You can not delete it.</span></p>').show().addClass("errorResponse");
                            }
                        }
                    });
                }
            }

            return false;
        }

        function updateInterests(){
            var selectedInterests = [];
            var changedNames = [];
            var changedCategories = [];
            //Get the checked checkboxes
            $(".editInterest p input:checked").each(function () {
                selectedInterests.push($(this).parent().text());//Gets the old name of interest
                changedNames.push($(this).parent().parent().next().find("#title").val());//Gets the changed name of the interest.
                changedCategories.push($(this).parent().parent().next().find("#category").val());//Gets the changed category of the interest.
            });

            $.ajax({
                type:"POST",
                url:"http://localhost/Local%20Server/ConnectPlatform/admin/Interests/updateInterests.php",
                data:{
                    oldNames:selectedInterests,
                    newNames:changedNames,
                    newCategories: changedCategories,},
                success:function (response) {
                    if (response == "success") {
                        //Display successful message
                        $('#editResponse').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> ' +
                            'Interest(s) updated successfully !</span></p>').show().removeClass("errorResponse").addClass("successResponse");
                        //Update Interests
                        fetchInterestsDelete();
                        fetchInterestsEdit();
                        //Disappear message
                        setTimeout(function(){
                            $('#editResponse').html('').hide();
                        }, 5000);
                    }
                    else {
                        //Display the error message.
                        $('#editResponse').html('<p style="color:red; font-size:17px; margin:0;">' +
                            '<span class="fa fa-exclamation-triangle"> ' + response + '</span></p>').show().addClass("errorResponse");
                    }
                }
            });

            return false;
        }


        //Fetch all interests for delete.
        fetchInterestsDelete();
        function fetchInterestsDelete() {
            $.ajax({
                type: "GET",
                url: "http://localhost/Local%20Server/ConnectPlatform/admin/Interests/getInterestsAdmin.php?action=delete",
                success: function (response) {
                    $("#showInterests").html(response);
                }
            });
            return false;
        }

        //Fetch all interests for edit.
        fetchInterestsEdit();
        function fetchInterestsEdit() {
            $.ajax({
                type: "GET",
                url: "http://localhost/Local%20Server/ConnectPlatform/admin/Interests/getInterestsAdmin.php?action=edit",
                success: function (response) {
                    $("#showInterestsEdit").html(response);
                }
            });
            return false;
        }

        // Check/Uncheck ckeckbox when click on an interest
        function checkUncheck(x) {
            cb = $(x).find(':checkbox');
            if(cb.is(':checked')){
                cb.prop('checked', false);
            }
            else if(!cb.is(':checked')) {
                cb.prop('checked', true);
            }
        }

        //Show Title and Category divs to edit
        function showToEdit(x) {
            cb = $(x).find(':checkbox');
            if(cb.is(':checked')){
                $(x).next().fadeIn('slow');
            }
            else {
                $(x).next().fadeOut('fast');
            }
        }
        
        function addMore(x) {

            $("<hr style='border-color: #e6e6e6;'>").insertBefore(x);

            $("<a onclick=\"removeInterest(this)\" style=\"margin-left: 5%; color:red; cursor: pointer;\"><i class=\"fa fa-remove\"></i> Remove</a>\n").insertBefore(x);

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