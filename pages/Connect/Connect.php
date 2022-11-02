<?php
class Connect extends Page
{
    function __construct($sections)
    {
        if (array_key_exists("mail", $_POST) &&  Users::connectUser()) {
            $this->load = "EspacePerso";
        } else {
            parent::__construct($sections);
        }
    }
}
