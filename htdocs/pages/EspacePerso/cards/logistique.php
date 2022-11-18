<?php
if ($user->vegetarian != null) {
?>
    <div id="espacePerso-logistique-infos">
        <p class="espacePerso-firstLine">Tu as déjà complété cet onglet.</p>

        <button id="espacePerso-modify-logistique" class="btn btn-primary">Modifier mes informations</button>
        <br><br>
    </div>
    <div id="espacePerso-form-logistique" style="display:none">
    <?php
} else {
    echo '<div id="espacePerso-form-logistique">';
}
    ?>
    <form method="post" action="?page=EspacePerso">
        <br>
        <div class="mb-3">
            Souhaites-tu manger végétarien ?
            <span>
                <label class="form-check-label" for="vege">
                    Oui
                </label>
                <input class="form-check-input" type="radio" name="vegetarian" id="vege" value="vege" checked>
            </span>
            <span>
                <label class="form-check-label" for="not_vege">
                    Non
                </label>
                <input class="form-check-input" type="radio" name="vegetarian" id="not_vege">
            </span>
        </div>
        <div class="mb-3">
            Veux tu aider à la préparation des repas ?
            <span>
                <label class="form-check-label" for="prepa">
                    Oui
                </label>
                <input class="form-check-input" type="radio" name="prepa_repas" id="prepa" value="prepa" checked>
            </span>
            <span>
                <label class="form-check-label" for="not_prepa">
                    Non
                </label>
                <input class="form-check-input" type="radio" name="prepa_repas" id="not_prepa">
            </span>
        </div>
        <div class="mb-3">
            As-tu des allergies ?
            <span id="espacePerso-allergie">
                <label class="form-check-label" for="allergie">
                    Oui
                </label>
                <input class="form-check-input" type="radio" name="has-allergie" id="allergie">
            </span>
            <span id="espacePerso-not_allergie">
                <label class="form-check-label" for="not_allergie">
                    Non
                </label>
                <input class="form-check-input" type="radio" name="has-allergie" id="not_allergie" checked>
            </span>
        </div>
        <div class="mb-3" id="espacePerso-input-allergie">
            <label for="espacePerso-alergie" class="form-label">Lesquelles?</label>
            <input type="text" class="form-control" id="espacePerso-alergie" name="allergie">
        </div>
        <div class="mb-3">
            As-tu un permis B ?
            <span id="espacePerso-permis">
                <label class="form-check-label" for="permis">
                    Oui
                </label>
                <input class="form-check-input" type="radio" name="permis" id="permis">
            </span>
            <span id="espacePerso-not_permis">
                <label class="form-check-label" for="not_permis">
                    Non
                </label>
                <input class="form-check-input" type="radio" name="permis" id="not_permis" checked>
            </span>
        </div>
        <div class="mb-3 espacePerso-input-permis">
            Es-tu jeune conducteur ?
            <span>
                <label class="form-check-label" for="jeune_conducteur">
                    Oui
                </label>
                <input class="form-check-input" type="radio" name="jeune_conducteur" id="jeune_conducteur">
            </span>
            <span>
                <label class="form-check-label" for="not_jeune_conducteur">
                    Non
                </label>
                <input class="form-check-input" type="radio" name="jeune_conducteur" id="not_jeune_conducteur" checked>
            </span>
        </div>
        <div class="mb-3 espacePerso-input-permis">
            Avec boite manuelle ?
            <span>
                <label class="form-check-label" for="boite_manuelle">
                    Oui
                </label>
                <input class="form-check-input" type="radio" name="boite_manuelle" id="boite_manuelle">
            </span>
            <span>
                <label class="form-check-label" for="not_boite_manuelle">
                    Non
                </label>
                <input class="form-check-input" type="radio" name="boite_manuelle" id="not_boite_manuelle" checked>
            </span>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre mes réponses</button>
    </form>
    </div>
    <br>
    <button id="espacePerso-retourFromLogistique" class="btn btn-primary" onclick="changeView('logistique', 'cards')">Retour</button>