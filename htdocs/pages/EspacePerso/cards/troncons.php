<?php
require("pages/Troncons/colors.php");
$troncons = Users::getTroncons();
if ($troncons){
    $trinome_id = $troncons["trinome_id"];
    $color = $colors[$trinome_id-1];
    $troncons = implode(", ", $troncons["troncons"]);
    ?>
    <p class="espacePerso-firstLine">
    Vous faites parties du trinôme <span class="espacePerso-content-troncons-color" style="background-color:<?=$color?>"><?=$trinome_id?></span>. 
    <br>
    Vous courrez les troncons: <?=$troncons?>
    </p>
    <p>
        Vous pouvez voir le détail des troncons <a href="?page=Troncons">ici</a>
    </p>
<?php
}
else{
    echo '<p class="espacePerso-firstLine">Les troncons ne sont pas encore répartis ou alors tu ne fais pas encore partie d\'un trinôme</p>';
}
?>
    <button class="btn btn-primary" onclick="changeView('troncons', 'cards')">Retour</button>
