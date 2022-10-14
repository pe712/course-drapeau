<?php
if (array_key_exists("mail", $_POST)) {
    echo 'ok';
    Users::connectUser();
} else {
?>
    <div class="formContainer">
        <form method="post" action="index.php?page=Connect">
            <div class="mb-3">
                <label for="mail" class="form-label">Email</label>
                <input type="email" class="form-control" id="mail" aria-describedby="emailHelp" name="mail" placeholder="eric.labaye@polytechnique.edu" required>
            </div>
            <div class="mb-3">
                <label for="pwd1" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="pwd1" name="mdp" required>
            </div>
            <button type="submit" class="btn btn-primary">Me connecter</button>
        </form>
    </div>
    <!-- <b><a href="reinitMdp.php">Mot de passe oublié?</a></b> -->
<?php
}
