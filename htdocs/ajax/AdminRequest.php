<?php
// session_set_cookie_params(2*60*60, '/', 'votresite.binets.fr', true, true);
session_start();

$files = glob('../classes/*.php');
foreach ($files as $file) {
    require($file);   
}

$conn = Database::connect();
Users::isRoot();

if (array_key_exists("todo", $_GET)) {
    if ($_GET["todo"] == "removeGPX")
        GPX::removeGPX();
    elseif ($_GET["todo"] == "calculHoraires") {
        GPX::calculHoraires();
    } elseif ($_GET["todo"] == "contentModif") {
        Content::update_db();
    } elseif ($_GET["todo"] == "download") {
        Download::download_file();
    } else
        echo "la requête demandée n'existe pas";
}
