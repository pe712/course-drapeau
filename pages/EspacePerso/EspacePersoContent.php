<?php
if (array_key_exists("firstname", $_POST)) {
    Users::updateInfos();
}

if (array_key_exists("name", $_SESSION)) {
    $prenom = " " . $_SESSION["name"];
}

$user = Users::getUserPersonnalData();
/**************** Message d'accueil *************************/
$x = $user->avancement();
$val = round($x * 100) . "%";
if ($x == 1)
    $texte = "Bravo" . $prenom . ", tu as complété tout ton espace personnel.";

else
    $texte = "Bienvenue" . $prenom . ", tu en est à $val du remplissage de ton espace personnel.";

/**************** variables du dossier d'upload *************************/
if ($user->nom != null) {
    //on ne veut pas donner directement l'id
    $dossier = "pages/EspacePerso/upload/";
    $name = "certificat_" . $user->prenom . "_" . $user->nom . ".pdf";

    if (!is_dir($dossier))
        mkdir($dossier);

    if (isset($_FILES['certificat'])) {
        Users::uploadCertificat($dossier, $name);
    }
}
?>
<div class="espacePersoMainContainer">
    <p class="progression"><?= $texte ?></p>

    <div class="progress">
        <div id="espacePerso-progress-bar" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"><?= $val ?></div>
    </div>

    <div id="cards" class="espacePersoRowContainer">
        <?php
        $text = array(
            "Mes informations personnelles" => "info",
            "Mon certificat médical" => "certif",
            "Paiement de la course" => "payement",
            "Sondage alimentation" => "restoration",
        );

        foreach ($text as $key => $value) {
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
        ?>
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
                <br>
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
                            Courreur
                        </label>
                        <input class="form-check-input" type="radio" name="type" id="coureur" value="coureur" checked>
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

                <button id="retourFromInfo" class="btn btn-primary" onclick="changeView('info', 'cards', 'none', 'flex')">Retour</button>

        </div>

        <div class="onglet" id="certif">
            <?php
            if ($user->nom == null) {
                echo '<p class="espacePerso-firstLine">Vous devez d\'abord remplir la catégorie informations personnelles.</p>';
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
            }
            if ($user->certificat) {
                $path = $dossier . $name;
                echo <<<FIN
        <p id="espacePerso-messageCertif" class="espacePerso-firstLine">Vous avez déjà mis votre certificat médical. Cliquez 
        <a href="" id="espacePerso-download" download><span hidden>$path</span>ici</a> pour le voir et 
        <a href="" id="espacePerso-modifyCertif">ici</a> pour le modifier</p>
FIN;
            } ?>

    <button class="btn btn-primary" onclick="changeView('certif', 'cards', 'none', 'flex')" id="espacePerso-retourFromCertif">Retour</button>

    </div>

    <div class="onglet" id="payement">
        <p>Le paiement sera ultérieur</p>
        <br>
        <button class="btn btn-primary" onclick="changeView('payement', 'cards', 'none', 'flex')">Retour</button>
    </div>

    <div class="onglet" id="restoration">
        <<!-- form method="post" action="index.php?page=Connect">
            <div class="mb-3">
                <label for="mail" class="form-label">Email</label>
                <input type="email" class="form-control" id="mail" name="mail" placeholder="eric.labaye@polytechnique.edu" required>
            </div>
            <div class="mb-3">
                <label for="pwd1" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="pwd1" name="mdp" required>
            </div>
            <button type="submit" class="btn btn-primary">Me connecter</button>
        </form> -->
        Ici apparaîtra le sondage sur la partie restauration.
        <br>
        <button class="btn btn-primary" onclick="changeView('restoration', 'cards', 'none', 'flex')">Retour</button>
    </div>
</div>


</div>