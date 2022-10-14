<?php
session_start();

require("../classes/connectDB.php");
$conn = Database::connect();

require("../classes/usersManagement.php");
Users::isRoot();
require("../classes/GPXmanagement.php");

if (array_key_exists("todo", $_GET)) {
    if ($_GET["todo"] == "removeGPX")
        GPX::removeGPX();
    elseif ($_GET["todo"] == "calculHoraires") {
        GPX::calculHoraires();
    } else
        echo "la requête demandée n'existe pas";
}
