<main>
    <div id="conteneur_principal" class="vertical">
        <h1>Informations de compte</h1>
        <div id="infos_compte">
            <div>
                <div>
                    <p>Pseudo :</p>
                    <p>Adresse mail :</p>
                    <p>Mot de passe :</p>
                </div>
                <div>
                    <p><?php echo $_SESSION["utilisateur"]["pseudo_utilisateur"]?></p>
                    <p><?php echo $_SESSION["utilisateur"]["email_utilisateur"]?></p>
                    <p>*********</p>
                </div>
            </div>
            <div>
                <div id="bouton_modifier" class="bouton boutonPrincipal boutonProfil">
                    <img src="https://placehold.co/40x40/000000/FFFFFF/png" alt="">
                    <p>Modifier</p>
                </div>
                <div id="bouton_supprimer" class="bouton boutonPrincipal boutonProfil">
                    <img src="https://placehold.co/40x40/000000/FFFFFF/png" alt="">
                    <p>Supprimer</p>
                </div>
            </div>
        </div>
        <div id="statistiques">
            <h2>Statistiques Personnelles</h2>
            <div class="onglets onglets-stats">
                <p class="onglet_actif">Solo</p>
                <p>Coopératif</p>
                <p>Compétitif</p>
            </div>
            <div id="statistiques_solo" class="statistiques contenu_onglet_actif">
                <p>Score global</p>
                <p class="score_principal score_large"><?php echo isset($statistiques[1]) ? $statistiques[1]->getScore_global() : "0" ?></p>
                <table>
                    <tbody>
                        <tr>
                            <th>Grilles jouées</th>
                            <th>Grilles résolues</th>
                            <th>Temps moyen</th>
                            <th>Meilleur temps</th>
                            <th>Série de victoires</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($statistiques[1]) ? $statistiques[1]->getGrilles_jouees() : "0" ?></td>
                            <td><?php echo isset($statistiques[1]) ? $statistiques[1]->getGrilles_resolues() : "0" ?></td>
                            <td><?php echo isset($statistiques[1]) ? $statistiques[1]->getTemps_moyen() : "00:00" ?></td>
                            <td><?php echo isset($statistiques[1]) ? $statistiques[1]->getMeilleur_temps() : "00:00" ?></td>
                            <td><?php echo isset($statistiques[1]) ? $statistiques[1]->getSerie_victoires() : "0" ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="statistiques_cooperatif" class="statistiques">
                <p>Score global</p>
                <p class="score_principal score_large"><?php echo isset($statistiques[2]) ? $statistiques[2]->getScore_global() : "0" ?></p>
                <table>
                    <tbody>
                        <tr>
                            <th>Grilles jouées</th>
                            <th>Grilles résolues</th>
                            <th>Temps moyen</th>
                            <th>Meilleur temps</th>
                            <th>Série de victoires</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($statistiques[2]) ? $statistiques[2]->getGrilles_jouees() : "0" ?></td>
                            <td><?php echo isset($statistiques[2]) ? $statistiques[2]->getGrilles_resolues() : "0" ?></td>
                            <td><?php echo isset($statistiques[2]) ? $statistiques[2]->getTemps_moyen() : "00:00" ?></td>
                            <td><?php echo isset($statistiques[2]) ? $statistiques[2]->getMeilleur_temps() : "00:00" ?></td>
                            <td><?php echo isset($statistiques[2]) ? $statistiques[2]->getSerie_victoires() : "0" ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="statistiques_competitif" class="statistiques">
                <p>Score global</p>
                <p class="score_principal score_large"><?php echo isset($statistiques[3]) ? $statistiques[3]->getScore_global() : "0" ?></p>
                <table>
                    <tbody>
                        <tr>
                            <th>Grilles jouées</th>
                            <th>Grilles résolues</th>
                            <th>Temps moyen</th>
                            <th>Meilleur temps</th>
                            <th>Série de victoires</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($statistiques[3]) ? $statistiques[3]->getGrilles_jouees() : "0" ?></td>
                            <td><?php echo isset($statistiques[3]) ? $statistiques[3]->getGrilles_resolues() : "0" ?></td>
                            <td><?php echo isset($statistiques[3]) ? $statistiques[3]->getTemps_moyen() : "00:00" ?></td>
                            <td><?php echo isset($statistiques[3]) ? $statistiques[3]->getMeilleur_temps() : "00:00" ?></td>
                            <td><?php echo isset($statistiques[3]) ? $statistiques[3]->getSerie_victoires() : "0" ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modifier_compte" class="popup"> <!-- popup modification des données du compte -->
        <h3>Modifier vos informations personelles</h3>
        <p>Remplissez le formulaire pour mettre à jour vos informations de compte</p>
        <p>Les champs de mot de passe peuvent rester vide si vous ne souhaitez pas le modifier</p>
        <form method="post">
            <div>
                <label for="pseudo">Pseudo</label>
                <input id="pseudo"
                    name="pseudo"
                    type="text"
                    placeholder="<?php echo $_SESSION["utilisateur"]["pseudo_utilisateur"] ?>"
                    autocomplete="username"
                    <?php echo 'value="' . (isset($pseudoSaisi) ? $pseudoSaisi : $_SESSION["utilisateur"]["pseudo_utilisateur"]) . '"' ?>
                    required
                />
                <?php if (isset($erreurs["pseudo"])) { echo '<p class="erreur">' . $erreurs["pseudo"] . '</p>'; } ?>
            </div>
            <div>
                <label for="email">Adresse mail</label>
                <input id="email"
                    name="email"
                    type="email"
                    placeholder="<?php echo $_SESSION["utilisateur"]["email_utilisateur"] ?>"
                    autocomplete="email"
                    <?php echo 'value="' . (isset($emailSaisi) ? $emailSaisi : $_SESSION["utilisateur"]["email_utilisateur"]) . '"' ?>
                    required
                />
                <?php if (isset($erreurs["email"])) { echo '<p class="erreur">' . $erreurs["email"] . '</p>'; } ?>
            </div>
            <div>
                <label for="mdp">Mot de passe</label>
                <input id="mdp"
                    name="mdp"
                    type="password"
                    placeholder="*********"
                    autocomplete="off"
                />
                <?php if (isset($erreurs["mdp"])) { echo '<p class="erreur">' . $erreurs["mdp"] . '</p>'; } ?>
            </div>
            <div>
                <label for="mdp_confirm">Confirmation du mot de passe</label>
                <input id="mdp_confirm"
                    name="mdp_confirm"
                    type="password"
                    placeholder="*********"
                    autocomplete="off"
                />
                <?php if (isset($erreurs["mdp_confirm"])) { echo '<p class="erreur">' . $erreurs["mdp_confirm"] . '</p>'; } ?>
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
                <?php if (isset($erreurs["mdp_check"])) { echo '<p class="erreur">' . $erreurs["mdp_check"] . '</p>'; } ?>
            </div>
            <div class="actions">
                <input type="submit" name="modifier_compte" class="bouton boutonPrincipal boutonDefaut" value="Modifier mes informations" />
                <div id="bouton_annuler_modifier" class="bouton boutonPrincipal boutonDefaut">Annuler</div>
            </div>
        </form>
    </div>
    <div id="supprimer_compte" class="popup"> <!-- popup supression du compte -->
        <h3>Supprimer votre compte</h3>
        <p>Vous êtes sur le point de supprimer votre compte. Cette action est irreversible !</p>
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
                <?php if (isset($erreurs["mdp_check"])) { echo '<p class="erreur">' . $erreurs["mdp_check"] . '</p>'; } ?>
            </div>
            <div class="actions">
                <input type="submit" name="supprimer_compte" class="bouton boutonPrincipal boutonDefaut" value="Supprimer mon compte" />
                <div id="bouton_annuler_supprimer" class="bouton boutonPrincipal boutonDefaut">Annuler</div>
            </div>
        </form>
    </div>
    <!-- Récupère le formulaire qui possède des erreurs pour être utilisé en JS et afficher immédiatement le popup correspondant -->
    <input type="hidden" id="erreurs" value="<?php echo isset($erreurs["formulaire"]) ? $erreurs["formulaire"] : ""; ?>" />
</main>