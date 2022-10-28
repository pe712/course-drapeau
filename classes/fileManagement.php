<?php
class Upload
{
     public $extensions;
     public $taille_maxi;
     public $dossier;
     public $finalUrl;

     public function __construct($extensions, $taille_maxi, $dossier, $finalUrl)
     {
          $this->extensions = $extensions;
          $this->taille_maxi = $taille_maxi;
          $this->dossier = $dossier;
          $this->finalUrl = $finalUrl;
     }

     public function upload($finalName, $file)
     {
          $extension = strtolower(substr(strrchr($file['name'], "."), 1));
          if (!in_array($extension, $this->extensions)) {
               $extension_name = $this->extensions[0];
               $_SESSION["displayError"] = "Vous devez uploader un fichier de type $extension_name";
               header("location:$this->finalUrl");
               die();
          }

          $taille = filesize($file['tmp_name']);
          if ($taille > $this->taille_maxi || $file["error"] == 2) {
               $_SESSION["displayError"] = 'Le fichier est trop gros...';
               header("location:$this->finalUrl");
               die();
          }


          if (move_uploaded_file($file['tmp_name'], $this->dossier . $finalName)) {
               $_SESSION["displayValid"] = "Upload effectué avec succès !";
          } else {
               $_SESSION["displayError"] =  'Echec de l\'upload !';
               header("location:$this->finalUrl");
               die();
          }
     }
}


class Download{
     public static function download_file()
     {
          $path = $_POST["path"];
          $salt = random_int(0, 100000000);
          $extension = substr(strrchr($path, "."), 1);
          $dest = "tmp/$salt.$extension";
          $to = "../$dest";
          $from = "../$path";
          copy($from, $to);
          echo $dest;
     }
}
