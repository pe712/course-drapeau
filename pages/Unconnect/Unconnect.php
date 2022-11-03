<?php
class Unconnect extends Page
{
    public function __construct($sections) {
        session_destroy();
        $_SESSION["displayValid"] = "Vous avez correctement été déconnecté.";
        $this->load = "Accueil";
    }
}

?>