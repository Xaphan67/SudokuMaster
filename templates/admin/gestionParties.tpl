{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical">
    <h1>Liste des parties</h1>
    <section id="gestion_parties">
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
            <a href="administration" class="bouton boutonPrincipal boutonDefaut boutonAdmin">Retour</a>
        </div>
    </section>
</div>
{/block}