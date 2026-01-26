{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical {nocache}{!$utilisateurConnecte ? 'inactif" inert' : ""}{/nocache}">
    <h1>Multijoueur</h1>
    <p id="salon_instructions">Vous pouvez créer une salle et inviter un autre joueur à vous rejoindre, ou rejoindre une salle déja créée par un autre joueur en entrant son numéro de salle.</p>
    <div id="salon">
        <section>
            <h2>Créer une salle</h2>
            <form method="post" action ="multijoueur">
                <div>
                    <label for="mode">Mode de jeu</label>
                    <select name="mode" id="mode" required>
                        <option value="cooperatif">Coopératif</option>
                        <option value="competitif">Compétitif</option>
                    </select>
                </div>
                <div>
                    <label for="difficulte">Difficulté</label>
                    <select name="difficulte" id="difficulte" required>
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
            <form method="post" action ="multijoueur">
                <div>
                    <label for="salle">ID de la salle</label>
                    <input id="salle"
                        name="salle"
                        type="text"
                        placeholder="948561"
                        value="{$smarty.session.saisie.salle|isset ? $smarty.session.saisie.salle : ""}"
                        required
                    />
                    {if $erreurs["salle"]|isset}<p>{$erreurs["salle"]}</p>{/if}
                </div>
                <input type="submit" name="rejoindre_salle" class="bouton boutonPrincipal boutonDefaut" value="Rejoindre" />
            </form>
        </section>
    </div>
    <section id="salles">
        <h2>Salles disponibles</h2>
        <div class="chargement-petit"></div>
        <div class="message_salles">
            <p>Impossible d'obtenir la liste des salles publiques</p>
            <div class="bouton boutonPrincipal boutonLarge">Réessayer</div>
        </div>
    </section>
</div>
{nocache}{if !$utilisateurConnecte}
    <div id="compte_requis" class="popup"><!-- popup si non connecté -->
        <h3>Compte requis</h3>
        <p>Pour jouer en multijoueur, vous devez vous connecter avec votre compte</p>
        <p>Vous n'avez pas de compte ? Créez-en un facilement en cliquant sur le bouton çi-dessous</p>
        <a href="inscription" class="bouton boutonPrincipal boutonLarge">Créer un compte</a>
        <a href="connexion&from=salon" class="bouton boutonPrincipal boutonLarge">Se connecter</a>
    </div>
{/if}{/nocache}
{/block}