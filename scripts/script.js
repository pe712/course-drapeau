/**************** ADMIN *************************/
function changeView(fromid, toid, from = "none", to = "inherit") {
    document.getElementById(fromid).style.display = from;
    document.getElementById(toid).style.display = to;
}

$(document).ready(function () {
    $("#admin-gpx-button").click(function () {
        $.post("ajax/AdminRequest.php?todo=removeGPX", function (data) {
            call_cs_popup(data, 1500);
        });
    })

    $("#admin-horaires-button").click(function () {
        $.post("ajax/AdminRequest.php?todo=calculHoraires", function (data) {
            call_cs_popup(data, 1500);
        });
    })

    $("#modifyPerso").click(function () {
        $(this).hide();
        $(".infosPerso").hide();
        $("#formPerso").show();
    });

    $("#retourFromInfo").click(function () {
        if (document.getElementById("modifyPerso")) {
            $("#modifyPerso").show();
            $(".infosPerso").show();
            $("#formPerso").hide();
        }
    });

    var bar = $("#espacePerso-progress-bar")
    bar.css("width", bar.html());
})




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

function copier(id, texte) {
    call_cs_popup(texte, 1500);
    navigator.clipboard.writeText(document.getElementById(id).textContent);
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

/**************** Pop-up *************************/
function call_cs_popup(text, time) {
    var html_content = '<div id="cs-popup-container" class="cs-popup"><div class="cs-popup-content">' + text + '</div></div>';
    document.getElementById('cs-popup-area').innerHTML = html_content;
    var popup = document.getElementById('cs-popup-container');
    popup.style.display = "block";

    window.onclick = function (event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    }
    if (time != 0) {
        setTimeout(function () {
            popup.style.display = "none";
        }, time);
    }
}

/**************** Navbar *************************/
$(document).ready(function () {
    $(".nav-container").click(function () {
        location.href = "index.php?page=" + $(this).children('.nav-content').attr("id");

    });
})