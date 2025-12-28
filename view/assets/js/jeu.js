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
const MENU_PARTIE_BOUTONS_DIFFICULTE = Array.from(document.getElementsByClassName("boutons_difficulte")[0].getElementsByTagName("div"));
const TITRE_JEU = document.getElementById("titre_jeu");
const POPUP_DEBUT_PARTIE = document.getElementById("debut_partie");
const POPUP_BOUTONS_DIFFICULTE = Array.from(document.getElementsByClassName("boutons_difficulte")[1].getElementsByTagName("div"));
const POPUP_FIN_PARTIE = document.getElementById("fin_partie");
const POPUP_FIN_PARTIE_TITRE = POPUP_FIN_PARTIE.getElementsByTagName("h3")[0];
const POPUP_FIN_PARTIE_TEXTE = POPUP_FIN_PARTIE.getElementsByTagName("p")[0];
const POPUP_FIN_PARTIE_RJOUER = POPUP_FIN_PARTIE.getElementsByTagName("div")[0];
const NOTES = document.getElementById("notes");
const TIMER = document.getElementById("timer");
const UTILISATEUR_CONNECTE = document.getElementById("session_utilisateur");

// Variables
// DOM
let difficulte = null;
let caseActuelle = null;
let case_focus = null;

// Partie
let id_partie = null;

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

// Mode Notes
let modeNotes = false;

// Menu Bouton Jeu
let menuOuvert = false;

// Séléction de la difficulté via popop début de partie
POPUP_BOUTONS_DIFFICULTE.forEach(element => {
    element.onclick= function() {
        // Masque le popup
        POPUP_DEBUT_PARTIE.style.display = "none";

        // Démarre la partie
        startGame(element);
    }
});

// Séléction de la difficulté via le menu
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
        // Vérifie que la case actuelle n'est pas nulle et qu'elle peux être modifiée par le joueur
        if (caseActuelle != null && !case_focus.classList.contains("celluleFixe")) {
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

    // Ajoute la partie dans la base de données
    // Et retourne son ID (ou 0 si aucun utilisateur connecté)
    const RES_PARTIE = await fetch("index.php?controller=partie&action=new", {
        method: "POST",
        headers: {
                'Content-Type': 'application/json', // Indique qu'on envoie du JSON
                'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
            },
            body: JSON.stringify({ modeDeJeu: "Solo", difficulte: difficulte}) // Objet JS converti en chaîne JSON
    });
    id_partie = await RES_PARTIE.json();

    // Appelle l'API pour obtenir une grille et l'afficher
    callSudokuAPI(difficulte);

    // Configure et démarre le timer
    timerActif = false;
    timerMinutes = 14;
    timerSecondes = 59;
    startTimer();
}

// Fin de partie
function endGame(popup = true) {
    CONTENEUR_JEU.style.filter = "opacity(0.40)";

    // Stop le timer
    clearInterval(timerId);

    // Empèche l'utilisateur d'intéragir avec le plateau de jeu
    CONTENEUR_JEU.inert = true;

    if (popup) {
        // Affiche un message de victoire ou défaite selon l'état de la partie quand le popup s'affiche
        let timerNonEcoule = timerMinutes > 0 || (timerMinutes == 0 && timerSecondes > 0);
        POPUP_FIN_PARTIE.style.display = "flex";
        POPUP_FIN_PARTIE_TITRE.innerHTML = (timerNonEcoule ? "Victoire" : "Défaite") + " !";
        POPUP_FIN_PARTIE_TEXTE.innerHTML = "Partie terminée";

        // Lors du clic sur Rejouer...
        POPUP_FIN_PARTIE_RJOUER.addEventListener("click", (e) => {

            // Masque le popup
            POPUP_FIN_PARTIE.style.display = "none";
            POPUP_DEBUT_PARTIE.style.display = "flex";

            // Remet le timer à 15 minutes
            resetTimer();
        });
    }
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

// Tant que le timer est actif, on execute cette fonction chaque seconde
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