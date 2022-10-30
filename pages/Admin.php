<?php

require("classes/GPXmanagement.php");
require("classes/fileManagement.php");

if (isset($_FILES['trace'])) {
  GPX::uploadGPX_updateDB($_FILES["trace"]);
  require("pages/Display.php");
}

if (isset($_FILES['traces'])) {
  GPX::uploadGPX_updateDB_multiple();
  require("pages/Display.php");
}

if (array_key_exists("page", $_POST)) {
  if (strlen($_POST["item_contenu"]) == 0) {
    Content::addSection();
  } else {
    Content::addItem();
  }
}

$contenu_total = Content::contenu_total($full = true, $raw = true);

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
      foreach ($contenu_total as $page) {
        $name = $page["name"];
        $title = Pages::findPage($name)["title"];
        echo <<<FIN
        <input type="radio" class="btn-check admin-page-button" name="btnradio" id="admin-$name">
        <label class="btn btn-outline-primary" for="admin-$name">$title</label>
FIN;
      }

      ?>
    </div>
    <div>Voici la structure</div>
    <div>
      <?php
      $parité = true;
      foreach ($contenu_total as $page) {
        echo "<div class='parité$parité admin-structure-page' id='admin-structure-" . $page["name"] . "'><span class='caret caret-down'>Page " . $page["name"] . "  </span><button class='admin-button-add' id='admin-add-section-" . $page["name"] . "'>Ajouter une section <img src='img/icons/plus.png' alt='ajouter une section' class='admin-icon'></button><ul class='nested active'>";
        foreach ($page["sections"] as $key => $section) {
          echo "<li class=admin-" . $page["name"] . "-section><span class='caret admin-section' id=" . $page["name"] . "_" . $key . "> Section $key</span><button class='admin-button-add' id='admin-add-item-" . $page["name"] . "-" . $key . "'>Ajouter un item <img src='img/icons/plus.png' alt='ajouter un item' class='admin-icon'></button><br><span class=admin-sectionDesc>" . $section["desc"] . "</span><ul class='nested'>";
          foreach ($section["items"] as $keyi => $item) {
            echo "<li>Item " . ($keyi + 1) . " <button id=" . $page["name"] . "_" . $key . "_" . ($keyi + 1) . ' class="btn admin-modif"><b>voir/modifier</b></button>';
            echo "<span id=content_" . $page["name"] . "_" . $key . "_" . ($keyi + 1) . " hidden>" . $item . "</span></li>";
          }
          echo "</ul></li>";
        }
        echo "</ul></div>";
        $parité = !$parité;
      }
      ?>
    </div>

    <br><br>

    <div id="admin-modify" class="admin-new-area">
      <h4>
        <!-- will be written by client -->
      </h4>
      <textarea id="admin-textarea"></textarea>
      <button type="submit" class="btn btn-primary" id="admin-modify-button">Envoyer les modifications</button>
      <div id="admin-modify-infos" hidden></div>
    </div>

    <div id="admin-add" class="admin-new-area">
      <h4></h4>
      <form action="index.php?page=Admin" method="post">
        <input type="hidden" name="page" id="admin-submit-page">
        <div>
          <label for="admin-section-desc" class="admin-form form-label admin-section-desc">Description</label>
          <input type="text" class="admin-form form-control admin-section-desc" id="admin-section-desc" name="section_description">
        </div>
        <div>
          <label for="admin-section-num" class="admin-form form-label admin-section-num">Numéro de section</label>
          <input type="number" class="admin-form form-control admin-section-num" id="admin-section-num" name="section_num">
        </div>
        <div>
          <label for="admin-item-content" class="admin-form form-label admin-item-content">Contenu</label>
          <input type="text" class="admin-form form-control admin-item-content" id="admin-item-content" name="item_contenu">
        </div>
        <div>
          <label for="admin-item-num" class="admin-form form-label admin-item-num">Numéro d'item</label>
          <input type="number" class="admin-form form-control admin-item-num" id="admin-item-num" name="item_num">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Créer</button>
      </form>
    </div>

  </div>


  <!-- Vue GPX -->
  <div id="admin-GPX-onglet" class="admin-onglet">
    <div class="formContainer">
      <form enctype="multipart/form-data" action="index.php?page=Admin&pageModif=Accueil&section=2" method="post">
        <div class="mb-3">
          <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
          <label for="trace" class="form-label">Trace GPX numéroté (par exemple: trace10.gpx)</label>
          <input type="file" class="form-control" name="trace" id="trace" />
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>

    <div class="formContainer">
      <form enctype="multipart/form-data" action="index.php?page=Admin&pageModif=Accueil&section=2" method="post">
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



  <div id="cs-popup-area"></div>
</section>