<?php
class Admin extends Page
{
    function __construct($sections)
    {
        if (isset($_FILES['trace']) && (!GPX::uploadGPX_updateDB($_FILES["trace"])))
            $this->load = "Admin";
        elseif (isset($_FILES['traces']) && (!GPX::uploadGPX_updateDB_multiple()))
            $this->load = "Admin";
        elseif (array_key_exists("page", $_POST)) {
            if (strlen($_POST["item_contenu"]) == 0) {
                if (!Content::addSection())
                    $this->load = "Admin";
            } else {
                if (!Content::addItem())
                    $this->load = "Admin";
            }
        }
        if ($this->load == null)
            parent::__construct($sections);
    }
}
