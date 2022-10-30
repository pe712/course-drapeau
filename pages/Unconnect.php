<?php
session_unset();
$_SESSION["displayValid"] = "Vous avez correctement été déconnecté.";
header("location:index.php?page=Accueil");
die();
?>