<?php
class Inscription extends Page
{
    public function __construct($sections)
    {
        if (array_key_exists("mail", $_POST) && Users::newUser()) {
            $this->load = "EspacePerso";
        } else
            parent::__construct($sections);
    }
}
