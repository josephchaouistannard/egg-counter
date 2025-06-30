function openForm(evt, formName) {
    // Declare all variables
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
    document.getElementById(formName).style.display = "block";
    evt.currentTarget.className += " active";
}

function validateUsername(field) {
    var username = field.value;
    if (username == "") {
        alert("Please enter a username")
        field.focus();
        return false;
    }
    if (!/^[a-zA-Z0-9]+$/.test(username)) {
        alert('Usernames can only contain letters and numbers');
        field.focus();
        return false;
    }
    return true;
}

function validatePassword(field) {
    var password = field.value;
    if (password == "") {
        alert("Please enter your password");
        field.focus();
        return false;
    }
    return true;
}

function incrementCounter(operation) {
    const recorderCountElement = document.getElementById('recorderCount');
    const quantityInputElement = document.getElementById('quantityInput'); // Get the hidden input

    let currentCount = parseInt(recorderCountElement.textContent);

    if (operation === '+') {
        currentCount++;
    } else if (operation === '-' && currentCount > 0) {
        currentCount--;
    }

    recorderCountElement.textContent = currentCount;
    quantityInputElement.value = currentCount; // Update the hidden input value
}
