<?php

/* $_SESSION[] */
$nom = "BAVIERE Pierre-Emmanuel";
$dossier = "./upload/$nom/";

if (!is_dir($dossier))
  mkdir($dossier);

include("pages/espacePerso/PersoCertifPost.php");
?>

<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 18%;" aria-valuemin="0" aria-valuemax="100">18%</div>
</div>

<br>

<div class="formContainer">
  <form enctype="multipart/form-data" action="index.php?page=EspacePerso" method="post">
    <div class="mb-3">
      <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
      <label for="certif" class="form-label">Certificat médical de moins de 1 an</label>
      <input type="file" class="form-control" name="certificat" id="certif" />
    </div>
    <input type="submit" class="btn btn-primary">Envoyer</button>
  </form>
</div>
