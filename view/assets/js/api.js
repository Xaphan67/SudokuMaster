let difficulteEN = 'easy';

// Appel l'API pour charger une grille à la fin du chargement de la page
// puis l'afficher ainssi que sa difficulté
async function callSudokuAPI() {
    // Constantes
    const TABLE = document.getElementById("grille");
    const TABLE_VIDE = document.getElementById("grille_vide");
    const CONTENEUR_JEU = document.getElementById("conteneur_jeu");
    const GRID_INFO = await getGrid();
    
    // Récupère la difficulté choisie par l'utilisateur et la traduit pour l'envoyer à l'API
    const DIFFICULTE_EN = {Facile: 'easy', Moyen: 'medium', Difficile: 'hard'};
    difficulteEN = DIFFICULTE_EN[difficulte];

    // Parcours la grille renvoyée par l'API et l'affiche dans un tableau
    GRID_INFO.puzzle.forEach((line, lineIndex) => {
        let newRow = TABLE.insertRow(-1);
        line.forEach((element, colIindex) => {
            let newCell = newRow.insertCell(colIindex);
            if (((lineIndex < 3 || lineIndex >= 6) && colIindex >= 3 && colIindex < 6) || (lineIndex >= 3 && lineIndex < 6 && (colIindex < 3 || colIindex >= 6))) {
                newCell.className = 'celluleBleue';
            }
            newNumber = document.createTextNode(element != "0" ? element : "");
            if (element != "0") {
                newCell.classList.add("celluleFixe")
            }
            newCell.appendChild(newNumber);
        });
    });
    TABLE.style.display = "inline-table";
    TABLE_VIDE.style.display = "none";
    CONTENEUR_JEU.style.filter = "none";
}

// Récupère les informations d'une grille grâce à un appel API
async function getGrid() {
    try
    {
        const RES_GRID = await fetch("api/sudoku.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Indique qu'on envoie du JSON
                'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
            },
            body: JSON.stringify({ difficulte: difficulteEN}) // Objet JS converti en chaîne JSON
        });
        const GRID = await RES_GRID.json();

        return GRID;
    }
    catch (err)
    {
        console.error("Erreur lors de la récupération de la gille : ", err)
    }
}