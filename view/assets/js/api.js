// Appel l'API pour charger une grille à la fin du chargement de la page
// puis l'afficher ainssi que sa difficulté
addEventListener("DOMContentLoaded", async (e) => {
    e.preventDefault();

    // Constantes
    const DIFFICULTE = document.getElementById("difficulte");
    const DIFFICULTE_FR = {easy: 'Facile', medium: 'Moyen', hard: 'Difficile'};
    const TABLE = document.getElementById("grille");
    const GRID_INFO = await getGrid();

    // Récupère la difficulté de la grille renvoyée par l'API, et la traduit en français à l'aide du tableau DIFFICULTE_FR
    DIFFICULTE.innerHTML = DIFFICULTE_FR[GRID_INFO.difficulty];

    // Parcours la grille renvoyée par l'API et l'affiche dans un tableau
    GRID_INFO.puzzle.forEach(line => {
        let newRow = TABLE.insertRow(-1);
        line.forEach((element, index) => {
            let newCell = newRow.insertCell(index);
            let newNumber = document.createTextNode(element != "0" ? element : "");
            newCell.appendChild(newNumber);
        });
    });
    TABLE.style.display = "inline-table";
})

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
            body: JSON.stringify({ difficulte: 'easy'}) // Objet JS converti en chaîne JSON
        });
        const GRID = await RES_GRID.json();

        return GRID;
    }
    catch (err)
    {
        console.error("Erreur lors de la récupération de la gille : ", err)
    }
}