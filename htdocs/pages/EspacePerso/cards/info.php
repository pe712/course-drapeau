<?php
if ($user->chauffeur == null)
    echo '<div id="formPerso" class="centerer-container">';
else {
?>
    <div id="espacePerso-modify-infosPerso">
        <p class="espacePerso-firstLine">Vous avez déjà complété cet onglet.</p>

        <button id="modifyPerso" class="btn btn-primary">Modifier mes informations</button>
        <br><br>
    </div>
    <div id="formPerso" class="centerer-container" style="display:none">
    <?php
}
if ($user->nom == null) {
    $promotion = date('y')%100-1;
    $nom = "";
} else {
    $promotion = $user->promotion;
    $nom = $user->nom;
}

    ?>
    <form class="ms-4" method="post" action="?page=EspacePerso">
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Eric" required value=<?= $prenom ?>>
        </div>
        <div class="mb-3">
            <label for="surname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Labaye" required value=<?= $nom ?>>
        </div>
        <div class="mb-3">
            <label for="promo" class="form-label">Promotion X</label>
            <input type="number" class="form-control" id="promo" name="promotion" placeholder="21" required value=<?= $promotion ?>>
        </div>
        <div id="espacePerso-radio-courreur">
            <label class="form-check-label" for="coureur">
                Coureur
            </label>
            <input class="form-check-input" type="radio" name="type" id="coureur" checked>
        </div>
        <div id="espacePerso-radio-chauffeur">
            <label class="form-check-label" for="chauffeur">
                Chauffeur
            </label>
            <input class="form-check-input" type="radio" name="type" id="chauffeur" value="chauffeur">
        </div>
        <div class="mb-3" id="espacePerso-num_places">
            <label for="num_places" class="form-label">Nombre de places disponibles <br><span id="espacePerso-form-desc">(4 pour une voiture de 5 par ex)</span></label>
            <input type="number" class="form-control" id="num_places" name="num_places" value="4" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
    </div>
    <button id="retourFromInfo" class="btn btn-primary" onclick="changeView('info', 'cards')">Retour</button>