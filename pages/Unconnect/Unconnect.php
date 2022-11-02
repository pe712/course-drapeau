<?php
session_unset();
$_SESSION["displayValid"] = "Vous avez correctement été déconnecté.";
require("pages/Display.php");
$sections = Content::getPage("Accueil");
require("pages/Accueil.php");
?>