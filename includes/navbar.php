<nav>
    <div class="nav-mainContainer">
        <div class="nav-container">
            <div id="Accueil" class="nav-content">Accueil</div>
            <div class="nav-bar nav-top"></div>
            <div class="nav-bar nav-bot"></div>
        </div>
        <div class="nav-container">
            <div id="About" class="nav-content">A propos</div>
            <div class="nav-bar nav-top"></div>
            <div class="nav-bar nav-bot"></div>
        </div>
        <div class="nav-container">
            <div id="Contact" class="nav-content">Qui sommes-nous?</div>
            <div class="nav-bar nav-top"></div>
            <div class="nav-bar nav-bot"></div>
        </div>
        <div class="nav-container">
            <div id="Troncons" class="nav-content">Tronçons</div>
            <div class="nav-bar nav-top"></div>
            <div class="nav-bar nav-bot"></div>
        </div>
        <?php
        if (array_key_exists("id", $_SESSION)) {
            if (array_key_exists("root", $_SESSION) && $_SESSION["root"]) {
                echo <<<FIN
                    <div class="nav-container">
                        <div id="Admin" class="nav-content">Administration</div>
                        <div class="nav-bar nav-top"></div>
                        <div class="nav-bar nav-bot"></div>
                    </div>
                    FIN;
            }
            echo <<<FIN
                <div class="nav-container">
                    <div id="EspacePerso" class="nav-content">Espace Personnel</div>
                    <div class="nav-bar nav-top"></div>
                    <div class="nav-bar nav-bot"></div>
                </div>
                <div class="nav-container">
                    <div id="Unconnect" class="nav-content">Me déconnecter</div>
                    <div class="nav-bar nav-top"></div>
                    <div class="nav-bar nav-bot"></div>
                </div>
                FIN;
        } else {
        ?>
            <div class="nav-container">
                <div id="Inscription" class="nav-content">Inscription</div>
                <div class="nav-bar nav-top"></div>
                <div class="nav-bar nav-bot"></div>
            </div>
            <div class="nav-container">
                <div id="Connect" class="nav-content">Me connecter</div>
                <div class="nav-bar nav-top"></div>
                <div class="nav-bar nav-bot"></div>
            </div>
        <?php
        }
        ?>
    </div>

</nav>
<header>
    <div class="bg-primary bg-gradient text-center">
        <h1 class="nav-h1">Course Bordeaux-Polytechnique</h1>
    </div>
    <?php
    if (array_key_exists("displayError", $_SESSION)) {
        $msg = $_SESSION["displayError"];
        unset($_SESSION["displayError"]);
        echo <<<END
        <div class="bg-warning bg-gradient">
            <h2>$msg</h2>
        </div>
        END;
    } elseif (array_key_exists("displayValid", $_SESSION)) {
        $msg = $_SESSION["displayValid"];
        unset($_SESSION["displayValid"]);
        echo <<<END
        <div class="bg-success bg-gradient">
            <h2>$msg</h2>
        </div>
        END;
    }
    ?>
</header>