<?php
if (array_key_exists("firstname", $_POST)) {
  Users::updateInfos();
}

if (array_key_exists("name", $_SESSION)) {
  $prenom = " " . $_SESSION["name"];
}

$user = users::getUserPersonnalData();
/**************** Message d'acceuil *************************/
$x = $user->avancement();
$val = round($x * 100) . "%";
if ($x == 1)
  $texte = "Bravo" . $prenom . ", tu as complété tout ton espace personnel.";

else
  $texte = "Bienvenue" . $prenom . ", tu en est à $val du remplissage de ton espace personnel.";

/**************** variables du dossier d'upload *************************/
if ($user->nom != null) {
  $dossier = "pages/espacePerso/" . $user->hash . "/";
  $name = "certificat " .$user->prenom." ". $user->nom . ".pdf";

  if (!is_dir($dossier))
    mkdir($dossier);

  if (isset($_FILES['certificat'])) {
    require("classes/upload.php");
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
            <label for="certif" class="form-label">Certificat médical de moins de 1 an</label>
            <input type="file" class="form-control" name="certificat" id="certif" />
          </div>
          <button id="espacePerso-certif-button" type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
  <?php
      }
      if ($user->certificat) {
        $path = $dossier . $name;
        echo <<<FIN
        <p id="espacePerso-messageCertif" class="espacePerso-firstLine">Vous avez déjà mis votre certificat médical. Cliquez <a href="$path" download>ici</a> pour le voir et <a href="" id="espacePerso-modifyCertif">ici</a> pour le modifier</p>
        FIN;
      } ?>

  <butto class="btn btn-primary" onclick="changeView('certif', 'cards', 'none', 'flex')" id="espacePerso-retourFromCertif">Retour</button>

  </div>
  <div class="onglet" id="payement">
    <?php
    if (!$user->paid) {
    ?>
      <p>
        La course coûte x€, vous pouvez régler <a href="https://lydia-app.com/collect/1742-raclet/fr?from=app" target="_blank" id="espacePerso-lienPaiement">ici</a>
      </p>
      <p id="espacePerso-messagePaiement">
        Dès que le paiement sera validé, vous recevrez un mail et cet onglet sera mis à jour.
      </p>
    <?php } else {
    ?>
      <p class="espacePerso-firstLine">
        Vous avez déjà payé la course.
      </p>
    <?php } ?>
    <br>
    <button class="btn btn-primary" onclick="changeView('payement', 'cards', 'none', 'flex')">Retour</button>
  </div>
</div>


</div>