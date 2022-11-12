<?php
if (array_key_exists("firstname", $_POST)) {
    Users::updateInfos();
}

if (array_key_exists("vegetarian", $_POST)) {
    Users::updateLogistique();
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
                "Logistique" => "logistique",
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

    <div>
        <?php
        foreach ($lines as $line) {
            foreach ($line as $value) {
                require("pages/EspacePerso/cards/$value.php");
            }
        }
        ?>
    </div>
</div>