<?php

require("classes/GPXmanagement.php");
require_once("classes/upload.php");

if (isset($_FILES['trace'])) {
  GPX::uploadGPX_updateDB($_FILES["trace"]);
}

if (isset($_FILES['traces'])) {
  GPX::uploadGPX_updateDB_multiple();
}
?>

<section class="adminSection">

  <!-- Choix de la vue -->
  <div class="btn-group adminView" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check admin-onglet-button" name="btnradio" id="admin-contenu">
    <label class="btn btn-outline-primary" for="admin-contenu">Contenu général</label>

    <input type="radio" class="btn-check admin-onglet-button" name="btnradio" id="admin-GPX">
    <label class="btn btn-outline-primary" for="admin-GPX">Traces GPX</label>
  </div>

  <!-- Vue Structure -->
  <div id="admin-contenu-onglet" class="admin-onglet">
    <div class="btn-group adminView" role="group" aria-label="Basic radio toggle button group">
      <?php
      foreach ($page_list as $page) {
        if ($page["content"]) {
          $title = $page["title"];
          $name = $page["name"];
          echo <<<FIN
          <input type="radio" class="btn-check admin-page-button" name="btnradio" id="admin-$name">
          <label class="btn btn-outline-primary" for="admin-$name">$title</label>
          FIN;
        }
      }
      ?>
    </div>
    Voici la structure
    <div>
      <?php
      $parité = true;
      require("classes/contentManagement.php");
      $contenu_total = Content::contenu_total(true);
      foreach ($contenu_total as $page) {
        echo "<div class='parité$parité admin-structure-page' id='admin-structure-".$page["name"]."'><span class='caret caret-down'>Page " . $page["name"] . "</span><ul class='nested active'>";
        foreach ($page["sections"] as $key => $section) {
          echo "<li><span class='caret'> Section $key<br><span class=admin-sectionDesc>" . $section["desc"] . "</span></span><ul class='nested'>";
          foreach ($section["items"] as $keyi => $item) {
            echo "<li>Item " . ($keyi + 1) . " <button id=" . $page["name"] . "_" . $key . "_" . ($keyi + 1) . ' class="btn admin-modif"><b>voir/modifier</b></button></li>';
            echo "<p id=content_" . $page["name"] . "_" . $key . "_" . ($keyi + 1) . " hidden>$item</p>";
          }
          echo "</ul></li>";
        }
        echo "</ul></div>";
        $parité = !$parité;
      }
      ?>
    </div>
    <div id="admin-modify">
      <textarea type="text" id="admin-textarea"></textarea>
      <button type="submit" class="btn btn-primary" id="admin-modify-button">Envoyer les modifications</button>
      <div id="admin-modify-infos" hidden></div>
    </div>
  </div>


  <!-- Vue GPX -->
  <div id="admin-GPX-onglet" class="admin-onglet">
    <div class="formContainer">
      <form enctype="multipart/form-data" action="index.php?page=Admin&pageModif=Acceuil&section=2" method="post">
        <div class="mb-3">
          <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
          <label for="trace" class="form-label">Trace GPX numéroté (par exemple: trace10.gpx)</label>
          <input type="file" class="form-control" name="trace" id="trace" />
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>

    <div class="formContainer">
      <form enctype="multipart/form-data" action="index.php?page=Admin&pageModif=Acceuil&section=2" method="post">
        <div class="mb-3">
          <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
          <label for="loader" class="form-label">Dossier contenant toutes les traces GPX numérotées (par exemple: trace10.gpx)</label>
          <input type="file" class="form-control" name="traces[]" id="loader" webkitdirectory multiple />
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>

    <button id="admin-gpx-button" class="btn btn-primary">Supprimer toutes les traces enregistrées</button>
    <br><br>
    <button id="admin-horaires-button" class="btn btn-primary">Calculer les horaires de passage</button>
    <br><br>
  </div>


  <!-- Vue sections -->
  <div id="admin-section-onglet" class="admin-onglet">
    <div class="adminTitle">
      <div>
        <h2><b>Section <?= $section ?></b></h2>
      </div>
      <div>
        <button>Créer une sous-section</button>
        <form action="post"><input type="text">c'est pour créer une nouvelle sous-section</form>
      </div>
    </div>
  </div>

  <div id="cs-popup-area"></div>
</section>