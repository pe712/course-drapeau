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

Pour ce site, des librairies php on été utilisés et téléchargées à l'aide de composer. Il peut être utile de setup composer sur le serveur si jamais des mises à jour sont nécéssaires dans le futur.

Mettre en place la connexion sécurisée SSL.

### Base de données
N'importe quelle base de données relationnelle convient. Il faut modifier les données de config.php en conséquence

### Crons
Il faut définir cronjob.sh comme cronjob sur le serveur