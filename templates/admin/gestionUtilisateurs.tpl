{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical">
    <h1>Gestion des utilisateurs</h1>
    <section id="gestion_utilisateurs">
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
                                <path d="M128 82a46 46 0 1 0 46 46a46.06 46.06 0 0 0-46-46Zm0 80a34 34 0 1 1 34-34a34 34 0 0 1-34 34Zm86-31.16c.06-1.89.06-3.79 0-5.68L229.33 106a6 6 0 0 0 1.11-5.29a105.34 105.34 0 0 0-10.68-25.81a6 6 0 0 0-4.53-3l-24.45-2.71q-1.93-2.07-4-4l-2.72-24.46a6 6 0 0 0-3-4.53a105.65 105.65 0 0 0-25.77-10.66a6 6 0 0 0-5.29 1.14l-19.2 15.37a89.64 89.64 0 0 0-5.68 0L106 26.67a6 6 0 0 0-5.29-1.11A105.34 105.34 0 0 0 74.9 36.24a6 6 0 0 0-3 4.53l-2.67 24.45q-2.07 1.94-4 4L40.76 72a6 6 0 0 0-4.53 3a105.65 105.65 0 0 0-10.66 25.77a6 6 0 0 0 1.11 5.23l15.37 19.2a89.64 89.64 0 0 0 0 5.68l-15.38 19.17a6 6 0 0 0-1.11 5.29a105.34 105.34 0 0 0 10.68 25.76a6 6 0 0 0 4.53 3l24.45 2.71q1.94 2.07 4 4L72 215.24a6 6 0 0 0 3 4.53a105.65 105.65 0 0 0 25.77 10.66a6 6 0 0 0 5.29-1.11l19.1-15.32c1.89.06 3.79.06 5.68 0l19.21 15.38a6 6 0 0 0 3.75 1.31a6.2 6.2 0 0 0 1.54-.2a105.34 105.34 0 0 0 25.76-10.68a6 6 0 0 0 3-4.53l2.71-24.45q2.07-1.93 4-4l24.46-2.72a6 6 0 0 0 4.53-3a105.49 105.49 0 0 0 10.66-25.77a6 6 0 0 0-1.11-5.29Zm-3.1 41.63l-23.64 2.63a6 6 0 0 0-3.82 2a75.14 75.14 0 0 1-6.31 6.31a6 6 0 0 0-2 3.82l-2.63 23.63a94.28 94.28 0 0 1-17.36 7.14l-18.57-14.86a6 6 0 0 0-3.75-1.31h-.36a78.07 78.07 0 0 1-8.92 0a6 6 0 0 0-4.11 1.3L100.87 218a94.13 94.13 0 0 1-17.34-7.17l-2.63-23.62a6 6 0 0 0-2-3.82a75.14 75.14 0 0 1-6.31-6.31a6 6 0 0 0-3.82-2l-23.63-2.63A94.28 94.28 0 0 1 38 155.14l14.86-18.57a6 6 0 0 0 1.3-4.11a78.07 78.07 0 0 1 0-8.92a6 6 0 0 0-1.3-4.11L38 100.87a94.13 94.13 0 0 1 7.17-17.34l23.62-2.63a6 6 0 0 0 3.82-2a75.14 75.14 0 0 1 6.31-6.31a6 6 0 0 0 2-3.82l2.63-23.63A94.28 94.28 0 0 1 100.86 38l18.57 14.86a6 6 0 0 0 4.11 1.3a78.07 78.07 0 0 1 8.92 0a6 6 0 0 0 4.11-1.3L155.13 38a94.13 94.13 0 0 1 17.34 7.17l2.63 23.64a6 6 0 0 0 2 3.82a75.14 75.14 0 0 1 6.31 6.31a6 6 0 0 0 3.82 2l23.63 2.63a94.28 94.28 0 0 1 7.14 17.29l-14.86 18.57a6 6 0 0 0-1.3 4.11a78.07 78.07 0 0 1 0 8.92a6 6 0 0 0 1.3 4.11L218 155.13a94.13 94.13 0 0 1-7.15 17.34Z"/>
                            </svg>
                        </div>
                        <div name="actions-{$utilisateur.Id_utilisateur}" class="actions">
                            <div name="bouton_infos-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonIcone bouton-info">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <path d="M142 176a6 6 0 0 1-6 6a14 14 0 0 1-14-14v-40a2 2 0 0 0-2-2a6 6 0 0 1 0-12a14 14 0 0 1 14 14v40a2 2 0 0 0 2 2a6 6 0 0 1 6 6Zm-18-82a10 10 0 1 0-10-10a10 10 0 0 0 10 10Zm106 34A102 102 0 1 1 128 26a102.12 102.12 0 0 1 102 102Zm-12 0a90 90 0 1 0-90 90a90.1 90.1 0 0 0 90-90Z"/>
                                </svg>
                            </div>
                            <div name="bouton_supprimer-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonIcone bouton-supprimer{$utilisateur.id_role == 1 ? " inactif" : ""}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <path d="M216 50h-42V40a22 22 0 0 0-22-22h-48a22 22 0 0 0-22 22v10H40a6 6 0 0 0 0 12h10v146a14 14 0 0 0 14 14h128a14 14 0 0 0 14-14V62h10a6 6 0 0 0 0-12ZM94 40a10 10 0 0 1 10-10h48a10 10 0 0 1 10 10v10H94Zm100 168a2 2 0 0 1-2 2H64a2 2 0 0 1-2-2V62h132Zm-84-104v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Zm48 0v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Z"/>
                                </svg>
                            </div>
                            <div name="bouton_fermer-{$utilisateur.Id_utilisateur}" class="bouton boutonPrincipal boutonIcone bouton-fermer">
                                <svg xmlns="http://www.w3.org/2000/svg"viewBox="0 0 256 256">
                                    <path d="M230 112a62.07 62.07 0 0 1-62 62H46.49l37.75 37.76a6 6 0 1 1-8.48 8.48l-48-48a6 6 0 0 1 0-8.48l48-48a6 6 0 0 1 8.48 8.48L46.49 162H168a50 50 0 0 0 0-100H80a6 6 0 0 1 0-12h88a62.07 62.07 0 0 1 62 62Z"/>
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
            <a href="administration" class="bouton boutonPrincipal boutonDefaut boutonAdmin">Retour</a>
        </div>
    </section>
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