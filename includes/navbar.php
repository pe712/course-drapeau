<nav>
    <div class="container-fluid bg-dark">
        <div class="row">
            <div class="col-md-2"><a href="index.php?page=Acceuil">Accueil</a></div>
            <div class="col-md-2"><a href="index.php?page=About">A propos</a></div>
            <div class="col-md-2"><a href="index.php?page=Contact">Qui sommes-nous?</a></div>
            <?php
            if (array_key_exists("id", $_SESSION))
                echo <<<FIN
                <div class="col-md-4" style="color: var(--bs-link-color)">Bienvenue</div>
                <div class="col-md-2"><a href="index.php?page=Unconnect">Me déconnecter</a></div>
                FIN;
            else
                echo <<<FIN
                <div class="col-md-2"><a href="index.php?page=Inscription">Inscription</a></div>
                <div class="col-md-2"><a href="index.php?page=Connect">Me connecter</a></div>
                FIN;
            ?>
        </div>
    </div>
</nav>
<header>
    <?php
    if (array_key_exists("displayError", $_SESSION)) {
        $msg = $_SESSION["displayError"];
        unset($_SESSION["displayError"]);
        echo <<<END
        <div class="bg-warning bg-gradient">
            <h2 style="margin:0">$msg</h2>
        </div>
        END;
    } elseif (array_key_exists("displayValid", $_SESSION)) {
        $msg = $_SESSION["displayValid"];
        unset($_SESSION["displayValid"]);
        echo <<<END
        <div class="bg-success bg-gradient">
            <h2 style="margin:0">$msg</h2>
        </div>
        END;
    }

    ?>
    <div class="bg-primary bg-gradient text-center">
        <h1>Course Bordeaux-Polytechnique</h1>
    </div>
</header>