const TABLE = document.getElementById("grille");
const PAVE = document.getElementById("pave_numerique");
const BOUTONS =  Array.prototype.slice.call(PAVE.getElementsByTagName("p"));

let caseActuelle = null;

// Stocke la case sur laquelle l'utilisateur à cliqué
TABLE.addEventListener("click", (e) => {
    const ELEMENT_CLICK = e.target;
    if (ELEMENT_CLICK.nodeName == "TD") {
        caseActuelle = ELEMENT_CLICK;
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