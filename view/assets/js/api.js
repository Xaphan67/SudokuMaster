let difficulteEN = null;

// Appel l'API pour charger une grille à la fin du chargement de la page
// puis l'afficher ainssi que sa difficulté
async function callSudokuAPI(difficulte) {
    // Constantes
    const TABLE = document.getElementById("grille");
    const CONTENEUR_JEU = document.getElementById("conteneur_jeu");
    const GRID_INFO = await getGrid();

    // Si la grille à bien été obtenue via l'API
    if (GRID_INFO) {

        // Récupère la difficulté choisie par l'utilisateur et la traduit pour l'envoyer à l'API
        const DIFFICULTE_EN = {Facile: 'easy', Moyen: 'medium', Difficile: 'hard'};
        difficulteEN = DIFFICULTE_EN[difficulte];

        // Vide la table contenant la grille en cas de nouvelle partie
        TABLE.innerHTML = "";

        // Parcours la grille renvoyée par l'API et l'affiche dans un tableau
        GRID_INFO[difficulteEN].forEach((line, ligneIndex) => {
            let nouvelleLigne = TABLE.insertRow(-1);
            line.forEach((element, coloneIndex) => {
                let nouvelleCellule = nouvelleLigne.insertCell(coloneIndex);
                if (((ligneIndex < 3 || ligneIndex >= 6) && coloneIndex >= 3 && coloneIndex < 6) || (ligneIndex >= 3 && ligneIndex < 6 && (coloneIndex < 3 || coloneIndex >= 6))) {
                    nouvelleCellule.className = 'celluleBleue';
                }
                if (element != "0") {
                    nouvelleCellule.classList.add("celluleFixe")
                }
                const NOUVEAU_P = document.createElement("p");
                NOUVEAU_P.inert = true;
                const NOMBRE = document.createTextNode(element != "0" ? element : "");
                NOUVEAU_P.appendChild(NOMBRE);
                nouvelleCellule.appendChild(NOUVEAU_P);
            });
        });

        // Stocke la grille et sa solution dans des variables pour travailler dessus plus tard
        grille = GRID_INFO[difficulteEN];
        solution = GRID_INFO.data;

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
        return false;
    }
}