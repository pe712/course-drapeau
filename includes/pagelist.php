<?php
// name est la valeur à passer au paramètre page en méthode GET 
// sectionToRequire est le chemin de la page
$page_list = array(
    array(
        "name" => "Acceuil",
        "title" => "Course Bordeaux-Polytechnique",
        "sectionToRequire" => "pages/Acceuil.php",
    ),
    array(
        "name" => "About",
        "title" => "A propos",
        "sectionToRequire" => "pages/About.php",
    ),
    array(
        "name" => "Inscription",
        "title" => "Inscription",
        "sectionToRequire" => "pages/Inscription.php",
    ),
    array(
        "name" => "Contact",
        "title" => "Nous contacter",
        "sectionToRequire" => "pages/Contact.php",
    ),
    array(
        "name" => "Admin",
        "title" => "Modifier les page",
        "sectionToRequire" => "pages/Admin.php",
        "admin" => true,
    ),
    array(
        "name" => "Troncons",
        "title" => "Tronçons sur le parcours",
        "sectionToRequire" => "pages/Troncons.php",
    ),
    array(
        "name" => "Connect",
        "title" => "Page de connexion",
        "sectionToRequire" => "pages/Connect.php",
    ),
    array(
        "name" => "Unconnect",
        "title" => "Page de déconnexion",
        "sectionToRequire" => "pages/Unconnect.php",
    ),
    array(
        "name" => "EspacePerso",
        "title" => "Mon Espace Personnel",
        "sectionToRequire" => "pages/EspacePerso.php",
        "connected" => true,
    ),
);
