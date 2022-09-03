<?php
$n = 5;
if (!array_key_exists("section", $_GET)) {
  header("Location:index.php?page=Admin&section=1");
  die();
}
$section = $_GET["section"];
?>
<section>
  <article>
    Affiche la section <?= $section ?>
    <form action="" method="post">
      <input type="text" name="champ" id="" value="ce qui est déjà écrit">
      <?php
      echo "<input type=number name=section value=$section hidden>";
      ?>
      <input type="submit">
    </form>

  </article>
  <br>
  <footer>
    <nav aria-label="About pagination">
      <ul class="pagination">
        <?php
        if ($section == 1) {
          $sectionP = $section;
          $sectionS = $section + 1;
        } else if ($section == $n) {
          $sectionP = $section - 1;
          $sectionS = $section;
        } else {
          $sectionP = $section - 1;
          $sectionS = $section + 1;
        }
        echo <<<END
        <li class="page-item"><a class="page-link" href="index.php?page=Admin&section=$sectionP">Précédent</a></li>
        END;
        for ($k = 1; $k <= $n; $k++) {
          echo <<<END
          <li class="page-item"><a class="page-link" href="index.php?page=Admin&section=$k">$k</a></li>
          END;
        }
        echo <<<END
        <li class="page-item"><a class="page-link" href="index.php?page=Admin&section=$sectionS">Suivant</a></li>
        END;
        ?>
      </ul>
    </nav>
  </footer>
</section>

