<?php
if (array_key_exists("mail", $_POST)) {
    include("includes/userManagement.php");
    Users::newUser();
} else {
?><div class="formContainer">
        <form class="ms-4" method="post" action="index.php?page=Inscription">
            <div class="mb-3">
                <label for="mail" class="form-label">Email</label>
                <input type="email" class="form-control" id="mail" aria-describedby="emailHelp" name="mail" placeholder="eric.labaye@polytechnique.edu" required>
                <div id="emailHelp" class="form-text">Nous ne transmettons pas vos données.</div>
            </div>
            <div class="mb-3">
                <label for="pwd1" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="pwd1" name="mdp1" required>
            </div>
            <div class="mb-3">
                <label for="pwd2" class="form-label">Réécrivez votre mot de passe</label>
                <input type="password" class="form-control" id="pwd2" name="mdp2" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="robotCheck" required>
                <label class="form-check-label" for="robotCheck">Je ne suis pas un robot</label>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

<?php
}
