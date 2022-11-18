<div class="centerer-container inscriptionForm">
    <form class="ms-4" method="post" action="?page=Inscription">
        <div class="mb-3">
            <label for="mail" class="form-label">Email</label>
            <input type="email" class="form-control" id="mail" aria-describedby="emailHelp" name="mail" placeholder="eric.labaye@polytechnique.edu" required>
            <div id="emailHelp" class="form-text">Nous ne transmettons pas tes données.</div>
        </div>
        <div class="mb-3">
            <label for="pwd1" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="pwd1" name="mdp1" required onkeyup="updateInscription()">
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
    <div class="inscriptionVerif">
        <div>Ton mot de passe doit contenir
            <ul>
                <li id="8c">Au moins 8 caractères</li>
                <li id="M">Au moins une majuscule</li>
                <li id="m">Au moins une minuscule</li>
                <li id="c">Au moins un chiffre</li>
                <li id="spec">Au moins un caractère spécial</li>
            </ul>
            <p>Tu veilleras à ne pas mettre un mot qui existe dans le dictionnaire comme mot de passe.</p>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="inscription-progress-bar">0%</div>
        </div>
    </div>
</div>