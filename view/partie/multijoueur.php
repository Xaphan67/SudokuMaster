<main>
    <div id="haut" class="separateur_haut">
        <h2 id="titre_jeu">Multijoueur</h2>
        <div id="infos_multijoueur" inert>
            <div>
                <img src="view/assets/img/TropheeOr.webp" alt ="">
                <p class="score_principal score_petit">0</p>
                <p>???</p>
                <div id="joueur_1" class="info_joueur info_joueur_bas">
                    <h3>???</h3>
                    <div>
                        <div>
                            <p>Nombre total de grilles jouées :</p>
                            <p>Nombre de grilles résolues :</p>
                            <p>Temps moyen :</p>
                            <p>Meilleur temps :</p>
                            <p>Série de victoires :</p>
                        </div>
                        <div>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                        </div>
                    </div>
                    <img src="view/assets/svg/Fleche.svg" alt="">
                </div>
            </div>
            <img src="view/assets/svg/Competitif.svg" alt="">
            <div>
                <p>???</p>
                <div id="joueur_2" class="info_joueur info_joueur_bas">
                    <h3>???</h3>
                    <div>
                        <div>
                            <p>Nombre total de grilles jouées :</p>
                            <p>Nombre de grilles résolues :</p>
                            <p>Temps moyen :</p>
                            <p>Meilleur temps :</p>
                            <p>Série de victoires :</p>
                        </div>
                        <div>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                            <p></p>
                        </div>
                    </div>
                    <img src="view/assets/svg/Fleche.svg" alt="">
                </div>
                <p class="score_principal score_petit score_petit_droite">0</p>
                <img src="view/assets/img/TropheeOr.webp" alt ="">
            </div>
        </div>
    </div>
    <div id="conteneur_principal">
        <div id="conteneur_jeu" inert>
            <table class="grille" id="grille_vide" inert>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <table class="grille" id="grille">
            </table>

            <div id="interface_de_jeu"> <!-- boutons de jeu -->
                <div class="boutons_haut"> <!-- notes et temps -->
                    <div class="boutons_ronds">
                        <div id="bouton_notes" class="bouton boutonPave"><img src="view/assets/svg/Notes.svg" alt=""></div>
                        <p id="notes">Notes : OFF</p>
                    </div>
                    <div class="boutons_ronds">
                        <div id="bouton_pause" class="bouton boutonPave"><img src="view/assets/svg/Pause.svg" alt=""></div>
                        <p id="timer">Temps : 15:00</p>
                    </div>
                </div>

                <div id="pave_numerique"> <!-- pavé numérique -->
                    <p class="bouton boutonPave">1</p>
                    <p class="bouton boutonPave">2</p>
                    <p class="bouton boutonPave">3</p>
                    <p class="bouton boutonPave">4</p>
                    <p class="bouton boutonPave">5</p>
                    <p class="bouton boutonPave">6</p>
                    <p class="bouton boutonPave">7</p>
                    <p class="bouton boutonPave">8</p>
                    <p class="bouton boutonPave">9</p>
                </div>

                <div id="bouton_jeu" class="bouton boutonPrincipal">Abandonner</div>
            </div>
        </div>

        <div id="debut_partie" class="popup popup_large"><!-- popup de début de partie -->
            <h3>En attente d'un autre joueur...</h3>
            <p>ID de la salle : </p>
            <p>Communiquez cet ID à un autre joueur pour qu'il puisse vous rejoindre</p>
            <img src="view/assets/img/Sablier.webp" alt="">
            <a href="index.php?controller=partie&action=lobby" class="bouton boutonPrincipal boutonLarge">Quitter</a>
        </div>

        <div id="verif_joueur_pret" class="popup popup_large"><!-- popup de vérification joueur prêt -->
            <h3>Êtes-vous prêt ?</h3>
            <p>Cliquez sur le bouton "Je suis prêt" dès que vous êtes prêt à commencer la partie</p>
            <p>La partie débutera dès que les deux joueurs sont prêts</p>
            <div id="joueurs">
                <div>
                    <div>
                        <img src="view/assets/svg/AvatarUtilisateur.svg" alt="">
                        <img src="view/assets/svg/Coche.svg" alt="">
                    </div>
                    <p></p>
                </div>
                <div>
                    <div>
                        <img src="view/assets/svg/AvatarUtilisateur.svg" alt="">
                        <img src="view/assets/svg/Coche.svg" alt="">
                    </div>
                    <p></p>
                </div>
            </div>
            <div id="bouton_pret" class="bouton boutonPrincipal boutonLarge">Je suis prêt</div>
        </div>

        <div id="abandon_autre_joueur_partie" class="popup popup_large"><!-- popup d'abandon de partie de l'autre joueur' -->
            <h3>à abandonné la partie</h3>
            <p>Vous pouvez terminer la partie seul, ou abandonner la partie</p>
            <p>Attention ! Abandonner la partie comptera comme une défaite</p>
            <div id="bouton_continuer_partie" class="bouton boutonPrincipal boutonDefaut">Terminer seul</div>
            <a href="index.php?controller=partie&action=lobby" class="bouton boutonPrincipal boutonLarge">Abandonner</a>
        </div>

        <div id="abandon_partie" class="popup popup_large"><!-- popup d'abandon de partie' -->
            <h3>Abandonner la partie ?</h3>
            <p>La progression de la partie actuelle sera perdue et comptera comme une défaite</p>
            <a href="index.php?controller=partie&action=lobby" class="bouton boutonPrincipal boutonLarge">Abandonner</a>
            <div id="bouton_annuler_partie" class="bouton boutonPrincipal boutonDefaut">Annuler</div>
        </div>

        <div id="fin_partie" class="popup"><!-- popup de fin de partie -->
            <h3></h3>
            <p>Vous avez correctement teminé la grille</p>
            <p class="score_global">Score global</p>
            <a href="index.php?controller=partie&action=lobby" class="bouton boutonPrincipal boutonLarge">Retour au salon</a>
        </div>

        <div id="erreur" class="popup"><!-- popup d'erreur de grille -->
            <h3>Une erreur est survenue</h3>
            <p>
                Impossible de récupérer une grille actuellement<br>
                Veuillez réessayer plus tard
            </p>
            <a href="index.php" class="bouton boutonPrincipal boutonLarge">Retour à l'accueil</a>
        </div>

        <div id="erreur_salle" class="popup popup_large"><!-- popup d'erreur de salle -->
            <h3>Une erreur est survenue</h3>
            <p>
                La salle demandée n'existe pas<br>
                Veuillez réessayer
            </p>
            <a href="index.php?controller=partie&action=lobby" class="bouton boutonPrincipal boutonLarge">Retour au salon</a>
        </div>

        <div id="erreur_serveur" class="popup popup_large"><!-- popup d'erreur de connexion au serveur WebSocket -->
            <h3>Une erreur est survenue</h3>
            <p>
                Impossible de contacter le serveur de parties<br>
                Veuillez réessayer plus tard
            </p>
            <a href="index.php?controller=partie&action=lobby" class="bouton boutonPrincipal boutonLarge">Retour au salon</a>
        </div>
    </div>
</main>