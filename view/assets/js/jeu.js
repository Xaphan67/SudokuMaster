// Constantes
const CONTENEUR_JEU = document.getElementById("conteneur_jeu");
const TABLE = document.getElementById("grille");
const TABLE_VIDE = document.getElementById("grille_vide");
const PAVE = document.getElementById("pave_numerique");
const BOUTONS =  Array.prototype.slice.call(PAVE.getElementsByTagName("p"));
const BOUTON_NOTES = document.getElementById("interface_de_jeu").getElementsByTagName("div")[1];
const BOUTON_PAUSE_TIMER = document.getElementById("interface_de_jeu").getElementsByTagName("div")[3];
const TITRE_JEU = document.getElementById("titre_jeu");
const POPUP_DIFFICULTE = document.getElementById("choix_difficulte");
const POPUP_BOUTONS_DIFFICULTE = Array.prototype.slice.call(document.getElementById("boutons_difficulte").getElementsByTagName("div"));
const POPUP_FIN_PARTIE = document.getElementById("fin_partie");
const POPUP_FIN_PARTIE_TITRE = POPUP_FIN_PARTIE.getElementsByTagName("h3")[0];
const POPUP_FIN_PARTIE_TEXTE = POPUP_FIN_PARTIE.getElementsByTagName("p")[0];
const POPUP_FIN_PARTIE_RJOUER = POPUP_FIN_PARTIE.getElementsByTagName("div")[0];
const TIMER = document.getElementById("timer");

// Variables
// DOM
let difficulte = null;
let caseActuelle = null;
let case_focus = null;

// Timer
let timerActif;
let timerMinutes;
let timerSecondes;
let timerId = -1;

// Grille
let grille = [];
let solution = [];
let selectionX = null;
let selectionY = null;

// Séléction de la difficulté
POPUP_BOUTONS_DIFFICULTE.forEach(element => {
    element.onclick= function() {
        // Affiche la difficulté choisie
        difficulte = element.children[1].innerHTML;
        POPUP_DIFFICULTE.style.display = "none";
        TITRE_JEU.innerHTML = 'Jeu solo : Difficulté ' + difficulte;

        // Appelle l'API pour obtenir une grille
        callSudokuAPI(difficulte);

        // Configure et démarre le timer
        timerActif = false;
        timerMinutes = 14;
        timerSecondes = 59;
        startTimer();
    }
})

// Stocke la case sur laquelle l'utilisateur à cliqué
TABLE.addEventListener("click", (e) => {
    let cellules = Array.prototype.slice.call(TABLE.getElementsByTagName("td"));
    case_focus = e.target;
    if (case_focus.nodeName == "TD") {
        caseActuelle = case_focus;

        // Récupère les coordonnées de la case cliquée
        selectionX = caseActuelle.cellIndex;
        selectionY = caseActuelle.parentNode.rowIndex;

        // Met la case en surbrillance
        case_focus.classList.add("selected_highlight");

         // Color toutes les cellules autres que celle selectionnée
            cellules.forEach(cellule => {
                if (cellule != e.target && e.target != 0) {
                    cellule.classList.remove("selected_highlight");
                    // si la cellule n'a pas le même chiffre que celle selectionné et qu'elle a la classe selected
                    if (cellule.innerHTML != e.target.innerHTML && cellule.classList.contains("selected")) {
                        //on enlève la classe selected
                        cellule.classList.remove("selected");
                    }
                    // si la cellule a le même chiffre que celle selectionnée et que ce n'est pas vide
                    if (cellule.innerHTML == e.target.innerHTML && e.target.innerHTML != 0) {
                        cellule.classList.add("selected");
                        cellule.classList.remove("selected_highlight");
                    }
                }
            });

    }
})

// Lors d'un clic sur le bouton pause...
BOUTON_PAUSE_TIMER.addEventListener("click", (e) => {
    startTimer();
})

