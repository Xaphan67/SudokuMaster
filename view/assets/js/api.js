const BUTTON = document.getElementById("test");
BUTTON.addEventListener("click", async (e) => {
    e.preventDefault();

    const GRID_INFO = await getGrid("easy");
    
    TABLE = document.getElementById("grille");

    GRID_INFO.puzzle.forEach(line => {
        let newRow = TABLE.insertRow(-1);
        line.forEach((element, index) => {
            let newCell = newRow.insertCell(index);
            let newNumber = document.createTextNode(element != "0" ? element : "");
            newCell.appendChild(newNumber);
        });
    });
})

async function getGrid() {
    try
    {
        const RES_GRID = await fetch("api/sudoku.php");
        const GRID = await RES_GRID.json();
        
        return GRID;
    }
    catch (err)
    {
        console.error("Erreur lors de la récupération de la gille : ", err)
    }
}