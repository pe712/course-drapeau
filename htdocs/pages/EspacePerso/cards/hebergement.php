<?php
$baseurl = "https://www.google.fr/maps/place/";
$lieu1 = "1 rue d'Angoulême, 16600 Magnac-sur-Touvre ";
$url1 = $baseurl . urlencode($lieu1);
$lieu2 = "16 rue du Collège, 72150 Courdemanche ";
$url2 = $baseurl . urlencode($lieu2);
?>

<div class="onglet" id="hebergement">
    <p class="espacePerso-firstLine">
        Il y aura deux hébergements sur le parcours pour la totalité de la course:
    </p>
    <div class="espacePerso-content-hebergement">
        <div class="espacePerso-content-hebergement-intro">
            <b><?= $lieu1 ?></b>
            <a href="<?= $url1 ?>" target="_blank">voir sur la carte</a>
        </div>
        <div>
            M. et Mme Dezaunay qui nous acceuillent seront là, soyez respectueux.
            <br>
            On peut se garer sur un petit parking qui descend de l'autre côté du rond-point ou un peu plus loin sur le bas coté en terre.
            <br>
            Possibilité de faire du ping pong, d'aller dans le jardin, de faire des petits tours de canoë sur la rivière devant.
            <br>
            Attention ne pas aller pieds nus dans la rivière, il y a plein de verre au fond (et de toute façon elle est très froide).
        </div>
    </div>
    <div class="espacePerso-content-hebergement">
        <div class="espacePerso-content-hebergement-intro">
            <b><?= $lieu2 ?></b>
            <a href="<?= $url2 ?>" target="_blank">voir sur la carte</a>
        </div>
        <div>
            Il y a normalement de quoi se garer. Sinon on peut utiliser le jardin qui est en face.
            <br>
            Possibilité de faire un foot pas loin ou de se baigner dans un lac
        </div>
    </div>
    <br>
    <button class="btn btn-primary" onclick="changeView('hebergement', 'cards')">Retour</button>
</div>