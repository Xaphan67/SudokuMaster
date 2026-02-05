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
                                <div name="bouton_infos-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonIcone bouton-info">
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
                        <td class="administration_actions_large"><div name="bouton_infos-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonProfil bouton-info">Infos</div><div name="bouton_supprimer-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonProfil bouton-supprimer{$utilisateur.id_role == 1 ? " inactif" : ""}">Supprimer</div></td>
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
                <a href="gestionParties" class="bouton boutonPrincipal boutonDefaut boutonAdmin{$parties|count == 0 ? " inactif" : ""}">Voir les parties</a>
            </div>
        </section>
    </div>
</div>
<div id="infos_utilisateur" class="popup"><!-- popup d'informations utilisateur -->
    <h3></h3>
    <p></p>
    <p></p>
    <h3>Historique</h3>
    <div>
        <p>Inscrit le </p>
    </div>
    <h3>Statistiques</h3>
    <div class="onglets onglets_classements onglets_popups">
        <p class="onglet_actif">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                <path d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z"/>
            </svg>
        </p>
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                <path d="M117.82 217.45A6 6 0 0 1 112 222a6.14 6.14 0 0 1-1.46-.18l-32-8a6.15 6.15 0 0 1-1.87-.83l-24-16a6 6 0 0 1 6.66-10l23.13 15.42l31 7.75a6 6 0 0 1 4.36 7.29Zm132.73-96.6a13.89 13.89 0 0 1-7 8.09l-24 12l-55.31 55.31A6 6 0 0 1 160 198a6.08 6.08 0 0 1-1.46-.18l-64-16a6 6 0 0 1-2-.94L36.9 141.16l-24.43-12.22a14 14 0 0 1-6.26-18.78l24.85-49.69a14 14 0 0 1 18.78-6.26L72.6 65.59l53.75-15.36a6 6 0 0 1 3.3 0l53.75 15.36l22.76-11.38a14 14 0 0 1 18.78 6.26l24.85 49.69a13.93 13.93 0 0 1 .76 10.69Zm-232.71-2.64L37.32 128L64 74.68l-19.53-9.74a2 2 0 0 0-2.68.9l-24.85 49.69a2 2 0 0 0-.1 1.52a1.92 1.92 0 0 0 1 1.16ZM191 152.49l-30.73-24.61c-19 16.38-43.58 18.8-63.8 5.88a14 14 0 0 1-2.39-21.71l45.72-44.36a6 6 0 0 1 2.35-1.4L128 62.24L76.19 77l-28.53 57.1l50.9 36.35l59.6 14.9Zm17.68-17.68L180.29 78h-33.86l-43.91 42.6a1.9 1.9 0 0 0-.51 1.55a2 2 0 0 0 .94 1.5c13.29 8.49 34.14 10.87 52.79-7.92a6 6 0 0 1 8-.45L199.56 144Zm30.36-19.28l-24.83-49.69a2 2 0 0 0-2.68-.9l-19.48 9.74L218.68 128l19.48-9.74a1.92 1.92 0 0 0 1-1.16a2 2 0 0 0-.1-1.57Z"/>
            </svg>
        </p>
        <p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                <path d="M216 34h-64a6 6 0 0 0-4.76 2.34l-65.39 85L70.6 110.1a14 14 0 0 0-19.8 0l-12.7 12.7a14 14 0 0 0 0 19.81L59.51 164L30.1 193.42a14 14 0 0 0 0 19.8l12.69 12.69a14 14 0 0 0 19.8 0L92 196.5l21.4 21.4a14 14 0 0 0 19.8 0l12.7-12.69a14 14 0 0 0 0-19.81l-11.25-11.25l85-65.39A6 6 0 0 0 222 104V40a6 6 0 0 0-6-6ZM54.1 217.42a2 2 0 0 1-2.83 0l-12.68-12.69a2 2 0 0 1 0-2.82L68 172.5L83.51 188Zm83.31-20.7l-12.69 12.7a2 2 0 0 1-2.84 0l-75.29-75.3a2 2 0 0 1 0-2.83l12.69-12.7a2 2 0 0 1 2.84 0l75.29 75.3a2 2 0 0 1 0 2.83ZM210 101.05l-83.91 64.55l-13.6-13.6l51.75-51.76a6 6 0 0 0-8.48-8.48L104 143.51l-13.6-13.6L155 46h55Z"/>
            </svg>
        </p>
    </div>
    <div id="mode_solo">
    </div>
    <div id="mode_cooperatif">
    </div>
    <div id="mode_competitif">
    </div>
    <div id="bouton_fermer" class="bouton boutonPrincipal boutonDefaut">Fermer</div>
</div>
<div id="supprimer_utilisateur" class="popup"><!-- popup de suppression utilisateur -->
    <h3>Supprimer cet utilisateur ?</h3>
    <p>Cet utilisateur ne pourra plus se connecter et ses données seront annonymisées</p>
    <div id="bouton_supprimer" class="bouton boutonPrincipal boutonDefaut">Oui</div>
    <div id="bouton_annuler" class="bouton boutonPrincipal boutonDefaut">Non</div>
</div>
{/block}