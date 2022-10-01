<?php

/* $_SESSION[] */
$nom = "BAVIERE Pierre-Emmanuel";
$dossier = "pages/espacePerso/upload/$nom/";
$name = "certificat medical $nom.pdf";

if (!is_dir($dossier))
  mkdir($dossier);

if (isset($_FILES['certificat'])) {
  require("classes/upload.php");
  $finalUrl = "index.php?page=EspacePerso";
  $certif = new Upload(array(".pdf", ".PDF"), 500000, $dossier, $finalUrl);
  $file = $_FILES['certificat'];
  $certif->upload($name, $file);
  header("location:$finalUrl");
  die();
}
?>


<div class="espacePersoMainContainer">
  <p class="progression">Progression :</p>

  <div class="progress">
    <div class="progress-bar" role="progressbar" style="width: 18%;" aria-valuemin="0" aria-valuemax="100">18%</div>
  </div>

  <div class="espacePersoRowContainer">
    <div class="card">
      <div class="card-body">
        <h2>
          <a href="" class="stretched-link">Mes informations personnelles</a>
        </h2>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h2>
          <a href="" class="stretched-link">Mon certificat médical</a>
        </h2>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h2>
          <a href="" class="stretched-link">Mes informations personnelles</a>
        </h2>
      </div>
    </div>
  </div>


  <br>

  <div class="formContainer">
    <form enctype="multipart/form-data" action="index.php?page=EspacePerso" method="post">
      <div class="mb-3">
        <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
        <label for="certif" class="form-label">Certificat médical de moins de 1 an</label>
        <input type="file" class="form-control" name="certificat" id="certif" />
      </div>
      <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
  </div>
</div>
<?php
