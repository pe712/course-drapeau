<?php
$user = Users::getUserPersonnalData();
if ($user->trinome_id == null) {
    echo "<p class=espacePerso-firstLine>Vous n'êtes pas encore affilié à un trinôme. Vous pourrez choisir très prochainement.</p>";
} else {
    echo "<p class=espacePerso-firstLine>Vous avez déjà choisi votre trinôme, vous faites parties du trinôme $user->trinome_id</p>";
}
?>
<button class="btn btn-primary" onclick="changeView('trinomes', 'cards')">Retour</button>