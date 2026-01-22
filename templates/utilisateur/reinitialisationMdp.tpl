{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal"{!$tokenValide || $mdpReinitialise ? ' class="inactif" inert' : ""}>
    <img src="assets/img/Grille.webp" alt="">
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
                {if $erreurs["mdp"]|isset}<p>{$erreurs["mdp"]}</p>{/if}
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
                {if $erreurs["mdp_confirm"]|isset}<p>{$erreurs["mdp_confirm"]}</p>{/if}
            </div>
            <input type="hidden" name="token" value="{$token|escape}" />
            <input type="submit" class="bouton boutonPrincipal boutonDefaut" value="Réinitialiser le mot de passe" />
        </form>
    </section>
</div>
{if !$tokenValide}
    <div id="token_invalide" class="popup"><!-- popup token invalide -->
        <h3>Une erreur est survenue</h3>
        <p>Le lien que vous avez utilisé est invalide ou à expiré. Merci de faire une nouvelle demande.</p>
        <a href="index.php" class="bouton boutonPrincipal boutonLarge">Retour à l'accueil</a>
    </div>
{/if}
{if $mdpReinitialise}
    <div id="mdp_reinitialise" class="popup"><!-- popup mdp réinitialisé -->
        <h3>Mot de passe réinitialisé</h3>
        <p>Votre mot de passe à bien été réinitialisé. Vous pouvez désormais vous connecter avec votre nouveau mot de passe.</p>
        <a href="connexion" class="bouton boutonPrincipal boutonLarge">Se connecter</a>
    </div>
{/if}
{/block}