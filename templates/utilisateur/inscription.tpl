{extends 'base.tpl'}

{block contenu}
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
                    {if $smarty.post.pseudo|isset}value="{$smarty.post.pseudo}"{/if}
                    required
                />
                {if $erreurs["pseudo"]|isset}<p>{$erreurs["pseudo"]}</p>{/if}
            </div>
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
            <input type="submit" class="bouton boutonPrincipal boutonDefaut" value="Créer mon compte" />
        </form>
    </section>
</div>
{{/block}}