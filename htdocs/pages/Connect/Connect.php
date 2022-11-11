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
            }
        } else {
            // connexion exté
            if (array_key_exists("mail", $_POST) &&  Users::connectExte()) {
                $this->load = "EspacePerso";
            }
        }
        parent::__construct($sections);
    }
}
