# Site de la course Bordeaux-Polytechnique: 
Ce site a pour but de donner toutes les informations nécessaires aux participants de la course. Il a été conçu pour être facilement modifiable et réutilisable d'une année sur l'autre.

Le site est en ligne et accessible à l'adresse https://BX.binets.fr

## Organisation fonctionnelle du site
Il y a une seule page index.php et la navigation se fait au travers du paramètre page passé en méthode GET.

Les ressources génériques coté serveur sont regroupées dans les dossiers /includes et /classes.

Les libraires externes sont regroupées dans le dossier /lib. Il y a à la fois des librairies js et php. 

/img contient les médias.


## Utiliser le site

Pour avoir une installation locale fonctionnelle :

### Prérequis

Git
```sh
sudo apt-get install git
```

### Installation
 
Cloner le dossier
```sh
git clone https://github.com/pe712/Modal-WEB
```

### Configuration serveur
Il faut un serveur permettant d'exécuter un script php (apache ou nginx par exemple).

Il faut ensuite modifier le php.ini pour set 

    upload_max_filesize = 4M 
    max_file_uploads = 100

Cela permet d'upload sur le site toutes les traces GPX.

### Base de données
N'importe quelle base de données relationnelle convient. Pour setup la base de données il faut exécuter le code sql setup.sql présent dans ce répertoire.



## Contact

Lien du projet: [https://github.com/pe712/Modal-WEB](https://github.com/pe712/Modal-WEB)


## Fait avec

* 🐙 Github
* 💻 VS Code

