<?php

if (isset($_FILES['certificat'])) {
     $file = $_FILES['certificat'];
     $nomFichier = basename($file['name']);

     $extensions = array(".pdf");
     $extension = strrchr($file['name'], '.');
     if (!in_array($extension, $extensions)) {
          $erreur = 'Vous devez uploader un fichier de type pdf';
     }

     $taille_maxi = 500000;
     $taille = filesize($file['tmp_name']);
     if ($taille > $taille_maxi || $file["error"] == 2) {
          $erreur = 'Le fichier est trop gros...';
     }

     if (!isset($erreur)) {
          $nomFichier = strtr(
               $nomFichier,
               'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
               'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
          );
          $nomFichier = preg_replace('/([^.a-z0-9]+)/i', '-', $nomFichier);
          if (move_uploaded_file($file['tmp_name'], $dossier . $nomFichier)) {
               rename($dossier . $nomFichier, $dossier . "certificat medical $nom");
               echo 'Upload effectué avec succès !';
          } else
               echo 'Echec de l\'upload !';
     } else {
          echo $erreur;
     }
}
