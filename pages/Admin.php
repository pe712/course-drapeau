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
  $select = $conn->prepare("select * from content where page=? and section=?");
  $select->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Content');
  $select->execute(array($pageModif, $section));
  $n = $select->rowCount();
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

  if ($n != 0) {
  ?>
    <footer>
      <nav aria-label="About pagination">
        <ul class="pagination">
          <?php
          if ($section == 1)
            $sectionP = $section;
          if ($section == $n)
            $sectionS = $section;
          if (!isset($sectionP))
            $sectionP = $section - 1;
          if (!isset($sectionS))
            $sectionS = $section + 1;

          echo <<<END
        <li class="page-item"><a class="page-link" href="index.php?page=Admin&pageModif=$pageModif&section=$sectionP">Précédent</a></li>
        END;
          for ($k = 1; $k <= $n; $k++) {
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
