<?php
class Connect extends Page
{
    function __construct($sections)
    {
        if (array_key_exists("ticket", $_GET)) {
            // connexion X
            $auth = CAS::CAS_get_response();
            if ($auth && Users::connectX($auth)) {
                $this->load = "EspacePerso";
                var_dump($_SESSION);
                die();
            }
            else{
        parent::__construct($sections);
            }
        } elseif (array_key_exists("mail", $_POST) &&  Users::connectExte()) {
                // connexion exté
                $this->load = "EspacePerso";
        }else{
            parent::__construct($sections);
        }
    }
}
