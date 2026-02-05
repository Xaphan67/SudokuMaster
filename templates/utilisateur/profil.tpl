{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical">
    <h1>Profil</h1>
    <section id="infos_compte">
        <div>
            <div>
                <p>Pseudo :</p>
                <p>Adresse mail :</p>
                <p>Mot de passe :</p>
            </div>
            <div>
                {nocache}
                <p>{$smarty.session.utilisateur.pseudo_utilisateur}</p>
                <p>{$smarty.session.utilisateur.email_utilisateur}</p>
                {/nocache}
                <p>*********</p>
            </div>
        </div>
        <div>
            {nocache}
            <p>Pseudo</p>
            <p>{$smarty.session.utilisateur.pseudo_utilisateur}</p>
            <p>Adresse mail</p>
            <p>{$smarty.session.utilisateur.email_utilisateur}</p>
            {/nocache}
            <p>Mot de passe</p>
            <p>*********</p>
        </div>
        <div>
            <div id="bouton_modifier" class="bouton boutonPrincipal boutonProfil">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                    <path d="M238 100.68a13.94 13.94 0 0 0-4.1-9.9L165.21 22.1a14 14 0 0 0-19.8 0l-28.73 28.73l-58.46 21.93a14 14 0 0 0-8.9 10.8L26.08 223a6 6 0 0 0 5.92 7a6.61 6.61 0 0 0 1-.08l139.44-23.24a14 14 0 0 0 10.81-8.9l21.92-58.46l28.74-28.74a13.92 13.92 0 0 0 4.09-9.9Zm-66 92.89a2 2 0 0 1-1.54 1.27L49.49 215l52.87-52.88a26 26 0 1 0-8.48-8.48L41 206.53l20.17-121A2 2 0 0 1 62.43 84l56.06-21L193 137.51ZM102 140a14 14 0 1 1 14 14a14 14 0 0 1-14-14Zm123.41-37.9L200 127.51L128.48 56l25.42-25.42a2 2 0 0 1 2.83 0l68.68 68.69a2 2 0 0 1 0 2.83Z"/>
                </svg>
                <p>Modifier</p>
            </div>
            <div id="bouton_supprimer" class="bouton boutonPrincipal boutonProfil">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                    <path d="M216 50h-42V40a22 22 0 0 0-22-22h-48a22 22 0 0 0-22 22v10H40a6 6 0 0 0 0 12h10v146a14 14 0 0 0 14 14h128a14 14 0 0 0 14-14V62h10a6 6 0 0 0 0-12ZM94 40a10 10 0 0 1 10-10h48a10 10 0 0 1 10 10v10H94Zm100 168a2 2 0 0 1-2 2H64a2 2 0 0 1-2-2V62h132Zm-84-104v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Zm48 0v64a6 6 0 0 1-12 0v-64a6 6 0 0 1 12 0Z"/>
                </svg>
                <p>Supprimer</p>
            </div>
        </div>
    </section>
    <section id="statistiques">
        <h2>Statistiques Personnelles</h2>
        <div class="onglets onglets_stats">
            <p class="onglet_actif">Solo</p>
            <p>Coopératif</p>
            <p>Compétitif</p>
        </div>
        {for $mode = 1 to 3}
            <div id="statistiques_{$mode == 1 ? "solo" : ($mode == 2 ? "cooperatif" : "competitif")}" class="statistiques">
                <h3>Score global</h3>
                <p class="score_principal score_large">{$statistiques[$mode]|isset ? $statistiques[$mode]->getScore_global() : "1000"}</p>
                <div class="statistiques_mode">
                    <div>
                        <p>Grilles jouées</p>
                        <p>{$statistiques[$mode]|isset ? $statistiques[$mode]->getGrilles_jouees() : "0"}</p>
                    </div>
                    <div>
                        <p>Grilles résolues</p>
                        <p>{$statistiques[$mode]|isset ? $statistiques[$mode]->getGrilles_resolues() : "0"}</p>
                    </div>
                    <div>
                        <p>Temps moyen</p>
                        <p>{$statistiques[$mode]|isset ? $statistiques[$mode]->getTemps_moyen() : "00:00"}</p>
                    </div>
                    <div>
                        <p>Meilleur temps</p>
                        <p>{$statistiques[$mode]|isset ? $statistiques[$mode]->getMeilleur_temps() : "00:00"}</p>
                    </div>
                    <div>
                        <p>Série de victoires</p>
                        <p>{$statistiques[$mode]|isset ? $statistiques[$mode]->getSerie_victoires() : "0"}</p>
                    </div>
                </div>
                <h3>Dernières parties jouées</h3>
                <div class="dernieres_parties_mobile">
                    {if $participationsModes[$mode] != 0}
                        {$num = 0}
                        {foreach from=$participations item=participation}
                            {if $participation.id_mode_de_jeu == $mode}
                                {if $num < 5}
                                    <p>Partie jouée le {$participation.date_partie|date_format:"%d/%m/%Y"}</p>
                                    <div>
                                        <div>
                                            <p>Temps</p>
                                            <p>{$participation.duree_partie}</p>
                                        </div>
                                        <div>
                                            <p>Difficulté</p>
                                            <p>{$participation.id_difficulte == 1 ? "Facile" : ($participation.id_difficulte == 2 ? "Moyen" : "Difficile")}</p>
                                        </div>
                                        <div>
                                            <p>Score</p>
                                            <p class="{$participation.score > 0 ? "victoire" : "defaite"}">{$participation.score > 0 ? "+" : ""}{$participation.score}</p>
                                        </div>
                                    </div>
                                {/if}
                                {$num = $num + 1}
                            {/if}
                        {/foreach}
                    {else}
                        <div class="aucune_partie">
                            <p>Aucune partie jouée</p>
                        </div>
                    {/if}
                </div>
                <div class="dernieres_parties">
                    {if $participationsModes[$mode] != 0}
                        <div>
                            <p>Date</p>
                            <p>Temps</p>
                            <p>Difficulté</p>
                            <p>Résultat</p>
                            <p>Score</p>
                        </div>
                        {$num = 0}
                        {foreach from=$participations item=participation}
                            {if $participation.id_mode_de_jeu == $mode}
                                {if $num < 5}
                                    <div>
                                    <p>{$participation.date_partie|date_format:"%d/%m/%Y"}</p>
                                    <p>{$participation.duree_partie}</p>
                                    <p>{$participation.id_difficulte == 1 ? "Facile" : ($participation.id_difficulte == 2 ? "Moyen" : "Difficile")}</p>
                                    <p>{$participation.gagnant ? "Victoire" : "Défaite"}</p>
                                    <p class="{$participation.score > 0 ? "victoire" : "defaite"}">{$participation.score > 0 ? "+" : ""}{$participation.score}</p>
                                    </div>
                                {/if}
                                {$num = $num + 1}
                            {/if}
                        {/foreach}
                    {else}
                        <div class="aucune_partie">
                            <p>Aucune partie jouée</p>
                        </div>
                    {/if}
                </div>
            </div>
        {/for}
    </section>
</div>
<div id="modifier_compte" class="popup popup_large"> <!-- popup modification des données du compte -->
    <h3>Modifier vos informations personelles</h3>
    <p>Remplissez le formulaire pour mettre à jour vos informations de compte</p>
    <p>
        Les champs de mot de passe peuvent rester vide<br>
        si vous ne souhaitez pas le modifier
    </p>
    <form method="post">
        <div class="champs_doubles">
            <div>
                <div>
                    <label for="pseudo">Pseudo</label>
                    <input id="pseudo"
                        name="pseudo"
                        type="text"
                        placeholder="{$smarty.session.utilisateur.pseudo_utilisateur}"
                        autocomplete="username"
                        {nocache}
                        value="{$pseudoSaisi|isset ? $pseudoSaisi : $smarty.session.utilisateur.pseudo_utilisateur}"
                        {/nocache}
                        required
                    />
                    {if $erreurs["pseudo"]|isset}<p class="erreur">{$erreurs["pseudo"]}</p>{/if}
                </div>
                <div>
                    <label for="email">Adresse mail</label>
                    <input id="email"
                        name="email"
                        type="email"
                        placeholder="{$smarty.session.utilisateur.email_utilisateur}"
                        autocomplete="email"
                        {nocache}
                        value="{$pseudoSaisi|isset ? $emailSaisi : $smarty.session.utilisateur.email_utilisateur}"
                        {/nocache}
                        required
                    />
                    {if $erreurs["email"]|isset}<p class="erreur">{$erreurs["email"]}</p>{/if}
                </div>
            </div>
            <div>
                <div>
                    <label for="mdp">Mot de passe</label>
                    <input id="mdp"
                        name="mdp"
                        type="password"
                        placeholder="*********"
                        autocomplete="off"
                    />
                    {if $erreurs["mdp"]|isset}<p class="erreur">{$erreurs["mdp"]}</p>{/if}
                </div>
                <div>
                    <label for="mdp_confirm">Confirmation du mot de passe</label>
                    <input id="mdp_confirm"
                        name="mdp_confirm"
                        type="password"
                        placeholder="*********"
                        autocomplete="off"
                    />
                    {if $erreurs["mdp_confirm"]|isset}<p class="erreur">{$erreurs["mdp_confirm"]}</p>{/if}
                </div>
            </div>
        </div>
        <p>Saisissez votre mot de passe actuel pour confirmer les changements</p>
        <div>
            <label for="modifier_compte_mdp_check">Mot de passe actuel</label>
            <input id="modifier_compte_mdp_check"
                name="mdp_check"
                type="password"
                placeholder="*********"
                autocomplete="off"
                required
            />
            {if $erreurs["mdp_check"]|isset}<p class="erreur">{$erreurs["mdp_check"]}</p>{/if}
        </div>
        <div class="actions-formulaire">
            <input type="submit" name="modifier_compte" class="bouton boutonPrincipal boutonDefaut" value="Modifier" />
            <div id="bouton_annuler_modifier" class="bouton boutonPrincipal boutonDefaut">Annuler</div>
        </div>
    </form>
</div>
<div id="supprimer_compte" class="popup"> <!-- popup supression du compte -->
    <h3>Supprimer votre compte</h3>
    <p>
        Vous êtes sur le point de supprimer votre compte.<br>
        Cette action est irreversible !
    </p>
    <p>Confirmez la supression</br> en entrant votre mot de passe</p>
    <form method="post">
        <div>
            <label for="supprimer_compte_mdp_check">Mot de passe actuel</label>
            <input id="supprimer_compte_mdp_check"
                name="mdp_check"
                type="password"
                placeholder="*********"
                autocomplete="off"
                required
            />
            {if $erreurs["mdp_check"]|isset}<p class="erreur">{$erreurs["mdp_check"]}</p>{/if}
        </div>
        <div class="actions-formulaire">
            <input type="submit" name="supprimer_compte" class="bouton boutonPrincipal boutonDefaut" value="Supprimer" />
            <div id="bouton_annuler_supprimer" class="bouton boutonPrincipal boutonDefaut">Annuler</div>
        </div>
    </form>
</div>
<!-- Récupère le formulaire qui possède des erreurs pour être utilisé en JS et afficher immédiatement le popup correspondant -->
<input type="hidden" id="erreurs" value="{$erreurs["formulaire"]|isset ? $erreurs["formulaire"] : ""}" />
{/block}