<?php
if (array_key_exists("mail", $_POST)) {
    include("includes/userManagement.php");
    Users::newUser();
} else {
?>
    <form method="post" action="index.php?page=Inscription">
        <input type="text" name="mail" placeholder="mail" required>
        <input type="password" name="mdp1" placeholder="Mot de passe" required>
        <input type="password" name="mdp2" placeholder="Réécrivez votre mot de passe" required>
        <input type="submit" value="Valider">
    </form>
<?php
}
