
# Organisation fonctionnelle

## Organisation du projet

* \crons -> cronjob de nettoyage des fichiers temporaires
* \htdocs -> données à servir
* \docs -> documentation

## Organisation du site

* \ajax -> page où les requêtes ajax sont envoyées et traitées
* \classes -> regroupement de toutes les fonctions php utilisées
* \doc -> listes csv et xls (non utilisées actuellement)
* \lib et \vendor -> librairies
* \pages -> détail des pages servies
* \img -> médias
* \scripts -> fichiers javascript
* \styles -> fichier css

## Création des pages
Il y a un sous-dossier par page dans \pages. Chaque page est construit par un controller. Ils se trouvent dans \pages et s'appellent par example About.php.
Il s'agit d'instance de la classe `Page` telle que définie dans classes/pageManagement.php

Il y a une seule page index.php et la navigation se fait au travers du paramètre page passé en méthode `get`.
Le routing est fait par la `static function load` de la classe `PageListing`

Le contenu statique de la page se trouve dans le fichier qui s'appelle par exemple `AboutContent.php`

Vous pouvez mettre à jour ce routing notamment en utilisant un framework (symfony par exemple). L'organisation des pages à travers le paramètre `get` est à éviter.

## Authentification
Ce site utilise actuellement deux authentifications, pour les extés et pour les polytechniciens.
Le CAS du BR fonctionne de la manière suivante : 
* L'utilisateur est dirigé vers https://cas.binets.fr/login?service=https://course-drapeau.binets.fr/?page=Connect&renew=true
* Il se connecte
* L'utilisateur est redirigé vers https://course-drapeau.binets.fr/?page=Connect qui est une URL définie par le B
* Nous prenons alors le ticket de l'utilisateur en paramètre `get` et nous pouvons l'échanger contre ses informations personnelles.

N'hésitez pas à demander plus d'infos au BR

## Modification du contenu
Le projet du site était initiallement de faire un contenu modulable sans avoir à écrire de code. L'idée était de stocker les informations dans la base de donnée dans les tables `content` et `content_section` et de modifier ces informations depuis l'espace administration pour les utilisateurs enregistrés comme `root` dans la database. 

Ce projet n'a pas été mené jusqu'au bout. Par ailleurs il n'est pas vraiment intelligent car le site évolue beaucoup plus d'une année à l'autre que simplement une mise à jour de contenu. 

La modification du contenu du site se fait depuis l'onglet administration, accessible après connexion avec un login root. Si tu êtes le gestionnaire de la base de donnée, il est facile de créer un entrée avec `root=true` dans la base. Sinon il faut contacter votre prédécesseur pour qu'il tu passe les accès.
Il est possible de modifier le contenu de chaque item, d'en créer de nouveau ou de les supprimer, pareil pour chaque section. Dans le code php, chaque item peut être accédé directement sur la page voulue avec `$sections[num_section][num_item]` où `num_section>=1` et `num_item>=0`
Vous pouvez ajouter un lien dans le contenu. Comme tous les caractères spéciaux sont échappés, il faut utiliser une syntaxe particulière (je sépare par des "!"). Pour faire un lien vers https://google.com avec comme valeur "ici" j'écris par exemple dans mon item :
Vous pouvez visiter google !lien!https://google.com!ici! et je peux continuer mon texte.

## Template de page
Chaque page suit un modèle défini par son header `linksAndScripts.php`, une navbar `navbar.php`, son footer `footer.php`, et éventuellement un message d'alerte `Diplay.php` dans \pages\includes 

## Créer une nouvelle page
Pour créer une nouvelle page, il suffit de la placer dans le dossier \pages et de remplir le tableau du fichier pageManagement.php

## Documenter le projet
Il faut toujours bien documenter ce que vous faites dans le dossier /docs. Vous trouverez plus d'informations à propos de mkdocs utilisé pour créer la doc [ici]https://www.mkdocs.org/getting-started/#getting-started-with-mkdocs.

Il suffit de modifier le index.md et d'exécuter `mkdocs build`. Lors d'un commit, la documentation est automatiquement mise à jour.