<?php
if (array_key_exists("firstname", $_POST)) {
    Users::updateInfos();
}

if (array_key_exists("vegetarian", $_POST)) {
    Users::updateAlimentation();
}

if (array_key_exists("name", $_SESSION))
    $prenom = " " . $_SESSION["name"];
else
    $prenom = "";

$user = Users::getUserPersonnalData();

/**************** variables du dossier d'upload *************************/
if ($user->nom != null) {
    //on ne veut pas donner directement l'id
    $dossier = "pages/EspacePerso/upload/";
    $name = "certificat_" . $user->prenom . "_" . $user->nom . ".pdf";

    if (!is_dir($dossier))
        mkdir($dossier);

    if (isset($_FILES['certificat'])) {
        Users::uploadCertificat($dossier, $name);
        $user = Users::getUserPersonnalData();
    }
}

/**************** Message d'accueil *************************/
$x = $user->avancement();
$val = round($x * 100) . "%";
if ($x == 1)
    $texte = "Bravo" . $prenom . ", tu as complété tout ton espace personnel.";

else
    $texte = "Bienvenue" . $prenom . ", tu en est à $val du remplissage de ton espace personnel.";


?>
<div class="espacePersoMainContainer">
    <p class="progression"><?= $texte ?></p>

    <div class="progress">
        <div id="espacePerso-progress-bar" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"><?= $val ?></div>
    </div>

    <div id="cards">
        <?php
        $lines = array(
            array(
                "Mes informations personnelles" => "info",
                "Mon certificat médical" => "certif",
                "Paiement de la course" => "payement"
            ),
            array(
                "Sondage alimentation" => "restoration",
                "Liste d'affaires à emmener" => "affaires",
                "Hébergement" => "hebergement",
            )
        );
        foreach ($lines as $line) {
            echo '<div class="espacePersoRowContainer">';
            foreach ($line as $key => $value) {
        ?>
                <div class="card">
                    <div class="card-body">
                        <h2>
                            <a href=# class="stretched-link" onclick="changeView('cards', '<?= $value ?>')"><?= $key ?></a>
                        </h2>
                    </div>
                </div>
        <?php
            }
            echo "</div>";
        }
        ?>
    </div>
</div>

<div>
    <div class="onglet" id="info">
        <?php
        if ($user->prenom == null)
            echo '<div id="formPerso" class="formContainer">';
        else {
        ?>
            <p class="infosPerso espacePerso-firstLine">Vous avez déjà complété cet onglet.</p>

            <p class="infosPerso">Vous êtes <?php echo $user->prenom . " " . $user->nom . " de la promotion X" . $user->promotion ?></p>

            <button id="modifyPerso" class="btn btn-primary">Modifier mes informations</button>
            <br><br>
            <div id="formPerso" class="formContainer" style="display:none">
            <?php
        }
            ?>
            <form class="ms-4" method="post" action="index.php?page=EspacePerso">
                <div class="mb-3">
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Eric" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Labaye" required>
                </div>
                <div class="mb-3">
                    <label for="promo" class="form-label">Promotion X</label>
                    <input type="number" class="form-control" id="promo" name="promo" value=21 placeholder="21" required>
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

    </div>

    <div class="onglet" id="certif">
        <?php
        if ($user->nom == null) {
            echo '<p class="espacePerso-firstLine">Vous devez d\'abord remplir la catégorie informations personnelles.</p>';
        } elseif ($user->chauffeur) {
            echo '<p class="espacePerso-firstLine">Vous n\'avez pas besoin de renseigner de certificat.</p>';
        } else {
            if ($user->certificat) {
                echo '<div class="formContainer" style="display: none;" id="espacePerso-certificatUpload">';
            } else {
                echo '<div class="formContainer" id="espacePerso-certificatUpload">';
            }
        ?>
            <form enctype="multipart/form-data" action="index.php?page=EspacePerso" method="post">
                <div class="mb-3">
                    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                    <label for="certif_uploaded" class="form-label">Certificat médical de moins de 1 an</label>
                    <input type="file" class="form-control" name="certificat" id="certif_uploaded" />
                </div>
                <button id="espacePerso-certif-button" type="submit" class="btn btn-primary">Envoyer</button>
            </form>
    </div>
<?php
            if ($user->certificat) {
                $path = $dossier . $name;
                echo <<<FIN
                <p id="espacePerso-messageCertif" class="espacePerso-firstLine">Vous avez déjà mis votre certificat médical. Cliquez 
                <a href="" id="espacePerso-download" download><span hidden>$path</span>ici</a> pour le voir et 
                <a href="" id="espacePerso-modifyCertif">ici</a> pour le modifier</p>
FIN;
            }
        } ?>

<button class="btn btn-primary" onclick="changeView('certif', 'cards')" id="espacePerso-retourFromCertif">Retour</button>

</div>

<div class="onglet" id="payement">
    <?php
    if ($user->chauffeur)
        echo '<p>Vous n\'avez pas besoin de payer la course</p>';
    else
        echo '<p>Le paiement sera ultérieur</p>';
    ?>
    <br>
    <button class="btn btn-primary" onclick="changeView('payement', 'cards')">Retour</button>
</div>

<div class="onglet" id="restoration">
    <form method="post" action="index.php?page=EspacePerso">
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
        <button type="submit" class="btn btn-primary">Soumettre mes préférences</button>
    </form>
    <br>
    <button class="btn btn-primary" onclick="changeView('restoration', 'cards')">Retour</button>
</div>

<div class="onglet" id="affaires">

    <br>
    <button class="btn btn-primary" onclick="changeView('affaires', 'cards')">Retour</button>
</div>

<div class="onglet" id="hebergement">

    <br>
    <button class="btn btn-primary" onclick="changeView('hebergement', 'cards')">Retour</button>
</div>
</div>


</div>