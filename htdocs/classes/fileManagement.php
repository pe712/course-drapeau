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
               $_SESSION["displayError"] = "Tu dois upload un fichier de type $extension_name";
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
          $user = Users::getUserPersonnalData();
          $filename = $user->certificat;
          if ($filename == null)
               echo "Tu n'as pas encore upload de certificat médical";
          else {
               $salt = random_int(0, 100000000000);
               $extension = substr(strrchr($filename, "."), 1);
               $dest = "tmp/$salt.$extension";
               $to = "../$dest";
               $from = "../pages/EspacePerso/upload/$filename";
               if (copy($from, $to))
                    echo $dest;
               else
                    echo "echec";
          }
     }

     /* 
     Il y a avait beaucoup plus simple :
     
     header('Content-type: application/gpx');
     header( "Content-Disposition: attachment; filename=le fichier.gpx" );
     header( 'Content-Transfer-Encoding: binary' );
     header('Content-Length: ' . filesize($path));
     header( 'Cache-Control: public' );
     header( 'Content-Description: File Transfer' );

     // Read the file
     @readfile($path);
     
     */
}
