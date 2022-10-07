<?php
require("classes/usersManagement.php");

/* $_SESSION[] */
$nom = "BAVIERE Pierre-Emmanuel";
$dossier = "pages/espacePerso/upload/$nom/";
$name = "certificat medical $nom.pdf";

if (!is_dir($dossier))
  mkdir($dossier);

if (isset($_FILES['certificat'])) {
  require("classes/upload.php");
  Users::uploadCertificat($dossier, $name);
}

if (array_key_exists("firstname", $_POST)) {
  Users::updateInfos();
}

if (array_key_exists("name", $_SESSION)) {
  $prenom = " " . $_SESSION["name"];
}

$user = users::getUserPersonnalData();
$x = $user->avancement();
$val = round($x * 100) . "%";
if ($x == 100)
  $texte = "Bravo" . $prenom . ", tu as complété tout ton espace personnel.";

else
  $texte = "Bienvenue" . $prenom . ", tu en est à $val du remplissage de ton espace personnel.";


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
        <p class="infosPerso">Vous avez déjà complété cet onglet.</p>

        <p class="infosPerso">Vous êtes <?php echo $user->prenom . " " . $user->nom . " de la promotion X" . $user->promotion ?></p>

        <button id="modifyPerso" class="btn btn-primary">Modifier mes informations</button>

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
          <button type="submit" class="btn btn-primary">Valider</button>
        </form>
        </div>

        <button id="retourFromInfo" class="btn btn-primary" onclick="changeView('info', 'cards', 'none', 'flex')">Retour</button>

    </div>


    <div class="onglet" id="certif">
      <div class="formContainer">
        <form enctype="multipart/form-data" action="index.php?page=EspacePerso" method="post">
          <div class="mb-3">
            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
            <label for="certif" class="form-label">Certificat médical de moins de 1 an</label>
            <input type="file" class="form-control" name="certificat" id="certif" />
          </div>
          <button id="espacePerso-certif-button" type="submit" class="btn btn-primary">Envoyer</button>
        </form>
      </div>

      <butto class="btn btn-primary" onclick="changeView('certif', 'cards', 'none', 'flex')">Retour</button>

    </div>
    <div class="onglet" id="payement">

      <button class="btn btn-primary" onclick="changeView('payement', 'cards', 'none', 'flex')">Retour</button>
    </div>
  </div>


</div>