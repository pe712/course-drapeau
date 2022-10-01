/**************** ADMIN *************************/
function changeView(fromid, toid) {
    document.getElementById(toid).style.display = "inherit";
    document.getElementById(fromid).style.display = "none";
}


/**************** Tree View *************************/
$(document).ready(function () {
    var toggler = document.getElementsByClassName("caret");
    var i;
    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function () {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
})

/**************** Contact *************************/

function copiermail() {
    navigator.clipboard.writeText(document.getElementById("mail").textContent);

}

/**************** Inscription *************************/
function updateInscription() {

    var mdp = document.getElementById("pwd1").value;
    var score = 0;
    if (mdp.length < 8) {
        score += mdp.length;
        unvalidate("8c");
    }
    else {
        score += 8;
        validate("8c");
    }
    if (mdp.match(/[A-Z]/g)) {
        score += 2;
        validate("M");
    }
    else
        unvalidate("M");
    if (mdp.match(/[a-z]/g)) {
        score += 2;
        validate("m");
    }
    else
        unvalidate("m");
    if (mdp.match(/[^a-zA-Z\d]/g)) {
        score += 2;
        validate("spec");
    }
    else
        unvalidate("spec");
    if (mdp.match(/[0-9]/g)) {
        score += 2;
        validate("c");
    }
    else
        unvalidate("c");
    console.log(mdp.length);
    var percent = score / 16 * 100;
    var pg = document.getElementById("inscription-progress-bar");
    pg.style.width = percent + "%";
    pg.innerHTML = Math.round(percent) + "%";
}

function validate(id) {
    var st = document.getElementById(id).style;
    st.color = "rgb(7, 88, 7)";
    st.fontWeight = "bold";
}

function unvalidate(id) {
    var st = document.getElementById(id).style;
    st.color = "inherit";
    st.fontWeight = "inherit";
}