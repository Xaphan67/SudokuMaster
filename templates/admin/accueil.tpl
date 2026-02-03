{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical">
    <h1>Interface d'administration</h1>
    <section>
        <h2>Utilisateurs</h2>
        <p>Dans cette section, vous pouvez voir les derniers utilisaturs inscrits, et gérer tous vos utilisateurs</p>
        <h3>Les 5 derniers utilisateurs inscrits :</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Administrateur</th>
                <th>Actions</th>
            </tr>
            {foreach from=$utilisateurs item=utilisateur}
            <tr>
                <td>{$utilisateur.Id_utilisateur}</td>
                <td>{$utilisateur.pseudo_utilisateur}</td>
                <td>{$utilisateur.email_utilisateur}</td>
                <td>{$utilisateur.id_role == 1 ? "Oui" : "Non"}</td>
                <td><div class="bouton boutonPrincipal boutonProfil">Infos</div><div class="bouton boutonPrincipal boutonProfil">Supprimer</div></td>
            </tr>
            {/foreach}
        </table>
        <a href="gestionUtilisateurs" class="bouton boutonPrincipal boutonDefaut">Gérer les utilisateurs</a>
    </section>
    <section>
        <h2>Parties</h2>
        <p>Dans cette section, vous pouvez voir les dernières parties ayant étées jouées dans tous les modes de jeu</p>
        <h3>Les 5 dernières parties :</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Mode de jeu</th>
                <th>Difficulté</th>
                <th>Durée</th>
                <th>Joueur 1</th>
                <th>Joueur 2</th>
            </tr>
            {foreach from=$parties item=partie}
            <tr>
                <td>{$partie.id_partie}</td>
                <td>{$partie.libelle_mode_de_jeu}</td>
                <td>{$partie.libelle_difficulte}</td>
                <td>{$partie.duree_partie}</td>
                <td>{$partie.pseudo_utilisateur}{if $partie.gagnant}<img src="assets/img/TropheeOr" alt="">{/if}</td>
                <td>{$partie.pseudo_utilisateur_2}{if $partie.gagnant_2}<img src="assets/img/TropheeOr" alt="">{/if}</td>
            </tr>
            {/foreach}
        </table>
        <a href="gestionParties" class="bouton boutonPrincipal boutonDefaut">Voir les parties</a>
    </section>
</div>
{{/block}}