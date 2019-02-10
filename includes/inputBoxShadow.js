//Add box shadow on input fields when focus, remove when blur
$("input, select").focus(function () {
    $(this).parent().css("box-shadow", "0 0 5px #66b3ff");
});

$("input, select").blur(function () {
    $(this).parent().css("box-shadow", "none");
});

//Do not apply on
$("input[type=checkbox], input[type=file]").focus(function () {
    $(this).parent().css("box-shadow", "none");
});


