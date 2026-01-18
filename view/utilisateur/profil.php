<main>
    <div id="conteneur_principal" class="vertical">
        <h1>Informations de compte</h1>
        <section id="infos_compte">
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
                <p>Pseudo</p>
                <p><?php echo $_SESSION["utilisateur"]["pseudo_utilisateur"]?></p>
                <p>Adresse mail</p>
                <p><?php echo $_SESSION["utilisateur"]["email_utilisateur"]?></p>
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
            <?php
                for ($mode = 1; $mode <= 3; $mode++) {
                    ?>
                        <div id="statistiques_<?php echo ($mode == 1 ? "solo" : ($mode == 2 ? "cooperatif" : "competitif")) ?>" class="statistiques">
                            <p>Score global</p>
                            <p class="score_principal score_large"><?php echo isset($statistiques[$mode]) ? $statistiques[$mode]->getScore_global() : "1000" ?></p>
                            <div>
                                <div>
                                    <p>Grilles jouées</p>
                                    <p><?php echo isset($statistiques[$mode]) ? $statistiques[$mode]->getGrilles_jouees() : "0" ?></p>
                                </div>
                                <div>
                                    <p>Grilles résolues</p>
                                    <p><?php echo isset($statistiques[$mode]) ? $statistiques[$mode]->getGrilles_resolues() : "0" ?></p>
                                </div>
                                <div>
                                    <p>Temps moyen</p>
                                    <p><?php echo isset($statistiques[$mode]) ? $statistiques[$mode]->getTemps_moyen() : "00:00" ?></p>
                                </div>
                                <div>
                                    <p>Meilleur temps</p>
                                    <p><?php echo isset($statistiques[$mode]) ? $statistiques[$mode]->getMeilleur_temps() : "00:00" ?></p>
                                </div>
                                <div>
                                    <p>Série de victoires</p>
                                    <p><?php echo isset($statistiques[$mode]) ? $statistiques[$mode]->getSerie_victoires() : "0" ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            ?>
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
                <?php if (isset($erreurs["mdp_check"])) { echo '<p class="erreur">' . $erreurs["mdp_check"] . '</p>'; } ?>
            </div>
            <div class="actions">
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
                <?php if (isset($erreurs["mdp_check"])) { echo '<p class="erreur">' . $erreurs["mdp_check"] . '</p>'; } ?>
            </div>
            <div class="actions">
                <input type="submit" name="supprimer_compte" class="bouton boutonPrincipal boutonDefaut" value="Supprimer" />
                <div id="bouton_annuler_supprimer" class="bouton boutonPrincipal boutonDefaut">Annuler</div>
            </div>
        </form>
    </div>
    <!-- Récupère le formulaire qui possède des erreurs pour être utilisé en JS et afficher immédiatement le popup correspondant -->
    <input type="hidden" id="erreurs" value="<?php echo isset($erreurs["formulaire"]) ? $erreurs["formulaire"] : ""; ?>" />
</main>