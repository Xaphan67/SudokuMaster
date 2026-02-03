{extends 'base.tpl'}

{block contenu}
<div id="conteneur_principal" class="vertical">
    <div id="haut" class="separateur_haut">
        <h2 id="titre_jeu" class="normal">Multijoueur</h2>
        <div id="infos_multijoueur" inert>
            <div>
                <img src="assets/img/TropheeOr.webp" alt ="">
                <p class="score_principal score_petit">0</p>
                <p>???</p>
                <div id="joueur_1" class="info_joueur info_joueur_bas info_joueur_gauche">
                    <h3>???</h3>
                    <div>
                        <div>
                            <p>Grilles jouées :</p>
                            <p>Grilles résolues :</p>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="m229.66 141.66l-96 96a8 8 0 0 1-11.32 0l-96-96A8 8 0 0 1 32 128h40V48a16 16 0 0 1 16-16h80a16 16 0 0 1 16 16v80h40a8 8 0 0 1 5.66 13.66Z"/>
                    </svg>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                <path d="M216 34h-64a6 6 0 0 0-4.76 2.34l-65.39 85L70.6 110.1a14 14 0 0 0-19.8 0l-12.7 12.7a14 14 0 0 0 0 19.81L59.51 164L30.1 193.42a14 14 0 0 0 0 19.8l12.69 12.69a14 14 0 0 0 19.8 0L92 196.5l21.4 21.4a14 14 0 0 0 19.8 0l12.7-12.69a14 14 0 0 0 0-19.81l-11.25-11.25l85-65.39A6 6 0 0 0 222 104V40a6 6 0 0 0-6-6ZM54.1 217.42a2 2 0 0 1-2.83 0l-12.68-12.69a2 2 0 0 1 0-2.82L68 172.5L83.51 188Zm83.31-20.7l-12.69 12.7a2 2 0 0 1-2.84 0l-75.29-75.3a2 2 0 0 1 0-2.83l12.69-12.7a2 2 0 0 1 2.84 0l75.29 75.3a2 2 0 0 1 0 2.83ZM210 101.05l-83.91 64.55l-13.6-13.6l51.75-51.76a6 6 0 0 0-8.48-8.48L104 143.51l-13.6-13.6L155 46h55Z"/>
            </svg>
            <div>
                <p>???</p>
                <div id="joueur_2" class="info_joueur info_joueur_bas info_joueur_droite">
                    <h3>???</h3>
                    <div>
                        <div>
                            <p>Grilles jouées :</p>
                            <p>Grilles résolues :</p>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="m229.66 141.66l-96 96a8 8 0 0 1-11.32 0l-96-96A8 8 0 0 1 32 128h40V48a16 16 0 0 1 16-16h80a16 16 0 0 1 16 16v80h40a8 8 0 0 1 5.66 13.66Z"/>
                    </svg>
                </div>
                <p class="score_principal score_petit score_petit_droite">0</p>
                <img src="assets/img/TropheeOr.webp" alt ="">
            </div>
        </div>
    </div>
    <div id="conteneur_jeu" inert>
        <div class="chargement"></div>
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
            <div>
                <div class="boutons_haut"> <!-- notes et temps -->
                    <div class="boutons_ronds">
                        <div id="bouton_notes" class="bouton boutonPave">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <path d="m225.9 74.78l-44.69-44.69a14 14 0 0 0-19.8 0L38.1 153.41a13.94 13.94 0 0 0-4.1 9.9V208a14 14 0 0 0 14 14h44.69a13.94 13.94 0 0 0 9.9-4.1L225.9 94.58a14 14 0 0 0 0-19.8ZM48.49 160L136 72.48L155.51 92L68 179.51ZM46 208v-33.52L81.51 210H48a2 2 0 0 1-2-2Zm50-.49L76.49 188L164 100.48L183.51 120ZM217.41 86.1L192 111.51L144.49 64l25.41-25.42a2 2 0 0 1 2.83 0l44.68 44.69a2 2 0 0 1 0 2.83Z"/>
                            </svg>
                        </div>
                        <p id="notes">Notes : OFF</p>
                    </div>
                    <div class="boutons_ronds">
                        <div id="bouton_pause" class="bouton boutonPave">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <path d="M200 34h-40a14 14 0 0 0-14 14v160a14 14 0 0 0 14 14h40a14 14 0 0 0 14-14V48a14 14 0 0 0-14-14Zm2 174a2 2 0 0 1-2 2h-40a2 2 0 0 1-2-2V48a2 2 0 0 1 2-2h40a2 2 0 0 1 2 2ZM96 34H56a14 14 0 0 0-14 14v160a14 14 0 0 0 14 14h40a14 14 0 0 0 14-14V48a14 14 0 0 0-14-14Zm2 174a2 2 0 0 1-2 2H56a2 2 0 0 1-2-2V48a2 2 0 0 1 2-2h40a2 2 0 0 1 2 2Z"/>
                            </svg>
                        </div>
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
            </div>
            <div>
                <div id="bouton_jeu" class="bouton boutonPrincipal">Abandonner</div>
            </div>
        </div>
    </div>
    <div id="debut_partie" class="popup popup_large"><!-- popup de début de partie -->
        <h3>En attente d'un autre joueur...</h3>
        <p>ID de la salle : </p>
        <p>Communiquez cet ID à un autre joueur pour qu'il puisse vous rejoindre</p>
        <img src="assets/img/Sablier.webp" alt="">
        <a href="salon" class="bouton boutonPrincipal boutonLarge">Quitter</a>
    </div>
    <div id="verif_joueur_pret" class="popup popup_large"><!-- popup de vérification joueur prêt -->
        <h3>Êtes-vous prêt ?</h3>
        <p>Cliquez sur le bouton "Je suis prêt" dès que vous êtes prêt à commencer la partie</p>
        <p>La partie débutera dès que les deux joueurs sont prêts</p>
        <div id="joueurs">
            <div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z"/>
                    </svg>
                    <img src="assets/svg/Coche.svg" alt="">
                </div>
                <p></p>
            </div>
            <div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z"/>
                    </svg>
                    <img src="assets/svg/Coche.svg" alt="">
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
        <a href="salon" class="bouton boutonPrincipal boutonDefaut">Abandonner</a>
    </div>
    <div id="abandon_partie" class="popup popup_large"><!-- popup d'abandon de partie' -->
        <h3>Abandonner la partie ?</h3>
        <p>La progression de la partie actuelle sera perdue et comptera comme une défaite</p>
        <a href="salon" class="bouton boutonPrincipal boutonDefaut">Abandonner</a>
        <div id="bouton_annuler_partie" class="bouton boutonPrincipal boutonDefaut">Annuler</div>
    </div>
    <div id="fin_partie" class="popup"><!-- popup de fin de partie -->
        <h3></h3>
        <p>Vous avez correctement teminé la grille</p>
        <p class="score_global">Score global</p>
        <a href="salon" class="bouton boutonPrincipal boutonDefaut">Retour au salon</a>
    </div>
    <div id="erreur" class="popup"><!-- popup d'erreur de grille -->
        <h3>Une erreur est survenue</h3>
        <p>
            Impossible de récupérer une grille actuellement<br>
            Veuillez réessayer plus tard
        </p>
        <a href="index.php" class="bouton boutonPrincipal boutonDefaut">Retour à l'accueil</a>
    </div>
    <div id="erreur_salle" class="popup popup_large"><!-- popup d'erreur de salle -->
        <h3>Une erreur est survenue</h3>
        <p>
            La salle demandée n'existe pas<br>
            Veuillez réessayer
        </p>
        <a href="salon" class="bouton boutonPrincipal boutonDefaut">Retour au salon</a>
    </div>
    <div id="erreur_serveur" class="popup popup_large"><!-- popup d'erreur de connexion au serveur WebSocket -->
        <h3>Une erreur est survenue</h3>
        <p>
            Impossible de contacter le serveur de parties<br>
            Veuillez réessayer plus tard
        </p>
        <a href="salon" class="bouton boutonPrincipal boutonDefaut">Retour au salon</a>
    </div>
</div>
{/block}