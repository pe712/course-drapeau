<?php

if (!array_key_exists("root", $_SESSION) || !$_SESSION["root"]) {
    $_SESSION["displayError"] = "Vous devez avoir les droits d'administrateur pour accéder à la page $name";
    header("Location:index.php?page=Acceuil");
    die();
}
