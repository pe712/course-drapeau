<div class="centerer-container">
    <div id="connect-choice"><button class="btn btn-primary connect-btn" onclick="callCASUrl()">
            Je suis un X
        </button>
        <br><br>
        <button class="btn btn-primary connect-btn" id="connect-btn-exte">
            Je suis un extérieur
        </button>
    </div>

    <div id="connect-form">
        <form method="post" action="?page=Connect">
            <div class="mb-3">
                <label for="mail" class="form-label">Email</label>
                <input type="email" class="form-control" id="mail" name="mail" placeholder="eric.labaye@polytechnique.edu" required>
            </div>
            <div class="mb-3">
                <label for="pwd1" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="pwd1" name="mdp" required>
            </div>
            <button type="submit" class="btn btn-primary">Me connecter</button><br>
            <a href="?page=Inscription">Je n'ai pas encore de compte</a>
        </form>
    </div>
</div>
<!-- <b><a href="reinitMdp.php">Mot de passe oublié?</a></b> -->