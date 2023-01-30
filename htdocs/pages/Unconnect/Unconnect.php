<?php
class Unconnect extends Page
{
    public function __construct($sections) {
        session_unset();
        $_SESSION["displayValid"] = "Tu as correctement été déconnecté.";
        $this->load = "Accueil";
    }
}

?>