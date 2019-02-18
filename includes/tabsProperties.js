function openTab(evt, operation) {

    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(operation).style.display = "block";
    evt.currentTarget.className += " active";

}

// Show the default tab (first one).
tabcontent = document.getElementsByClassName("tabcontent");
tabcontent[0].style.display = "block";

tablinks = document.getElementsByClassName("tablinks");
tablinks[0].className += " active";