// Lors d'un clic sur un des boutons du pavé numérique...
BOUTONS.forEach(element => {
    element.onclick=function() {
        // Change la valeur de la case cliquée
        if (caseActuelle != null && !case_focus.classList.contains("celluleFixe")) {

            // Change la valeur de la case dans le DOM
            caseActuelle.innerHTML = this.innerHTML;

            // Change la valeur de la case dans la variable grille
            grille[selectionY][selectionX] = this.innerHTML;
        }

        // Vérifie que la grille est terminée
        let grilleTermine = true;
        for (i = 0; i < 9; i ++) {
            for (j = 0; j < 9; j ++) {
                // Si au moins une valeur de la grille est différente de sa valeur correspondante dans la solution
                // La grille n'est pas terminée
                if (grille[i][j] != solution[i][j])
                {
                    grilleTermine = false;
                    break;
                }
            }
            // Sort de la boucle si la grille n'est pas terminée
            if (!grilleTermine) {
                break;
            }
        }

        // Si la grille est terminée...
        if (grilleTermine) {
            endGame();
        }
    }
})

// Fin de partie
function endGame() {
    CONTENEUR_JEU.style.filter = "opacity(0.40)";
    POPUP_FIN_PARTIE.style.display = "flex";

    // Stop le timer
    clearInterval(timerId);

    // Empèche l'utilisateur d'intéragir avec le plateau de jeu
    CONTENEUR_JEU.inert = true;

    // Affiche un message de victoire ou défaite selon l'état de la partie quand le popup s'affiche
    let timerNonEcoule = timerMinutes > 0 || (timerMinutes == 0 && timerSecondes > 0);
    POPUP_FIN_PARTIE_TITRE.innerHTML = (timerNonEcoule ? "Victoire" : "Défaite") + " !";
    POPUP_FIN_PARTIE_TEXTE.innerHTML = "Partie terminée";

    // Lors du clic sur Rejouer...
    POPUP_FIN_PARTIE_RJOUER.addEventListener("click", (e) => {

        // Masque le popup
        POPUP_FIN_PARTIE.style.display = "none";
        POPUP_DIFFICULTE.style.display = "flex";

        // Remet le timer à 15 minutes
        TIMER.innerHTML = "Temps : 15:00";
    })
}

// Force l'attente du sript pendant la durée pasée en paramettres (en milisecondes)
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Démare le timer
async function startTimer() {
    // Attends que l'API ait envoyé la grille (le filtre sur conteneur_jeu passe à "none")
    while (CONTENEUR_JEU.style.filter != "none") {
        await sleep()
    }

    if (timerActif == false) { // Si le timer n'a pas démarré ou est en pause, on le démarre
        // Rends les éléments visibles et interactibles
        TABLE.style.display = "inline-table";
        TABLE_VIDE.style.display = "none";
        TABLE_VIDE.style.filter = "none";
        BOUTON_NOTES.style.filter = "none";
        BOUTON_NOTES.inert = false;
        PAVE.style.filter = "none";
        PAVE.inert = false;

        // Démarre le timer
        timerActif = true;
        timerId = setInterval(decreaseTimer, 1000); // Décompte les secondes
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
        clearInterval(timerId);
        timerActif = false;
    }
}

function decreaseTimer() {
    TIMER.innerText = "Temps : " + (timerMinutes < 10 ? "0" + timerMinutes : timerMinutes) + ':' + (timerSecondes < 10 ? "0" + timerSecondes : timerSecondes); // Affiche la valeur du timer

    // Si le timer des secondes est égal à 0
    if (timerSecondes == 0) {

        // Si les minutes sont à zero
        if (timerMinutes == 0) {
            clearInterval(timerId); // Stop le timer
            endGame();
        }
        else {
            timerMinutes--; // Retire une minute
            timerSecondes = 60; // Remet les secondes à 60
        }
    }
    timerSecondes--; // Retire une seconde
}