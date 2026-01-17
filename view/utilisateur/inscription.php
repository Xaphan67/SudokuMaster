<main>
    <div id="conteneur_principal">
        <img src="view/assets/img/Grille.webp" alt="">
        <section class="formulaire">
            <h1>Créer un compte</h1>
            <form method="post">
                <div>
                    <label for="pseudo">Pseudo</label>
                    <input id="pseudo"
                        name="pseudo"
                        type="text"
                        placeholder="Pseudo..."
                        autocomplete="username"
                        <?php if (isset($_POST["pseudo"])) { echo 'value="' . $_POST["pseudo"] . '"'; } ?>
                        required
                    />
                    <?php if (isset($erreurs["pseudo"])) { echo '<p>' . $erreurs["pseudo"] . '</p>'; } ?>
                </div>
                <div>
                    <label for="email">Adresse mail</label>
                    <input id="email"
                        name="email"
                        type="email"
                        placeholder="exemple@exemple.fr"
                        autocomplete="email"
                        <?php if (isset($_POST["email"])) { echo 'value="' . $_POST["email"] . '"'; } ?>
                        required
                    />
                    <?php if (isset($erreurs["email"])) { echo '<p>' . $erreurs["email"] . '</p>'; } ?>
                </div>
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
                <input type="submit" class="bouton boutonPrincipal boutonDefaut" value="Créer mon compte" />
            </form>
        </section>
    </div>
</main>