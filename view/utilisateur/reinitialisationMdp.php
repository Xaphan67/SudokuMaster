<main>
    <div id="conteneur_principal"<?php echo (!$tokenValide || $mdpReinitialise ? ' class="inactif" inert' : "") ?>>
        <img src="view/assets/img/Grille.webp" alt="">
        <section class="formulaire">
            <h1>Réinitialisation de votre mot de passe</h1>
            <p>Merci de saisir un nouveau mot de passe pour votre compte</p>
            <form method="post">
                <div>
                    <label for="mdp">Mot de passe</label>
                    <input id="mdp"
                        name="mdp"
                        type="password"
                        placeholder="*********"
                        autocomplete="off"
                        required
                    />
                    <?php if (isset($erreurs["mdp"])) { echo '<p>' . $erreurs["mdp"] . '</p>'; } ?>
                </div>
                <div>
                    <label for="mdp_confirm">Confirmation du mot de passe</label>
                    <input id="mdp_confirm"
                        name="mdp_confirm"
                        type="password"
                        placeholder="*********"
                        autocomplete="off"
                        required
                    />
                    <?php if (isset($erreurs["mdp_confirm"])) { echo '<p>' . $erreurs["mdp_confirm"] . '</p>'; } ?>
                </div>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token) ?>" />
                <input type="submit" class="bouton boutonPrincipal boutonDefaut" value="Réinitialiser le mot de passe" />
            </form>
        </section>
    </div>
    <?php
        if (!$tokenValide) {
    ?>
        <div id="token_invalide" class="popup"><!-- popup token invalide -->
            <h3>Une erreur est survenue</h3>
            <p>Le lien que vous avez utilisé est invalide ou à expiré. Merci de faire une nouvelle demande.</p>
            <a href="index.php" class="bouton boutonPrincipal boutonLarge">Retour à l'accueil</a>
        </div>
    <?php
    }
    ?>
    <?php
        if ($mdpReinitialise) {
    ?>
        <div id="mdp_reinitialise" class="popup"><!-- popup mdp réinitialisé -->
            <h3>Mot de passe réinitialisé</h3>
            <p>Votre mot de passe à bien été réinitialisé. Vous pouvez désormais vous connecter avec votre nouveau mot de passe.</p>
            <a href="connexion" class="bouton boutonPrincipal boutonLarge">Se connecter</a>
        </div>
    <?php
    }
    ?>
</main>