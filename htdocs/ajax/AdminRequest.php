<?php
// session_set_cookie_params(2*60*60, '/', 'votresite.binets.fr', true, true);
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
    } elseif ($_GET["todo"] == "download") {
        Download::download_file();
    } else
        echo "la requête demandée n'existe pas";
}
