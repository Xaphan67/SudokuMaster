<main>
    <div id="conteneur_principal">
        <img src="view/assets/img/Grille.webp" alt="">
        <section class="formulaire">
            <img src="view/assets/img/SudokuMaster.png" alt="">
            <h1>Connexion au compte</h1>
            <form method="post">
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
                <?php if (isset($erreurs["identifiants"])) { echo '<p>' . $erreurs["identifiants"] . '</p>'; } ?>
                <input type="submit" class="bouton boutonPrincipal boutonDefaut" value="Se connecter" />
            </form>
            <hr />
            <a href="index.php?controller=utilisateur&action=signUp">Créer un compte Sudoku Master gratuit</a>
            <a href="#">Vous avez oublié votre mot de passe ?</a>
        </section>
    </div>
</main>