<?php
if ($user->chauffeur)
  echo '<p class="espacePerso-firstLine">Vous n\'avez pas besoin de payer la course</p>';
// else
//   echo '<p class="espacePerso-firstLine">Le paiement sera ultérieur. De l\'ordre de 60€/pers</p>';
else if (!$user->paid) {
  $deb_msg = $sections[1][0];
  $cagnotte_lydia = filter_var($sections[1][1], FILTER_VALIDATE_URL);
  $msg = $sections[1][2];
  echo <<<FIN
  <p>
    $deb_msg <a href="$cagnotte_lydia" target="_blank" id="espacePerso-lienPaiement">$msg</a>
  </p>
  FIN;
  ?>
  <p id="espacePerso-messagePaiement">
    Quand nous aurons vérifié votre paiement, cet onglet sera mis à jour. Nous vérifions à la main, cela ne sera pas fait automatiquement.
  </p>
<?php } else {
?>
  <p class="espacePerso-firstLine">
    Vous avez déjà payé la course.
  </p>
<?php }
?>
<br>
<button class="btn btn-primary" onclick="changeView('payement', 'cards')">Retour</button>