<?php
session_start();

require("../classes/connectDB.php");
$conn = Database::connect();

require("../includes/isRoot.php");
require("../classes/GPXmanagement.php");

if (array_key_exists("todo", $_GET)) {
    if ($_GET["todo"] == "removeGPX")
        GPX::removeGPX();
    elseif ($_GET["todo"] == "calculHoraires") {
        $select = $conn->query("SELECT contenu, sous_section from content where page='Troncons' and section=1");
        while ($horaire = $select->fetch()) {
            if ($horaire["sous_section"] == 1)
                $hdep = $horaire["contenu"];
            else
                $harr = $horaire["contenu"];
        }
        $duration = $harr - $hdep;
        $select = $conn->query("SELECT * from tracesGPX");
        $n = $select->rowCount();
        if ($n == 0)
            echo "Il n'y aucune trace GPX pour le moment";
        else {
            $delta = $duration / $n;
            $current_delta = 0;
            for ($i = 1; $i <= $n; $i++) {
                $update = $conn->prepare("UPDATE tracesGPX set heure_dep=FROM_UNIXTIME(?), heure_arr=FROM_UNIXTIME(?) where id =?");
                $update->execute(array($hdep + $current_delta, $hdep + $current_delta + $delta, $i));
                $current_delta += $delta;
            }
            echo "Les horaires des traces ont été mis à jour en fontion de l'heure de départ et d'arrivée";
        }
    } else
        echo "la requête demandée n'existe pas";
}
