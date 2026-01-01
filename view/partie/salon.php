<main>
    <div id="conteneur_principal" class="vertical">
        <h1>Multijoueur</h1>
        <p id="salon_instructions">Vous pouvez créer une salle et inviter un autre joueur à vous rejoindre, ou rejoindre une salle déja créée par un autre joueur en entrant son numéro de salle.</p>
        <div id="salon">
            <section>
                <h2>Créer une salle</h2>
                <form method="post">
                    <div>
                        <label for="mode">Mode de jeu</label>
                        <select name="mode" id="mode" required>
                            <option value="cooperatif">Coopératif</option>
                            <option value="competitif">Compétitif</option>
                        </select>
                    </div>
                    <div>
                        <label for="difficulte">Difficulté</label>
                        <select name="mode" id="mode" required>
                            <option value="facile">Facile</option>
                            <option value="moyen">Moyen</option>
                            <option value="difficile">Difficile</option>
                        </select>
                    </div>
                    <input type="submit" name="creer_salle" class="bouton boutonPrincipal boutonDefaut" value="Créer" />
                </form>
            </section>
            <section>
                <h2>Rejoindre une salle</h2>
                <form method="post">
                    <div>
                        <label for="salle">ID de la salle</label>
                        <input id="salle"
                            name="salle"
                            type="text"
                            placeholder="948561"
                            required
                        />
                        <?php if (isset($erreurs["salle"])) { echo '<p>' . $erreurs["salle"] . '</p>'; } ?>
                    </div>
                    <input type="submit" name="rejoindre_salle" class="bouton boutonPrincipal boutonDefaut" value="Rejoindre" />
                </form>
            </section>
        </div>
    </div>
</main>