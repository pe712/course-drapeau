<?php
error_reporting(E_ALL);
session_start();

if (!array_key_exists("page", $_GET)) {
    header("Location:index.php?page=Acceuil");
    die();
}
$name = $_GET["page"];
require("includes/pagelist.php");
foreach ($page_list as $page) {
    if ($name == $page["name"]) {
        extract($page);
    }
}
if (!isset($title)) {
    header("Location:index.php?page=Acceuil");
    die();
}

if (isset($admin) && $admin) {
    $_SESSION["display"]="Vous devez avoir les droits d'administrateur pour accéder à la page $name";
    header("Location:index.php?page=Acceuil");
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <?php require("includes/linksAndScripts.php") ?>
</head>

<body>
    <?php
    require("includes/navbar.php");
    require($sectionToRequire);
    require("includes/footer.php")
    ?>
</body>

</html>
