<?php
if (!array_key_exists("section", $_GET) || !array_key_exists("pageModif", $_GET)) {
  header("Location:../index.php?page=Admin&pageModif=Acceuil&section=1");
  die();
}

/* if (isset($_FILES['trace'])) {
  $finalUrl = "index.php?page=Admin&pageModif=Acceuil&section=3";
  preg_match("/\d+/", $_FILES['trace']['name'], $matches);
  if (count($matches) == 0) {
    $_SESSION["displayError"] = "le nom du fichier est incorrect, ce doit être trace15.gpx par exemple.";
    header("location:$finalUrl");
    die();
  } else {
    $num = $matches[0];
    $dossier = "pages/troncons/";
    $name = "trace$num.gpx";

    require("classes/upload.php");
    $trace = new Upload(array(".gpx", ".GPX"), 3000000, $dossier, $finalUrl);
    $trace->upload($name, "trace");

    require("classes/GPXmanagement.php");
    GPX::update_GPXStartStop_DB($dossier . $name, $num);
    header("location:$finalUrl");
    die();
  }
} */
var_dump($_FILES['trace']);

$section = $_GET["section"];
$pageModif = $_GET["pageModif"];
if (array_key_exists("contenu", $_POST)) {
  extract($_POST);
  $article = new Content(
    $pageModif,
    $section,
    $sous_section,
    $contenu
  );
  $article->update_db();
}
?>
<div class="pageContainer">
  <?php
  foreach ($page_list as $page) {
    if ($page["content"]) {
      if ($_GET["pageModif"] == $page["name"]) {
        echo "<div id=activeModif><div>";
      } else
        echo "<div><div>";
  ?>
      <a href="index.php?page=Admin&pageModif=<?= $page["name"] ?>&section=1"><?= $page["title"] ?></a>
</div>
</div>
<?php
    }
  }
?>
</div>

<section class="adminSection">
  <?php
  $select = $conn->prepare("SELECT COUNT(DISTINCT(section)) FROM content WHERE page=?");
  $select->execute(array($pageModif));
  $n_sec = $select->fetch()[0];

  $select = $conn->prepare("SELECT * FROM content WHERE page=? and section=?");
  $select->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Content');
  $select->execute(array($pageModif, $section));
  ?>


  <!-- Choix de la vue -->
  <div class="btn-group adminView" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" onclick="changeView('AdminModification', 'AdminStructure')" checked>
    <label class="btn btn-outline-primary" for="btnradio1">Structure</label>

    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" onclick="changeView('AdminStructure', 'AdminModification')">
    <label class="btn btn-outline-primary" for="btnradio2">Modification</label>
  </div>

  <!-- Vue Modif -->
  <div id="AdminModification">
    <div class="adminTitle">
      <div>
        <h2><b>Section <?= $section ?></b></h2>
      </div>
      <div>
        <button>Créer une sous-section</button>
        <form action="post"><input type="text">c'est pour créer une nouvelle sous-section</form>
      </div>
    </div>
    <?php

    /* bouton de choix de la section à modifier */
    if ($n_sec != 0) {
    ?>
      <footer>
        <div>Choix de section</div>
        <nav aria-label="About pagination">
          <ul class="pagination">
            <?php
            if ($section == 1)
              $sectionP = $section;
            if ($section == $n_sec)
              $sectionS = $section;
            if (!isset($sectionP))
              $sectionP = $section - 1;
            if (!isset($sectionS))
              $sectionS = $section + 1;

            echo <<<END
          <li class="page-item"><a class="page-link" href="index.php?page=Admin&pageModif=$pageModif&section=$sectionP">Précédent</a></li>
          END;
            for ($k = 1; $k <= $n_sec; $k++) {
              echo <<<END
            <li class="page-item"><a class="page-link" href="index.php?page=Admin&pageModif=$pageModif&section=$k">$k</a></li>
            END;
            }
            echo <<<END
          <li class="page-item"><a class="page-link" href="index.php?page=Admin&pageModif=$pageModif&section=$sectionS">Suivant</a></li>
          END;
            ?>
          </ul>
        </nav>
      </footer>
    <?php
    }

    /* Impression du contenu de la section de la page demandée */
    while ($article = $select->fetch()) {
    ?>
      <article>
        <form action="index.php?page=Admin&pageModif=<?= $pageModif ?>&section=<?= $section ?>" method="post">
          <p>
            <label for="contenu">
              <?= $article->description ?></label>
          </p>
          <textarea type="text" name="contenu" id="contenu"><?= $article->contenu ?></textarea>
          <input type=number name=sous_section value=<?= $article->sous_section ?> hidden>
          <br>
          <button type="submit">Modifier cette sous-section</button>
        </form>
      </article>
      <br>
    <?php
    }
    ?>
  </div>

  <!-- Vue Structure -->
  <div id="AdminStructure">
    Voici la structure
    <?php
    $select = $conn->query("SELECT * FROM content ORDER BY page, section, sous_section");
    $select->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Content');
    $page = null;
    $section = null;
    $firstP = true;
    $parité = "pair";
    echo "<ul id=myUL>";
    while ($sub_section = $select->fetch()) {
      $Npage = $sub_section->page;
      $Nsection = $sub_section->section;
      $desc = $sub_section->description;
      if ($Npage != $page) {
        $page = $Npage;
        $firstS = true;
        if ($parité == "pair")
          $parité = "impair";
        else
          $parité = "pair";
        if (!$firstP)
          echo "</ul></li></ul></div>";
        else
          $firstP = false;
        echo "<div class=$parité><li><span class='caret caret-down'> Page $Npage </span><ul class='nested active'>";
      }
      if ($Nsection != $section) {
        $section = $Nsection;
        if (!$firstS)
          echo "</ul></li>";
        else
          $firstS = false;
        echo "<li><span class='caret'> Section $section </span><ul class='nested'>";
      }
      echo "<li>$desc</li>";
    }
    echo "</ul>";
    ?>
  </div>

  <div id=GPXmanagement>

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
    GPXmanagement
  </div>
</section>