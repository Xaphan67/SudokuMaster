<main>
    <div id="conteneur_principal" class="vertical">
        <h2 id="titre_jeu" class="separateur_haut large">Jeu solo</h2>
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
                    <div id="menu_partie" class="popup"><!-- menu -->
                        <h3>Séléctionnez la difficulté</h3>
                        <p>La progression de la partie actuelle sera perdue et comptera comme une défaite</p>
                        <div class="boutons_difficulte">
                            <div class="bouton">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <path d="M173.19 155c-9.92 17.16-26.39 27-45.19 27s-35.27-9.84-45.19-27a6 6 0 0 1 10.38-6c7.84 13.54 20.2 21 34.81 21s27-7.46 34.81-21a6 6 0 1 1 10.38 6ZM230 128A102 102 0 1 1 128 26a102.12 102.12 0 0 1 102 102Zm-12 0a90 90 0 1 0-90 90a90.1 90.1 0 0 0 90-90ZM92 118a10 10 0 1 0-10-10a10 10 0 0 0 10 10Zm72-20a10 10 0 1 0 10 10a10 10 0 0 0-10-10Z"/>
                                </svg>
                                <p>Facile</p>
                            </div>
                            <div class="bouton">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <path d="M128 26a102 102 0 1 0 102 102A102.12 102.12 0 0 0 128 26Zm0 192a90 90 0 1 1 90-90a90.1 90.1 0 0 1-90 90Zm46-58a6 6 0 0 1-6 6H88a6 6 0 0 1 0-12h80a6 6 0 0 1 6 6Zm-92-52a10 10 0 1 1 10 10a10 10 0 0 1-10-10Zm92 0a10 10 0 1 1-10-10a10 10 0 0 1 10 10Z"/>
                                </svg>
                                <p>Moyen</p>
                            </div>
                            <div class="bouton">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <path d="M128 26a102 102 0 1 0 102 102A102.12 102.12 0 0 0 128 26Zm0 192a90 90 0 1 1 90-90a90.1 90.1 0 0 1-90 90ZM82 108a10 10 0 1 1 10 10a10 10 0 0 1-10-10Zm92 0a10 10 0 1 1-10-10a10 10 0 0 1 10 10Zm-.81 65a6 6 0 0 1-10.38 6c-7.84-13.54-20.2-21-34.81-21s-27 7.46-34.81 21a6 6 0 0 1-5.2 3a5.9 5.9 0 0 1-3-.81a6 6 0 0 1-2.18-8.19c9.92-17.16 26.39-27 45.19-27s35.27 9.84 45.19 27Z"/>
                                </svg>
                                <p>Difficile</p>
                            </div>
                        </div>
                    </div>
                    <div id="bouton_jeu" class="bouton boutonPrincipal">Nouvelle Partie</div>
                </div>
            </div>
        </div>
        <div id="debut_partie" class="popup"><!-- popup de début de partie -->
            <h3>Séléctionnez la difficulté</h3>
            <p>La partie débutera dès que vous aurez fait votre choix</p>
            <p>Attention, quitter ou abandonner la partie sera considéré comme une défaite</p>
            <div class="boutons_difficulte">
                <div class="bouton">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M173.19 155c-9.92 17.16-26.39 27-45.19 27s-35.27-9.84-45.19-27a6 6 0 0 1 10.38-6c7.84 13.54 20.2 21 34.81 21s27-7.46 34.81-21a6 6 0 1 1 10.38 6ZM230 128A102 102 0 1 1 128 26a102.12 102.12 0 0 1 102 102Zm-12 0a90 90 0 1 0-90 90a90.1 90.1 0 0 0 90-90ZM92 118a10 10 0 1 0-10-10a10 10 0 0 0 10 10Zm72-20a10 10 0 1 0 10 10a10 10 0 0 0-10-10Z"/>
                    </svg>
                    <p>Facile</p>
                </div>
                <div class="bouton">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M128 26a102 102 0 1 0 102 102A102.12 102.12 0 0 0 128 26Zm0 192a90 90 0 1 1 90-90a90.1 90.1 0 0 1-90 90Zm46-58a6 6 0 0 1-6 6H88a6 6 0 0 1 0-12h80a6 6 0 0 1 6 6Zm-92-52a10 10 0 1 1 10 10a10 10 0 0 1-10-10Zm92 0a10 10 0 1 1-10-10a10 10 0 0 1 10 10Z"/>
                    </svg>
                    <p>Moyen</p>
                </div>
                <div class="bouton">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M128 26a102 102 0 1 0 102 102A102.12 102.12 0 0 0 128 26Zm0 192a90 90 0 1 1 90-90a90.1 90.1 0 0 1-90 90ZM82 108a10 10 0 1 1 10 10a10 10 0 0 1-10-10Zm92 0a10 10 0 1 1-10-10a10 10 0 0 1 10 10Zm-.81 65a6 6 0 0 1-10.38 6c-7.84-13.54-20.2-21-34.81-21s-27 7.46-34.81 21a6 6 0 0 1-5.2 3a5.9 5.9 0 0 1-3-.81a6 6 0 0 1-2.18-8.19c9.92-17.16 26.39-27 45.19-27s35.27 9.84 45.19 27Z"/>
                    </svg>
                    <p>Difficile</p>
                </div>
            </div>
        </div>
        <div id="fin_partie" class="popup"><!-- popup de fin de partie -->
            <h3></h3>
            <p>Vous avez correctement teminé la grille</p>
            <p class="score_global">Score global</p>
            <div id="bouton_rejouer_partie" class="bouton boutonPrincipal boutonDefaut">Rejouer</div>
        </div>
        <div id="erreur" class="popup"><!-- popup d'erreur de grille -->
            <h3>Une erreur est survenue</h3>
            <p>
                Impossible de récupérer une grille actuellement<br>
                Veuillez réessayer plus tard
            </p>
            <a href="index.php" class="bouton boutonPrincipal boutonLarge">Retour à l'accueil</a>
        </div>
    </div>
</main>