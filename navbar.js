window.addEventListener("DOMContentLoaded", function () {
    let coll = document.querySelectorAll(".collapsible");
    for (let i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            let content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            }
            else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
    if (coll[0] != null) coll[0].click();
});

function openNav() {
    document.getElementById("mySidepanel").style.width = "40vh";
}
function closeNav() {
    document.getElementById("mySidepanel").style.width = "0";
}

function togglePassword() {
    var x = document.getElementById("pwd");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function toggleAllPasswords() {
    var x = document.getElementById("pwd");
    var y = document.getElementById("pwd2");
    if (x.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}