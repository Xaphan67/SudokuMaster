// Constantes
const CONTENEUR_JEU = document.getElementById("conteneur_jeu");
const TABLE = document.getElementById("grille");
const TABLE_VIDE = document.getElementById("grille_vide");
const PAVE = document.getElementById("pave_numerique");
const BOUTONS =  Array.from(PAVE.getElementsByTagName("p"));
const BOUTON_NOTES = document.getElementById("interface_de_jeu").getElementsByTagName("div")[1];
const BOUTON_PAUSE_TIMER = document.getElementById("interface_de_jeu").getElementsByTagName("div")[3];
const BOUTON_JEU = document.getElementById("bouton_jeu");
const MENU_PARTIE = document.getElementById("menu_partie");
const TITRE_JEU = document.getElementById("titre_jeu");
const POPUP_DEBUT_PARTIE = document.getElementById("debut_partie");
const POPUP_FIN_PARTIE = document.getElementById("fin_partie");
const POPUP_FIN_PARTIE_TITRE = POPUP_FIN_PARTIE.getElementsByTagName("h3")[0];
const POPUP_FIN_PARTIE_TEXTE = POPUP_FIN_PARTIE.getElementsByTagName("p")[0];
const POPUP_FIN_PARTIE_SCORE_GLOBAL = POPUP_FIN_PARTIE.getElementsByTagName("p")[1];
const POPUP_FIN_PARTIE_REJOUER = POPUP_FIN_PARTIE.getElementsByTagName("div")[0];
const POPUP_ERREUR = document.getElementById("erreur");
const NOTES = document.getElementById("notes");
const TIMER = document.getElementById("timer");
const UTILISATEUR_CONNECTE = document.getElementById("session_utilisateur");

// Variables
// DOM
let difficulte = null;
let caseActuelle = null;
let case_focus = null;

// Partie
let partieEnCours = false;
let idPartie = null;
let serieVictoires = null;
let scoreGlobal = null;
let valeur = null;
let evolution = null;

// multijoueur
let multijoueur;
let connexion;
let infosSalle;

// Timer
let start = null;
let deltaPause = null;
let timerActif;
let timerMinutes;
let timerSecondes;
let timerInterval = -1;

// Grille
let grille = [];
let solution = [];
let selectionX = null;
let selectionY = null;

// Mode Notes
let modeNotes = false;

// Menu Bouton Jeu
let menuOuvert = false;

// Si le joueur joue une partie solo ou multijoueur
if (TITRE_JEU.innerHTML.includes('Multijoueur')) {

    // Set la variable multijoueur à vrai, et se connecte au serveur WebSocket
    multijoueur = true;
    connexion = new WebSocket('ws://localhost:8080');

    // Cache le popup d'attente d'un joueur
    POPUP_DEBUT_PARTIE.style.display = "none";

    joinRoom();
}

function joinRoom() {

    // Défini ce qui se passe lorsque la connexion est connectée au serveur WebSocket
    connexion.onopen = async function (e) {

        // Récupère l'information en PHP si le joueur est hote de la partie
        // ou la salle qu'il souhaite rejoindre
        const HOTE = await fetch("index.php?controller=partie&action=getRoomInfo", {
                method: "POST",
                headers: {
                        'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
                    }
                });
        infosSalle = await HOTE.json();

        // Si le joueur est hote de la partie...
        if (infosSalle.hote) {

            // Change le titre du tableau de jeu
            let mode = infosSalle.mode.charAt(0).toUpperCase() + infosSalle.mode.slice(1);
            let difficulte = infosSalle.difficulte.charAt(0).toUpperCase() + infosSalle.difficulte.slice(1);
            TITRE_JEU.innerHTML = "Jeu " + mode + " : Difficulté " + difficulte;

            // Demande au serveur WebSocket de créer une salle
            connexion.send(JSON.stringify({commande: "creer_salle", mode: mode, difficulte: difficulte}));

            // Affiche le popup d'attente d'un joueur
            POPUP_DEBUT_PARTIE.style.display = "flex";
        }

        // Sinon, demande au serveur WebSocket de rejoindre une salle
        else {
            connexion.send(JSON.stringify({commande: "rejoindre_salle", salle: infosSalle.salle}));
        }
    };

    // Défini ce qui se passe quand le serveur WebSocket envoie un message à la connexion
    connexion.onmessage = (e) => {
        let message = JSON.parse(e.data);

        switch (message.commande) {

            // Le serveur renvoie l'Id de la salle créée
            case "numero_salle":
                TITRE_JEU.innerHTML += " - ID Salle : " +  message.numero;
                break;

            // Le serveur renvoie les infos de la salle rejointe
            case "infos_salle":

                // Stocke les infos
                infosSalle.mode = message.mode;
                infosSalle.difficulte = message.difficulte;

                // Change le titre du tableau de jeu
                TITRE_JEU.innerHTML = "Jeu " + infosSalle.mode + " : Difficulté " + infosSalle.difficulte + " - ID Salle : " + infosSalle.salle;
                break;

            // Le serveur indique qu'un joueur à rejoint la salle
            case "joueur_rejoint":

                // Masque le popup d'attente d'un joueur
                POPUP_DEBUT_PARTIE.style.display = "none";
                break;

            // Le serveur indique que la salle à rejoindre n'existe pas
            case "salle_inexistante":

                // Affiche le popup indiquant que la salle n'existe pas
                const ERREUR_SALLE = document.getElementById("erreur_salle");
                ERREUR_SALLE.style.display = "flex";
                break;
        }
    };
}

