<main>

    <h2 id="titre_jeu">Jeu solo</h2>
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
                <div> <!-- notes et temps -->
                    <div class="boutons_ronds">
                        <div class="bouton boutonPave"><img src="app/view/assets/svg/Notes.svg" alt=""></div>
                        <p id="notes">Notes : OFF</p>
                    </div>
                    <div class="boutons_ronds">
                        <div class="bouton boutonPave"><img src="app/view/assets/svg/Pause.svg" alt=""></div>
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

                <div>
                    <div id="menu_partie" class="popup"><!-- menu -->
                        <h3>Séléctionnez la difficulté</h3>
                        <p>La progression de la partie actuelle sera perdue et comptera comme une défaite</p>
                        <div class="boutons_difficulte">
                            <div class="bouton">
                                <img src="app/view/assets/svg/Facile.svg" alt="">
                                <p>Facile</p>
                            </div>
                            <div class="bouton">
                                <img src="app/view/assets/svg/Moyen.svg" alt="">
                                <p>Moyen</p>
                            </div>
                            <div class="bouton">
                                <img src="app/view/assets/svg/Difficile.svg" alt="">
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
                    <img src="app/view/assets/svg/Facile.svg" alt="">
                    <p>Facile</p>
                </div>
                <div class="bouton">
                    <img src="app/view/assets/svg/Moyen.svg" alt="">
                    <p>Moyen</p>
                </div>
                <div class="bouton">
                    <img src="app/view/assets/svg/Difficile.svg" alt="">
                    <p>Difficile</p>
                </div>
            </div>
        </div>

        <div id="fin_partie" class="popup"><!-- popup de fin de partie -->
            <h3></h3>
            <p></p>
            <p class="score_global">Score global</p>
            <div class="bouton">
                <img src="app/view/assets/svg/Rejouer.svg" alt="">
                <p>Rejouer</p>
            </div>
        </div>

        <div id="erreur" class="popup"><!-- popup d'erreur de grille -->
            <h3>Une erreur est survenue</h3>
            <p>
                Impossible de récupérer une grille actuellement.<br>
                Veuillez réessayer plus tard.
            </p>
            <a href="index.php" class="bouton boutonPrincipal boutonLarge">Retour à l'accueil</a>
        </div>
    </div>
</main>