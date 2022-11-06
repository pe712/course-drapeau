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
            call_cs_popup(data, 3000);
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

    $(".admin-modif").click(function () {
        var id = $(this).attr("id");
        var item = id.split("_");
        $("#admin-modify h4").html("Modifier l'item " + item[2] + " de la section " + item[1] + " de la page " + item[0])
        $("#admin-textarea").val(
            $("#content_" + id).text()
        );
        $("#admin-modify").show();
        document.getElementById("admin-textarea").scrollIntoView()
        $("#admin-modify-infos").text(id);
    });

    $("#admin-modify-button").click(function () {
        postdata = $("#admin-modify-infos").text().split("_");
        $.post("ajax/AdminRequest.php?todo=contentModif", {
            contenu: document.getElementById("admin-textarea").value,
            page: postdata[0],
            section: postdata[1],
            item: postdata[2],
        }, function (data) {
            call_cs_popup(data, 3000);
        });
    });

    $(".admin-onglet-button").click(function () {
        $(".admin-onglet").hide();
        $("#" + $(this).attr("id") + "-onglet").show();

    });

    $(".admin-section").click(function () {
        var page = $(this).attr("id").split("_")[0]
        $("#admin-" + page).prop("checked", true);
    });

    $(".admin-page-button").click(function () {
        var page = $(this).attr("id").split("-")[1]
        $(".admin-" + page + "-section span").addClass("caret-down");
        $(".admin-" + page + "-section ul").addClass("active");
    });

    $(".admin-button-add").click(function () {
        var id = $(this).attr("id").split("-");
        var action = id[2];
        $("#admin-add").show();
        $("#admin-add h4").show();
        if (action == "section") {
            $("#admin-submit-page").val(id[3]);
            $(".admin-section-desc").show();
            $(".admin-section-num").show();
            $(".admin-item-content").hide();
            $(".admin-item-num").hide();
            $("#admin-add h4").html("Ajouter une section à la page " + id[3]);
        } else {
            $("#admin-submit-page").val(id[3]);
            $("#admin-section-num").val(id[4]);
            $(".admin-item-content").show();
            $(".admin-item-num").show();
            $(".admin-section-desc").hide();
            $(".admin-section-num").hide();
            $("#admin-add h4").html("Ajouter un item à la section " + id[4] + " de la page " + id[3]);
        }
        document.getElementById("admin-add").scrollIntoView();
    });




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
function call_cs_popup(text, time = 1000000) {
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
        location.href = "?page=" + $(this).children('.nav-content').attr("id");

    });
})


/**************** Espace Perso *************************/
var setHref = function (event) {
    event.preventDefault()

    var path = $("#espacePerso-download").children().text()
    console.log(path)

    $.post("ajax/AdminRequest.php?todo=download", {
        path: path,
    }, function (data) {
        $("#espacePerso-download").attr("href", data)
    });
    $(event.currentTarget).data('isConfirming', true);
    event.currentTarget.click();
};

$(document).ready(function () {
    $("#espacePerso-lienPaiement").click(function () {
        $("#espacePerso-messagePaiement").show();
    });

    $("#espacePerso-modifyCertif").click(function (e) {
        e.preventDefault();
        $("#espacePerso-certificatUpload").show();
        $("#espacePerso-messageCertif").hide();
    });

    /* $("#espacePerso-download").delegate("[download]", "click", setHref); */
    $("#espacePerso-download").click(function (event) {
        if ($(event.currentTarget).data('isOk')) return;
        event.preventDefault()

        var path = $("#espacePerso-download").children().text()
        console.log(path)

        $.post("ajax/AdminRequest.php?todo=download", {
            path: path,
        }, function (data) {
            console.log(data)
            $("#espacePerso-download").attr("href", data)
            $(event.currentTarget).data('isOk', true);
            event.currentTarget.click();
        });
    });


    $("#espacePerso-retourFromCertif").click(function () {
        if (document.getElementById("espacePerso-messageCertif")) {
            $("#espacePerso-certificatUpload").hide();
            $("#espacePerso-messageCertif").show();
        }
    });

    $("#espacePerso-radio-chauffeur").click(function () {
        $("#espacePerso-num_places").show()
    });

    $("#espacePerso-radio-courreur").click(function () {
        $("#espacePerso-num_places").hide()
    });

    $("#espacePerso-allergie").click(function () {
        $("#espacePerso-input-allergie").show()
    });

    $("#espacePerso-not_allergie").click(function () {
        $("#espacePerso-input-allergie").hide()
    });
});
