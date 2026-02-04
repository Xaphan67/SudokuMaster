{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical">
    <h1>Interface d'administration</h1>
    <div id="accueil_administration">
        <section>
            <h2>Utilisateurs</h2>
            <p>Dans cette section, vous pouvez voir les derniers utilisaturs inscrits, et gérer tous vos utilisateurs</p>
            <h3>Les 5 derniers utilisateurs inscrits :</h3>
            <table>
                <tbody>
                    {foreach from=$utilisateurs item=utilisateur}
                    <tr>
                        <td>
                            <span>{$utilisateur.pseudo_utilisateur}</span><br>
                            {$utilisateur.email_utilisateur}<br>
                            Admin : {$utilisateur.id_role == 1 ? "Oui" : "Non"}
                        </td>
                        <td class="administration_actions">
                            <div name="bouton_action-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonIcone boutonActions">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <path d="M238 100.68a13.94 13.94 0 0 0-4.1-9.9L165.21 22.1a14 14 0 0 0-19.8 0l-28.73 28.73l-58.46 21.93a14 14 0 0 0-8.9 10.8L26.08 223a6 6 0 0 0 5.92 7a6.61 6.61 0 0 0 1-.08l139.44-23.24a14 14 0 0 0 10.81-8.9l21.92-58.46l28.74-28.74a13.92 13.92 0 0 0 4.09-9.9Zm-66 92.89a2 2 0 0 1-1.54 1.27L49.49 215l52.87-52.88a26 26 0 1 0-8.48-8.48L41 206.53l20.17-121A2 2 0 0 1 62.43 84l56.06-21L193 137.51ZM102 140a14 14 0 1 1 14 14a14 14 0 0 1-14-14Zm123.41-37.9L200 127.51L128.48 56l25.42-25.42a2 2 0 0 1 2.83 0l68.68 68.69a2 2 0 0 1 0 2.83Z"/>
                                </svg>
                            </div>
                            <div name="actions-{$utilisateur.Id_utilisateur}" class="actions">
                                <div class="bouton boutonPrincipal boutonIcone">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <path d="M238 100.68a13.94 13.94 0 0 0-4.1-9.9L165.21 22.1a14 14 0 0 0-19.8 0l-28.73 28.73l-58.46 21.93a14 14 0 0 0-8.9 10.8L26.08 223a6 6 0 0 0 5.92 7a6.61 6.61 0 0 0 1-.08l139.44-23.24a14 14 0 0 0 10.81-8.9l21.92-58.46l28.74-28.74a13.92 13.92 0 0 0 4.09-9.9Zm-66 92.89a2 2 0 0 1-1.54 1.27L49.49 215l52.87-52.88a26 26 0 1 0-8.48-8.48L41 206.53l20.17-121A2 2 0 0 1 62.43 84l56.06-21L193 137.51ZM102 140a14 14 0 1 1 14 14a14 14 0 0 1-14-14Zm123.41-37.9L200 127.51L128.48 56l25.42-25.42a2 2 0 0 1 2.83 0l68.68 68.69a2 2 0 0 1 0 2.83Z"/>
                                    </svg>
                                </div>
                                <div name="bouton_supprimer-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonIcone bouton-supprimer{$utilisateur.id_role == 1 ? " inactif" : ""}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <path d="M216 50h-42V40a22 22 0 0 0-22-22h-48a22 22 0 0 0-22 22v10H40a6 6 0 0 0 0 12h10v146a14 14 0 0 0 14 14h128a14 14 0 0 0 14-14V62h10a6 6 0 0 0 0-12ZM94 40a10 10 0 0 1 10-10h48a10 10 0 0 1 10 10v10H94Zm100 168a2 2 0 0 1-2 2H64a2 2 0 0 1-2-2V62h132Zm-84-104v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Zm48 0v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Z"/>
                                    </svg>
                                </div>
                                <div name="bouton_fermer-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonIcone bouton-fermer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <path d="M216 50h-42V40a22 22 0 0 0-22-22h-48a22 22 0 0 0-22 22v10H40a6 6 0 0 0 0 12h10v146a14 14 0 0 0 14 14h128a14 14 0 0 0 14-14V62h10a6 6 0 0 0 0-12ZM94 40a10 10 0 0 1 10-10h48a10 10 0 0 1 10 10v10H94Zm100 168a2 2 0 0 1-2 2H64a2 2 0 0 1-2-2V62h132Zm-84-104v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Zm48 0v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Z"/>
                                    </svg>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <table id="utilisateurs">
                <tbody>
                    <tr>
                        <th class="id">ID</th>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Actions</th>
                    </tr>
                    {foreach from=$utilisateurs item=utilisateur}
                    <tr>
                        <td>{$utilisateur.Id_utilisateur}</td>
                        <td>{$utilisateur.pseudo_utilisateur}</td>
                        <td>{$utilisateur.email_utilisateur}</td>
                        <td>{$utilisateur.id_role == 1 ? "Oui" : "Non"}</td>
                        <td class="administration_actions_large"><div class="bouton boutonPrincipal boutonProfil">Infos</div><div name="bouton_supprimer-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonProfil bouton-supprimer{$utilisateur.id_role == 1 ? " inactif" : ""}">Supprimer</div></td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <div>
                <a href="gestionUtilisateurs" class="bouton boutonPrincipal boutonDefaut boutonAdmin">Gérer les utilisateurs</a>
            </div>
        </section>
        <section>
            <h2>Parties</h2>
            <p>Dans cette section, vous pouvez voir les dernières parties ayant étées jouées dans tous les modes de jeu</p>
            <h3>Les 5 dernières parties :</h3>
            <table>
                <tbody>
                    {foreach from=$parties item=partie}
                    <tr>
                        <td>
                            Type : {$partie.libelle_mode_de_jeu} - {$partie.libelle_difficulte}<br>
                            Durée : {$partie.duree_partie}<br>
                            <div>
                                Joueur(s) : 
                                <div class="joueurs">
                                    {if $partie.gagnant}<img src="assets/img/TropheeOr" alt="">{/if}{$partie.pseudo_utilisateur}
                                </div>
                                {if $partie.pseudo_utilisateur_2 != ""}
                                {$partie.libelle_mode_de_jeu == "Compétitif" ? "VS" : "-"} 
                                <div class="joueurs">
                                    {if $partie.gagnant_2}<img src="assets/img/TropheeOr" alt="">{/if}{$partie.pseudo_utilisateur_2}
                                </div>
                                {/if}
                            </div>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Mode de jeu</th>
                        <th>Difficulté</th>
                        <th>Durée</th>
                        <th>Joueur(s)</th>
                        <th>Gagnant(s)</th>
                    </tr>
                    {foreach from=$parties item=partie}
                    <tr>
                        <td>{$partie.id_partie}</td>
                        <td>{$partie.libelle_mode_de_jeu}</td>
                        <td>{$partie.libelle_difficulte}</td>
                        <td>{$partie.duree_partie}</td>
                        <td class="joueurs">
                            {$partie.pseudo_utilisateur}
                            {if $partie.pseudo_utilisateur_2 != ""}
                                -
                                {$partie.pseudo_utilisateur_2}
                            {/if}
                        </td>
                        <td>
                            {if $partie.gagnant}{$partie.pseudo_utilisateur}{else}-{/if}
                            {if $partie.pseudo_utilisateur_2 != ""}
                                -
                                {if $partie.gagnant_2}{$partie.pseudo_utilisateur_2}{/if}
                            {/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <div>
                <a href="gestionParties" class="bouton boutonPrincipal boutonDefaut boutonAdmin">Voir les parties</a>
            </div>
        </section>
    </div>
</div>
<div id="supprimer_utilisateur" class="popup"><!-- popup de suppression utilisateur -->
    <h3>Supprimer cet utilisateur ?</h3>
    <p>Cet utilisateur ne pourra plus se connecter et ses données seront annonymisées</p>
    <div id="bouton_supprimer" class="bouton boutonPrincipal boutonDefaut">Oui</div>
    <div id="bouton_annuler" class="bouton boutonPrincipal boutonDefaut">Non</div>
</div>
{{/block}}