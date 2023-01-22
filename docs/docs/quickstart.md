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
Il faut un serveur permettant d'exécuter un script php (apache ou nginx par exemple) avec une connexion sécurisée SSL. Sur windows regarder (XAMP ou WAMP) ou alors si vous savez utiliser docker ce peut être une option. Vous pouvez aussi sur windows regarder le WSL pour simuler un environnement unix.

Il faut ensuite modifier le php.ini pour set 

    upload_max_filesize = 4M 
    max_file_uploads = 100

Cela permet d'upload sur le site toutes les traces GPX.

Pour ce site, des librairies php on été utilisés et téléchargées à l'aide de composer. Il peut être utile de setup composer sur le serveur si jamais des mises à jour sont nécéssaires dans le futur.


### Base de données
N'importe quelle base de données relationnelle convient.
Vous trouverez [ici](https://pe712.github.io/course-Bordeaux-X/media/courseaudrapeau.sql) la database à un stade donné du projet (il est possible que cet exemple soit obsolète).

Pour configurer la base de donnée il faut créer un fichier config.php et le placer à la source du projet (à côté de htdocs). Il est ainsi accessible par les scripts php mais pas par l'utilisateur.

    <?php
    $db = "ma base de donnée";
    $host = "hébergeur de la database, par défaut localhost";
    $dsn = "mysql:dbname=$db; host=$host";
    $user = "mon username";
    $password = "mon mot de passe";
    ?>

### Crons
Il faut définir cronjob.sh comme cronjob sur le serveur
```sh
*/15 * * * * /hosting/www/courseaudrapeau/crons/cronjob.sh
```

### Par où commencer
Si vous n'avez pas d'idées, il y a un TODO.txt