<?php
/* $_SESSION[] */
$nom = "BAVIERE Pierre-Emmanuel";
$dossier = "./upload/$nom/";
if (!is_dir($dossier))
    mkdir($dossier);

include("includes/PersoCertifPost.php");
?>

<form enctype="multipart/form-data" action="index.php?page=Perso" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
    <input type="file" name="certificat" />
    <input type="submit" />
</form>

<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 18%;" aria-valuemin="0" aria-valuemax="100">18%</div>
</div>
