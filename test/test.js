fetch("api/sudoku.php", {
    method: "POST"
})
.then(res => res.json())
.then(data => {
    console.log("Grille reçue :", data);
})
.catch(err => console.error("Erreur :", err));
