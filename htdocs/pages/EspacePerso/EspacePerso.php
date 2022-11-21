<?php
class EspacePerso extends Page
{
    public function __construct($sections)
    {
        //je traite les différents POST possibles et je die() s'il y'a une erreur
        if (array_key_exists("firstname", $_POST) && (!Users::updateInfos()))
            $this->load = "EspacePerso";
        elseif (array_key_exists("vegetarian", $_POST) && (!Users::updateLogistique()))
            $this->load = "EspacePerso";

        $user = Users::getUserPersonnalData();
        /**************** variables du dossier d'upload *************************/
        if ($user->nom != null) {
            $dossier = "pages/EspacePerso/upload/";
            $name = "certificat_" . $user->prenom . "_" . $user->nom . ".pdf";
            if (!is_dir($dossier))
                mkdir($dossier);
            if (isset($_FILES['certificat']) && (!Users::uploadCertificat($dossier, $name)))
                $this->load = "EspacePerso";
        }
        if ($this->load == null)
            parent::__construct($sections);
    }
}