// Partie solo uniquement
if (!multijoueur) {

    // Séléction de la difficulté via popop début de partie
    const POPUP_BOUTONS_DIFFICULTE = Array.from(document.getElementsByClassName("boutons_difficulte")[1].getElementsByTagName("div"));
    POPUP_BOUTONS_DIFFICULTE.forEach(element => {
        element.onclick= function() {
            // Masque le popup
            POPUP_DEBUT_PARTIE.style.display = "none";

            // Démarre la partie
            startGame(element);
        }
    });

    // Séléction de la difficulté via le menu
    const MENU_PARTIE_BOUTONS_DIFFICULTE = Array.from(document.getElementsByClassName("boutons_difficulte")[0].getElementsByTagName("div"));
    MENU_PARTIE_BOUTONS_DIFFICULTE.forEach(element => {
        element.onclick= function() {
            // Masque le menu et le considère comme fermé
            MENU_PARTIE.style.display = "none";
            menuOuvert = false;
            BOUTON_JEU.innerHTML = "Nouvelle partie";

            // Met fin à la partie
            endGame(false);

            // Remet le timer à 15 minutes
            resetTimer();

            // Démarre la partie
            startGame(element);
        }
    });
}

// Stocke la case sur laquelle l'utilisateur à cliqué
TABLE.addEventListener("click", (e) => {
    let cellules = Array.from(TABLE.getElementsByTagName("td"));
    case_focus = e.target;
    if (case_focus.nodeName == "TD") {
        caseActuelle = case_focus;

        // Récupère les coordonnées de la case cliquée
        selectionX = caseActuelle.cellIndex;
        selectionY = caseActuelle.parentNode.rowIndex;

        // Met la case en surbrillance
        case_focus.classList.add("selected_highlight");

        // Colorie toutes les cellules autres que celle selectionnée
        cellules.forEach(cellule => {
            if (cellule != e.target && e.target != 0) {
                cellule.classList.remove("selected_highlight");

                // Si la cellule n'a pas le même chiffre que celle selectionné et qu'elle a la classe selected
                if (cellule.getElementsByTagName("p")[0].innerHTML != e.target.getElementsByTagName("p")[0].innerHTML && cellule.classList.contains("selected")) {
                    //on enlève la classe selected
                    cellule.classList.remove("selected");
                }

                // Si la cellule a le même chiffre que celle selectionnée et que ce n'est pas vide
                if (cellule.getElementsByTagName("p")[0].innerHTML == e.target.getElementsByTagName("p")[0].innerHTML && e.target.getElementsByTagName("p")[0].innerHTML != 0) {
                    cellule.classList.add("selected");
                    cellule.classList.remove("selected_highlight");
                }
            }
        });
    }
});

// Lors d'un clic sur le bouton notes...
BOUTON_NOTES.addEventListener("click", (e) => {
    modeNotes = !modeNotes;
    NOTES.innerHTML = "Notes : " + (modeNotes ? "ON" : "OFF");
});

// Lors d'un clic sur le bouton pause...
BOUTON_PAUSE_TIMER.addEventListener("click", (e) => {
    startTimer();
});

