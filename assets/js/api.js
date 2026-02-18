// Appel l'API pour charger une grille à la fin du chargement de la page
// puis l'afficher ainssi que sa difficulté
async function callSudokuAPI(difficulte) {
    // Constantes
    const TABLE = document.getElementById("grille");
    const GRID_INFO = await getGrid();

    // Si la grille à bien été obtenue via l'API
    if (GRID_INFO) {

        // Vide la table contenant la grille en cas de nouvelle partie
        TABLE.innerHTML = "";

        // Parcours la grille renvoyée par l'API et l'affiche dans un tableau
        GRID_INFO[difficulte.toLowerCase()].forEach((line, ligneIndex) => {
            let nouvelleLigne = TABLE.insertRow(-1);
            line.forEach((element, coloneIndex) => {
                let nouvelleCellule = nouvelleLigne.insertCell(coloneIndex);
                if (((ligneIndex < 3 || ligneIndex >= 6) && coloneIndex >= 3 && coloneIndex < 6) || (ligneIndex >= 3 && ligneIndex < 6 && (coloneIndex < 3 || coloneIndex >= 6))) {
                    nouvelleCellule.className = 'celluleBleue';
                }
                if (element != "0") {
                    nouvelleCellule.classList.add("celluleFixe")
                } else {
                    nouvelleCellule.tabIndex = 0; // Permet de focus les cellules modifiables
                }
                const NOUVEAU_P = document.createElement("p");
                NOUVEAU_P.inert = true;
                const NOMBRE = document.createTextNode(element != "0" ? element : "");
                NOUVEAU_P.appendChild(NOMBRE);
                nouvelleCellule.appendChild(NOUVEAU_P);
            });
        });

        // Stocke la grille et sa solution dans des variables pour travailler dessus plus tard
        grille = GRID_INFO[difficulte.toLowerCase()];
        solution = GRID_INFO.solution;

        // Retourne vrai
        return true;
    }
    else {

        // Retourne faux
        return false;
    }
}

// Récupère les informations d'une grille grâce à un appel API
async function getGrid() {
    try
    {
        const RES_GRID = await fetch("index.php?controller=api-partie&action=getGrid", {
            method: 'POST',
            headers: {
                'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
            }
        });
        const GRID = await RES_GRID.json();

        return GRID;
    }
    catch (err)
    {
        return false;
    }
}