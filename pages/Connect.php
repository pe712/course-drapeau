<?php
if (array_key_exists("mail", $_POST)) {
    require("includes/userManagement.php");
    Users::connectUser();
} else {
?>
    <form class="ms-4">
        <div class="mb-3" method="post" action="index.php?page=Connect">
            <label for="mail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="mail" aria-describedby="emailHelp" name="mail" placeholder="eric.labaye@polytechnique.edu" required>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="pwd1" class="form-label">Password</label>
            <input type="password" class="form-control" id="pwd1" required>
        </div>
        <button type="submit" class="btn btn-primary">Me connecter</button>
    </form>

    <!-- <b><a href="reinitMdp.php">Mot de passe oublié?</a></b> -->
<?php
}
