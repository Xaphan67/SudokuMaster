const TABLE = document.getElementById("grille");
const PAVE = document.getElementById("pave_numerique");
const BOUTONS =  Array.prototype.slice.call(PAVE.getElementsByTagName("p"));

let caseActuelle = null;

// Stocke la case sur laquelle l'utilisateur à cliqué
TABLE.addEventListener("click", (e) => {
    const ELEMENT_CLICK = e.target;
    const CELLULES = Array.prototype.slice.call(TABLE.getElementsByTagName("td"));
    if (ELEMENT_CLICK.nodeName == "TD") {
        caseActuelle = ELEMENT_CLICK;
        ELEMENT_CLICK.classList.add("selected_highlight");
        
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
        if (caseActuelle != null) {
            caseActuelle.innerHTML = this.innerHTML;
        }
    }
})