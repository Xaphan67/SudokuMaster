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
                        <div class="boutonPave"><img src="https://placehold.co/50x50/000000/FFFFFF/png" alt=""></div>
                        <p id="notes">Notes : OFF</p>
                    </div>
                    <div class="boutons_ronds">
                        <div class="boutonPave"><img src="https://placehold.co/50x50/000000/FFFFFF/png" alt=""></div>
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
                                <img src="https://placehold.co/50x50/000000/FFFFFF/png" alt="">
                                <p>Facile</p>
                            </div>
                            <div class="bouton">
                                <img src="https://placehold.co/50x50/000000/FFFFFF/png" alt="">
                                <p>Moyen</p>
                            </div>
                            <div class="bouton">
                                <img src="https://placehold.co/50x50/000000/FFFFFF/png" alt="">
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
                    <img src="https://placehold.co/50x50/000000/FFFFFF/png" alt="">
                    <p>Facile</p>
                </div>
                <div class="bouton">
                    <img src="https://placehold.co/50x50/000000/FFFFFF/png" alt="">
                    <p>Moyen</p>
                </div>
                <div class="bouton">
                    <img src="https://placehold.co/50x50/000000/FFFFFF/png" alt="">
                    <p>Difficile</p>
                </div>
            </div>
        </div>

        <div id="fin_partie" class="popup"><!-- popup de fin de partie -->
            <h3></h3>
            <p></p>
            <div>
                <p class="score_global">Score global</p>
            </div>
            <div class="bouton">
                <img src="https://placehold.co/50x50/000000/FFFFFF/png" alt="">
                <p>Rejouer</p>
            </div>
        </div>
    </div>
</main>