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