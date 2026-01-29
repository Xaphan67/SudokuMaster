{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="horizontal">
    <img src="assets/img/Grille.webp" alt="">
    <section class="formulaire">
        <img class="logo" src="assets/img/SudokuMaster.png" alt="">
        <h1>Connexion au compte</h1>
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
            {if $erreurs["identifiants"]|isset}<p>{$erreurs["identifiants"]}</p>{/if}
            <input type="submit" class="bouton boutonPrincipal boutonDefaut" value="Se connecter" />
        </form>
        <hr />
        <a href="inscription">Créer un compte Sudoku Master gratuit</a>
        <a href="oubliMdp">Vous avez oublié votre mot de passe ?</a>
    </section>
</div>
{/block}