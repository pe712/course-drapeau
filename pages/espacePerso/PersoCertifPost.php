<?php

if (isset($_FILES['certificat'])) {
     $file = $_FILES['certificat'];
     $nomFichier = basename($file['name']);

     $extensions = array(".pdf", ".PDF");
     $extension = strrchr($file['name'], '.');
     if (!in_array($extension, $extensions)) {
          $_SESSION["displayError"] = 'Vous devez uploader un fichier de type pdf';
          header("location:index.php?page=EspacePerso");
          die();
     }

     $taille_maxi = 500000;
     $taille = filesize($file['tmp_name']);
     if ($taille > $taille_maxi || $file["error"] == 2) {
          $_SESSION["displayError"] = 'Le fichier est trop gros...';
          header("location:index.php?page=EspacePerso");
          die();
     }

     $nomFichier = strtr(
          $nomFichier,
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
     );
     $nomFichier = preg_replace('/([^.a-z0-9]+)/i', '-', $nomFichier);
     if (move_uploaded_file($file['tmp_name'], $dossier . $nomFichier)) {
          rename($dossier . $nomFichier, $dossier . "certificat medical $nom.pdf");
          $_SESSION["displayValid"] = 'Upload effectué avec succès !';
          header("location:index.php?page=EspacePerso");
          die();
     } else {
          $_SESSION["displayError"] =  'Echec de l\'upload !';
          header("location:index.php?page=EspacePerso");
          die();
     }
}
