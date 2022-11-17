<?php
class Upload
{
     public $extensions;
     public $taille_maxi;
     public $dossier;

     public function __construct($extensions, $taille_maxi, $dossier)
     {
          $this->extensions = $extensions;
          $this->taille_maxi = $taille_maxi;
          $this->dossier = $dossier;
     }

     public function upload($finalName, $file)
     {
          $extension = strtolower(substr(strrchr($file['name'], "."), 1));
          if (!in_array($extension, $this->extensions)) {
               $extension_name = $this->extensions[0];
               $_SESSION["displayError"] = "Vous devez uploader un fichier de type $extension_name";
               return false;
          }

          $taille = filesize($file['tmp_name']);
          if ($taille > $this->taille_maxi || $file["error"] == 2) {
               $_SESSION["displayError"] = 'Le fichier est trop gros...';
               return false;
          }

          if (move_uploaded_file($file['tmp_name'], $this->dossier . $finalName)) {
               $_SESSION["displayValid"] = "Upload effectué avec succès !";
               return true;
          } else {
               $_SESSION["displayError"] =  'Echec de l\'upload !';
               return false;
          }
     }
}


class Download
{
     public static function download_file()
     {
          $path = $_POST["path"];
          $user = Users::getUserPersonnalData();
          $dossier = "pages/EspacePerso/upload/";
          $name = "certificat_" . $user->prenom . "_" . $user->nom . ".pdf";
          if (strcmp($dossier.$name, $path)){
               $salt = random_int(0, 100000000000);
               $extension = substr(strrchr($path, "."), 1);
               $dest = "tmp/$salt.$extension";
               $to = "../$dest";
               $from = "../$path";
               if (copy($from, $to))
                    echo $dest;
               else
                    echo "echec";
          }
          else
               echo "Vous n'avez pas le droit de télécharger ce fichier";
     }
}