// Lors d'un clic sur un des boutons du pavé numérique...
BOUTONS.forEach(element => {
    element.onclick=function() {
        // Vérifie que la case actuelle n'est pas nulle, qu'elle peux être modifiée par le joueur
        // et que la partie est en cours
        if (caseActuelle != null && !case_focus.classList.contains("celluleFixe") && partieEnCours) {
            const LISTE_NOTES = caseActuelle.getElementsByTagName("ul")[0];

            // Vérifie si le mode notes est activé
            if (modeNotes) {
                // Ajoute la note dans la liste de notes de la case

                // Si la case à déjà été remplie par le joueur, on supprime ce qu'il à marqué
                caseActuelle.getElementsByTagName("p")[0].innerHTML = "";
                grille[selectionY][selectionX] = "0";

                // Si la case n'a pas de liste de notes, on en crée une
                if (LISTE_NOTES == undefined) {
                    const NOUVEAU_UL = document.createElement("ul");
                    NOUVEAU_UL.inert = true;
                    const NOUVEAU_LI = document.createElement("li");
                    const NOMBRE = document.createTextNode(this.innerHTML);
                    NOUVEAU_LI.appendChild(NOMBRE);
                    NOUVEAU_UL.appendChild(NOUVEAU_LI);
                    caseActuelle.appendChild(NOUVEAU_UL);
                }
                else { // Sinon, on ajoute à la liste existante
                    // On récupère les notes actuellement dans la liste
                    const NOTES_ACTUELLES = Array.from(caseActuelle.getElementsByTagName("li"));
                    let existeDeja = false;
                    let noteIndex = 0;

                    // On vérifie si la note existe déja dans la liste
                    NOTES_ACTUELLES.forEach((note, index) => {
                        if (note.innerHTML == this.innerHTML) {
                            existeDeja = true;
                            noteIndex = index;
                        }
                    })

                    // Si la note existe déja, on l'enlève de la liste à la place
                    if (existeDeja) {
                        caseActuelle.getElementsByTagName("li")[noteIndex].remove();

                        // Si la liste de notes est vide, on l'enlève aussi
                        if (LISTE_NOTES.getElementsByTagName("li")[0] == undefined) {
                            LISTE_NOTES.remove();
                        }
                    }
                    else {
                        const NOUVEAU_LI = document.createElement("li");
                        const NOMBRE = document.createTextNode(this.innerHTML);
                        NOUVEAU_LI.appendChild(NOMBRE);

                        // On insert la note de manière à ce qu'elle soit dans l'ordre

                        // Pour chaque note existante...
                        let inseree = false;
                        for (i = 0; i < NOTES_ACTUELLES.length; i ++) {

                            // Si la note existante est supérieure à celle à insérer, on insert la note juste avant
                            if (NOTES_ACTUELLES[i].innerHTML > this.innerHTML) {
                                LISTE_NOTES.insertBefore(NOUVEAU_LI, LISTE_NOTES.getElementsByTagName("li")[i]);
                                inseree = true;
                                break;
                            }
                        }

                        // Si la note n'a pas été insérée, on l'insert à la fin de la liste car c'est la note la plus "grande"
                        if (!inseree) {
                            LISTE_NOTES.appendChild(NOUVEAU_LI);
                        }
                    }
                }
            }
            else {
                // Change la valeur de la case cliquée

                // Change la valeur de la case dans le DOM
                caseActuelle.getElementsByTagName("p")[0].innerHTML = this.innerHTML;

                // Change la valeur de la case dans la variable grille
                grille[selectionY][selectionX] = this.innerHTML;

                // Si la case à une liste de notes, on la supprime
                if (LISTE_NOTES != undefined) {
                    LISTE_NOTES.remove();
                }

                // Si la grille est terminée, met fin à la partie
                if (grille.equals(solution)) {
                    endGame();
                }
            }
        }
    }
});

// Lors d'un appui sur une touche du clavier correspondant à une touche du pavé numérique...
document.addEventListener("keydown", (e) => {

    // Si l'appui n'est pas répété (Donc uniquement déclenché une fois)
    if (!e.repeat) {

        // Pour chaque bouton du pavé numérique...
        BOUTONS.forEach(element => {

            // Si la touche appuyée correspond au contenu du bouton,
            // on appelle l'évènement onclick du bouton (défini au dessus)
            if (element.innerHTML == e.key) {
                element.onclick();
            }
        });
    }
});

