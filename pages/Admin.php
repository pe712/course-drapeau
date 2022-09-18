<?php
if (!array_key_exists("section", $_GET) || !array_key_exists("pageModif", $_GET)) {
  header("Location:../index.php?page=Admin&pageModif=Acceuil&section=1");
  die();
} else {
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
    $article->update_db($conn);
  }
?>
  <div class="pageContainer">
    <?php
    foreach ($page_list as $page) {
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
  <div class="adminTitle">
    <div>
      <h2><b>Section <?= $section ?></b></h2>
    </div>
    <div>
      <button>Créer une sous-section</button>
    </div>
  </div>
  <form action="post"><input type="text">c'est pour créer une nouvelle sous-section</form>

  <div class="btn-group adminView" role="group" aria-label="Basic radio toggle button group">
  <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked>
  <label class="btn btn-outline-primary" for="btnradio1">Structure</label>

  <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
  <label class="btn btn-outline-primary" for="btnradio2">Modification</label>
</div>
  <?php
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
  ?>
</section>
<?php
}
