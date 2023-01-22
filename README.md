# Site de la course Bordeaux-Polytechnique : 
Ce site a pour but de donner toutes les informations nécessaires aux participants de la course. Il a été conçu pour être facilement modifiable et réutilisable d'une année sur l'autre.

Le site est en ligne et accessible à l'adresse https://course-drapeau.binets.fr

## Organisation fonctionnelle du site
Il y a une seule page index.php et la navigation se fait au travers du paramètre page passé en méthode GET.

Les ressources génériques coté serveur sont regroupées dans les dossiers /includes et /classes.

Les libraires externes sont regroupées dans le dossier /lib. Il y a à la fois des librairies js et php. 

/img contient les médias.

La modification du contenu du site se fait depuis l'onglet administration, accessible après connexion avec un login root. Si tu êtes le gestionnaire de la base de donnée, il est facile de créer un login root dans la base. Sinon il faut contacter votre prédécesseur pour qu'il tu passe les accès.
Il est possible de modifier le contenu de chaque item, d'en créer de nouveau ou de les supprimer, pareil pour chaque section. Dans le code php, chaque item peut être accédé directement sur la page voulue avec $sections[num_section][num_item] où num_section>=1 et num_item>=0
Vous pouvez ajouter un lien dans le contenu. Comme tous les caractères spéciaux sont échappés, il faut utiliser une syntaxe particulière. Pour faire un lien vers https://google.com avec comme valeur "ici" j'écris par exemple dans mon item (je sépare par des "!"):
Vous pouvez visiter google !lien!https://google.com!ici! et je peux continuer mon texte.
Pour faire un lien plus évolué avec des attributs, je demande uniquement l'url à l'utilisateur et j'utilise filter_var($url, FILTER_VALIDATE_URL) [voir le lien de la cagnotte lydia dans pages/EspacePerso]

Pour créer une nouvelle page, il suffit de la placer dans le dossier pages et de remplir le tableau du fichier pageManagement


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
Il faut définir un cronjob.sh comme cronjob sur le serveur

## Contact

pierre-emmanuel.baviere@polytechnique.edu

