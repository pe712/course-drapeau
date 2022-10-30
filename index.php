<?php
error_reporting(E_ALL);
// session_set_cookie_params(2*60*60, '/', 'votresite.binets.fr', true, true);
session_start();

if (!array_key_exists("page", $_GET))
    $name = "Accueil";
else
    $name = $_GET["page"];

require("classes/pageManagement.php");
extract(Pages::findPage($name));

require("classes/usersManagement.php");
// root or connected access needed
if ((isset($admin) && $admin && !Users::isRoot())||(isset($connected) && $connected&&!Users::isConnected())){
    extract(Pages::findPage("Accueil"));
}

require("classes/connectDB.php");
$conn = Database::connect();

require("classes/contentManagement.php");
$sections = Content::getPage($name);

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
        <div class="mainContent">
            <?php
        require("includes/navbar.php");
        require("pages/Display.php");
        require($sectionToRequire);
        ?>
    </div>
    <?php
    require("includes/footer.php")
    ?>
</body>

</html>