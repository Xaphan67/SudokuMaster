const TABLE = document.getElementById("grille");
const PAVE = document.getElementById("pave_numerique");
const BOUTONS =  Array.prototype.slice.call(PAVE.getElementsByTagName("p"));

let difficulte = 1;
let caseActuelle = null;
let case_focus = null;

// Séléction de la difficulté
const TITRE_JEU = document.getElementById("titre_jeu");
const POPUP_DIFFICULTE = document.getElementById("choix_difficulte");
const POPUP_BOUTONS_DIFFICULTE = Array.prototype.slice.call(document.getElementById("boutons_difficulte").getElementsByTagName("div"));
POPUP_BOUTONS_DIFFICULTE.forEach(element => {
    element.onclick=function() {
        difficulte = element.children[1].innerHTML;
        POPUP_DIFFICULTE.style.display = "none";
        TITRE_JEU.innerHTML += ' : Difficulté ' + difficulte;
        callSudokuAPI();
    }
})

// Stocke la case sur laquelle l'utilisateur à cliqué
TABLE.addEventListener("click", (e) => {
    case_focus = e.target;
    const CELLULES = Array.prototype.slice.call(TABLE.getElementsByTagName("td"));
    if (case_focus.nodeName == "TD") {
        caseActuelle = case_focus;
        case_focus.classList.add("selected_highlight");
        
         // Color toutes les cellules autres que celle selectionnée
            CELLULES.forEach(cellule => {
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

// Change la valeur de la case cliquée lors d'un click sur un des boutons du pavé numérique
BOUTONS.forEach(element => {
    element.onclick=function() {
        if (caseActuelle != null && !case_focus.classList.contains("celluleFixe")) {
            caseActuelle.innerHTML = this.innerHTML;
        }
    }
})