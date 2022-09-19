function NewPass() {
    var x = document.getElementById("new_pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function cPass() {
    var x = document.getElementById("retype_pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function oldPass() {
    var x = document.getElementById("old_pass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}