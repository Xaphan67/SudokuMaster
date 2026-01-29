{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal"  class="horizontal{$emailEnvoye ? ' inactif" inert' : ""}"{$emailEnvoye ? " inert" : ""}>
    <img src="assets/img/Grille.webp" alt="">
    <section class="formulaire">
        <h1>Mot de passe oublié</h1>
        <p>Si vous avez oublié votre mot de passe, saisissez votre adresse mail pour recevoir un lien vous permettant de le réinitialiser</p>
        <form method="post">
            <div>
                <label for="email">Adresse mail</label>
                <input id="email"
                    name="email"
                    type="email"
                    placeholder="exemple@exemple.fr"
                    autocomplete="email"
                    {if $smarty.post.email|isset}value="{$smarty.post.email}"{/if}
                    required
                />
                {if $erreurs["email"]|isset}<p>{$erreurs["email"]}</p>{/if}
            </div>
            <input type="submit" class="bouton boutonPrincipal boutonDefaut" value="Réinitialiser le mot de passe" />
        </form>
    </section>
</div>
{if $emailEnvoye}
    <div id="mail_envoye" class="popup"><!-- popup mail envoyé -->
        <h3>Un lien vous à été envoyé</h3>
        <p>Merci de vérifier votre adresse mail, et de cliquer sur le lien qui vous à été envoyé pour réinitialiser votre mot de passe</p>
        <a href="index.php" class="bouton boutonPrincipal boutonLarge">Retour à l'accueil</a>
    </div>
{/if}
{/block}