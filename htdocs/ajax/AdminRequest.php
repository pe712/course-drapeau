<?php
require("../pages/includes/headers.php");
session_start();

$files = glob('../classes/*.php');
foreach ($files as $file) {
    require($file);
}

$conn = Database::connect();
if (array_key_exists("todo", $_GET)) {
    if ($_GET["todo"] == "removeGPX" && Users::isRoot())
        GPX::removeGPX();
    elseif ($_GET["todo"] == "calculHoraires" && Users::isRoot()) {
        GPX::calculHoraires();
    } elseif ($_GET["todo"] == "contentModif" && Users::isRoot()) {
        Content::update_db();
    } elseif ($_GET["todo"] == "download" && Users::isConnected()) {
        Download::download_file();
    } else
        echo "Vous n'avez pas les droits nécessaires ou la requête demandée n'existe pas";
}