// Lors d'un clic sur le bouton jeu...
BOUTON_JEU.addEventListener("click", (e) => {

    // Affiche ou masque le menu, et change le texte du bouton
    menuOuvert = !menuOuvert;
    MENU_PARTIE.style.display = menuOuvert ? "flex" : "none";
    BOUTON_JEU.innerHTML = menuOuvert ? "Annuler" : "Nouvelle partie";
});

// Début de partie
async function startGame(element) {
    // Masque la grille
    TABLE.style.display = "none";
    TABLE_VIDE.style.display = "inline-table";

    // Affiche la difficulté choisie
    difficulte = element.children[1].innerHTML;
    TITRE_JEU.innerHTML = 'Jeu solo : Difficulté ' + difficulte;

    // Appelle l'API pour obtenir une grille et l'afficher
    grilleObtenue = await callSudokuAPI(difficulte);

    // Si la grille à bien été obtenue
    if (grilleObtenue) {

        // Ajoute la partie dans la base de données
        // Et retourne son ID (ou 0 si aucun utilisateur connecté) et la série de victoire du joueur avant cette partie
        const RES_PARTIE = await fetch("index.php?controller=partie&action=new", {
            method: "POST",
            headers: {
                    'Content-Type': 'application/json', // Indique qu'on envoie du JSON
                    'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
                },
                body: JSON.stringify({ modeDeJeu: "Solo", difficulte: difficulte}) // Objet JS converti en chaîne JSON
        });
        let resPartie = await RES_PARTIE.json();
        idPartie = resPartie["partieId"];
        serieVictoires = resPartie["serie_victoires"];
        scoreGlobal = resPartie["score_global"];

        // Permet à l'utilisateur d'intéragir avec le plateau de jeu
        CONTENEUR_JEU.style.filter = "none";
        CONTENEUR_JEU.inert = false;

        // Déclare la partie comme commencée
        partieEnCours = true;

        // Configure et démarre le timer
        timerActif = false;
        startTimer();
    }
    else {

        // Affiche le pupup d'erreur
        POPUP_ERREUR.style.display = "flex";
    }
}

// Fin de partie
async function endGame(popup = true) {

    // Déclare la partie comme terminée
    partieEnCours = false;

    // Opacifie la zone de jeu
    CONTENEUR_JEU.style.filter = "opacity(0.40)";

    // Stop le timer
    clearInterval(timerInterval);

    // Empèche l'utilisateur d'intéragir avec le plateau de jeu
    CONTENEUR_JEU.inert = true;

    if (popup) {
        // Détermine si la partie est gagnée ou perdue
        let victoire = timerMinutes < 14 || (timerMinutes == 14 && timerSecondes < 59);

        // Si un joueur est connecté
        if (idPartie != 0) {

            // Met à jour les statistiques du joueur
            // Et retourne son gain ou perte de score global
            let differenceStats = await updateStats(victoire);
            if (differenceStats >= 0) {
                differenceStats = "+" + differenceStats;
            }

            // Ajoute un nouvel élément au DOM pour afficher la différence de score
            valeur = document.createElement("P");
            valeur.innerHTML = differenceStats;
            valeur.classList.add("score_global_valeur", differenceStats >= 0 ? "victoire" : "defaite");
            POPUP_FIN_PARTIE_SCORE_GLOBAL.insertAdjacentElement('afterend', valeur);
            evolution = document.createElement("P");
            let scoreFinal = scoreGlobal + parseInt(differenceStats);
            evolution.innerHTML = scoreGlobal + " --> " + scoreFinal;
            evolution.classList.add("score_golbal_evolution");
            valeur.insertAdjacentElement('afterend', evolution);
        }
        else {
            POPUP_FIN_PARTIE_SCORE_GLOBAL.style.display = "none";
        }

        // Affiche un message de victoire ou défaite selon l'état de la partie quand le popup s'affiche
        POPUP_FIN_PARTIE.style.display = "flex";
        POPUP_FIN_PARTIE_TITRE.innerHTML = (victoire ? "Victoire" : "Défaite") + " !";
        POPUP_FIN_PARTIE_TEXTE.innerHTML = "Partie terminée";


        // Lors du clic sur Rejouer...
        POPUP_FIN_PARTIE_REJOUER.addEventListener("click", (e) => {

            // Masque le popup
            POPUP_FIN_PARTIE.style.display = "none";
            POPUP_DEBUT_PARTIE.style.display = "flex";

             // Si un joueur est connecté
            if (idPartie != 0) {

                // Retire les éléments ajoutés au DOM
                valeur.remove();
                evolution.remove();
            }

            // Remet le timer à 15 minutes
            resetTimer();
        });
    }
}

