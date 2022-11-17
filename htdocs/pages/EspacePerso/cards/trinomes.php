<?php
$user = Users::getUserPersonnalData();
if ($user->trinome_id == null) {
    echo "<p class=espacePerso-firstLine>Vous n'êtes pas encore affilié à un trinôme.</p>";
} else {
    $trinome = Users::getOtherMembersTrinome($user->trinome_id);
    echo "<p class=espacePerso-firstLine>Vous avez été attribué au trinôme $user->trinome_id avec :<ul>";
    while($courreur = $trinome->fetch()){
        echo "<li>$courreur->prenom $courreur->nom</li>";
    }
    echo "</ul></p>";
}
?>
<button class="btn btn-primary" onclick="changeView('trinomes', 'cards')">Retour</button>