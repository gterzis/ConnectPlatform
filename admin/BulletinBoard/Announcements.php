<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../includes/modalProperties.js"></script><!--Modal properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/modalStyle.css"><!--Modal style-->
<script src="../includes/inputBoxShadow.js"></script> <!--Add box shadow on input fields when focus-->
<script src="../includes/tabsProperties.js"></script><!--Tabs properties-->
<link rel="stylesheet" href="http://localhost/Local%20Server/ConnectPlatform/includes/tabsStyle.css"><!--Tab style-->

<!-- The Modal -->
<div id="myModal" class="modal" style="padding-top: 70px;">

    <!-- Modal content -->
    <div class="modal-content">

        <!--HEADER-->
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class="modalTitle">Announcements</h2>
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
                <p class="instruction">Fill in the fields below to add a new announcement</p>

                <form onsubmit="return insertAnnouncement();">
                    <!--ANNOUNCEMENT TITLE-->
                    <div class="wrap-input wrap-login" id="Title" style="border: 2px solid #cccccc; width: 85%; margin-left: 3%;">
                        <label class="lbl" for="title">
                            <span>Title</span>
                        </label>
                        <input class="inp" id="title" type="text" name="title" maxlength="35" placeholder="Enter a title..." required/>

                    </div>
                    <!--CONTENT-->
                    <div class="wrap-input wrap-login" id="Content" style="border: 2px solid #cccccc; width: 85%; margin-left: 3%;">
                        <label class="lbl" for="content"></label>
                        <textarea class="inp" style="width: 80%;" id="content" rows="6" cols="60" name="content" placeholder="Enter the content of the announcement" required ></textarea>
                    </div>

                    <div id="response"></div>

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
                <h3 class="tabTitle">Edit</h3>
                <p class="instruction">Click on announcement to edit it.</p>

                <div id="showAnnouncEdit">
                    <!--Announcements will be placed here -->
                </div>

                <!--FOOTER-->
                <div class="tabsFooter">
                    <button id="cancel" onclick="modal.style.display='none'" class="btn-change" type="button"> CANCEL</button>
                    <button class="btn-change" type="submit"> CHANGE</button>
                </div>

            </div>

    </div>

</div>

<script>
    function insertAnnouncement() {
        var Title=$("#title").val();
        var Content=$("#content").val();
        if (Title != '' && Content != ''){
            $.ajax
            ({
                type:'post', url:'http://localhost/Local%20Server/ConnectPlatform/admin/BulletinBoard/insertAnnouncement.php',
                data:{
                    title:Title,
                    content:Content,
                },
                dataType:"json",
                success:function(response)
                {
                    if(response == "success") {
                        //Display successful message and set green shadow to all the fields.
                        $('#response').html('<p style="color:#00b300; font-size:18px; margin:0;">' +
                            '<span class="fa fa-check-circle-o"> Announcement has been added successfully !</span></p>');
                        $("#Title, #Content").css("box-shadow", "0 0 5px green");
                        $("#showAnnounc").append('<div class="deleteAnnoun" onclick="checkUncheck(this)"><p><input type="checkbox">'+Title+'</p></div>');
                        //Update bulletin board
                        fetchBulletinBoard();
                        fetchAnnounsDelete();
                    }
                    else
                    {
                        //Display the error message and set red box shadow to the respective field.
                        $('#response').html('<p style="color:red; font-size:17px; margin:0;">' +
                            '<span class="fa fa-exclamation-triangle">'+response[0]+'</span></p>');
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
                                '<span class="fa fa-check-circle-o"> Announcement(s) deleted successfully !</span></p>').show().addClass("successResponse");
                            //Update bulletin board.
                            fetchBulletinBoard();
                            fetchAnnounsDelete();
                            //Disappear message
                            setTimeout(function(){
                                $('#deleteResponse').html('').hide();
                            }, 5000);
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


    //Fetch bulletin board.
    fetchAnnounsDelete();
    function fetchAnnounsDelete() {
        var announs = [];
        $.ajax({
            type: "GET",
            url: "http://localhost/Local%20Server/ConnectPlatform/admin/BulletinBoard/getAnnouncements.php",
            dataType: "json",
            success: function(response){
                $("#showAnnounc").html('');
                announs = response;
                announs.forEach(myFunction);
                function myFunction(value) {
                    $("#showAnnounc").append('<div class="deleteAnnoun" onclick="checkUncheck(this)">' +
                        '<p><input type="checkbox">'+value+'</p></div>');
                    $("#showAnnouncEdit").append('<div class="editAnnoun" onclick="checkUncheck(this)">' +
                        '<p><input type="checkbox">'+value+'</p></div>');
                }
            }
        });
    }

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

</script>