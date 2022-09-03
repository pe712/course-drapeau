<nav>
    <div class="container-fluid bg-dark">
        <div class="row">
            <div class="col-md-3"><a href="index.php?page=Acceuil">Accueil</a></div>
            <div class="col-md-3"><a href="index.php?page=About">A propos</a></div>
            <div class="col-md-3"><a href="index.php?page=Inscription">Inscription</a></div>
            <div class="col-md-3"><a href="index.php?page=Contact">Qui sommes-nous?</a></div>
        </div>
    </div>
</nav>
<header>
    <?php
    if (array_key_exists("display", $_SESSION)) {
        $msg = $_SESSION["display"];
        unset($_SESSION["display"]);
        echo <<<END
        <div class="bg-warning bg-gradient">
            <h2>$msg</h2>
        </div>
        END;
    }
    ?>
    <div class="bg-primary bg-gradient text-center">
        <h1>Course Bordeaux-Polytechnique</h1>
    </div>
</header>