// Met à jour les statistiques du joueur
async function updateStats(victoire) {
    const RES_STATS = await fetch("index.php?controller=partie&action=end", {
        method: "POST",
        headers: {
                'Content-Type': 'application/json', // Indique qu'on envoie du JSON
                'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
            },
            body: JSON.stringify({ idPartie: idPartie, modeDeJeu: "Solo", difficulte: difficulte, victoire: victoire, timerMinutes: timerMinutes, timerSecondes: timerSecondes, scoreGlobal: scoreGlobal, serieVictoires: serieVictoires}) // Objet JS converti en chaîne JSON
    });
    let resStats = await RES_STATS.json();
    return resStats["difference_score"];
}

// Remet le timer à 15 minutes
function resetTimer() {
    TIMER.innerHTML = "Temps : 15:00";
}

// Force l'attente du sript pendant la durée pasée en paramettres (en milisecondes)
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Démare le timer
async function startTimer() {
    if (timerActif == false) { // Si le timer n'a pas démarré ou est en pause, on le démarre
        // Rends les éléments visibles et interactibles
        TABLE.style.display = "inline-table";
        TABLE_VIDE.style.display = "none";
        TABLE_VIDE.style.filter = "none";
        BOUTON_NOTES.style.filter = "none";
        BOUTON_NOTES.inert = false;
        PAVE.style.filter = "none";
        PAVE.inert = false;

        // Attends une seconde car le timer commence à 14:59 sauf si le timer était en pause
        if (deltaPause == null) {
            await sleep(1000)
        }

        // Démarre le timer
        timerActif = true;
        start = Date.now() - deltaPause;
        timerInterval = setInterval(decreaseTimer, 100);
    }
    else { // Sinon, on le met en pause
        // Rends les éléments légèrement opaques et non-interactibles
        TABLE.style.display = "none";
        TABLE_VIDE.style.display = "inline-table";
        TABLE_VIDE.style.filter = "opacity(0.40)";
        BOUTON_NOTES.style.filter = "opacity(0.40)";
        BOUTON_NOTES.inert = true;
        PAVE.style.filter = "opacity(0.40)";
        PAVE.inert = true;

        // Met le timer en pause
        clearInterval(timerInterval);
        deltaPause = Date.now() - start;
        timerActif = false;
    }
}

// Tant que le timer est actif, on execute cette fonction chaque dixième de seconde
function decreaseTimer() {

    // Calcule le delta entre le moment ou le timer à démarré et le moment ou cette fonction s'exécute
    let delta = Date.now() - start;

    // Calcule les minutes et secondes écoulées
    timerMinutes =  Math.trunc(delta / 1000 / 60);
    timerSecondes =  Math.trunc(delta / 1000);
    if (timerSecondes > 59) {
        timerSecondes -= 60 * timerMinutes;
    }

    // Converti l'affichage pour que le timer soit un décompte
    let affichageMinutes = 14 - timerMinutes;
    let affichageSecondes = 59 - timerSecondes;

    // Affiche le temps
    TIMER.innerText = "Temps : " + (affichageMinutes < 10 ? "0" : "") + affichageMinutes + ":" + (affichageSecondes < 10 ? "0" : "") + affichageSecondes;

    // Met fin à la partie si le temps est écoulé
    if (timerMinutes == 14 && timerSecondes == 59) {
        clearInterval(timerInterval); // Stop le timer
        endGame();
    }
}

// Ajoute la fonction "equals" aux tableaux pour comparer qu'ils sont identiques
// Assume que les tableaux ont la même taille
// tableau => tableau auquel celui qui appelle la fonction sera comparé
Array.prototype.equals = function (tableau) {
    // Si "tableau" n'est pas une valeur correcte, retourne faux
    if (!tableau)
        return false;

    for (let i = 0; i < this.length; i++) {
        // Vérifie si'il y à un tableau imbriqué
        if (this[i] instanceof Array && tableau[i] instanceof Array) {

            // Si oui, execute la fonction sur le tableau imbriqué
            if (!this[i].equals(tableau[i])) {
                return false;
            }

        } // Sinon, vérifie les valeurs du tableau
        else if (this[i] != tableau[i]) {
            return false;
        }
    }
    return true;
}