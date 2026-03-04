const ONGLETS = document.getElementsByClassName("onglets")[0];
const ONGLET_GENERALITES = document.getElementById("regles_generalites");
const ONGLET_REPETEZ = document.getElementById("regles_repetez");
const ONGLET_PROCESSUS = document.getElementById("regles_processus");

// Affiche l'onglet "Généralités"
ONGLETS.getElementsByTagName("P")[0].addEventListener("click", (e) => {
    switchTab(e, 1);
});

ONGLETS.getElementsByTagName("P")[0].addEventListener("focus", (e) => {
    switchTab(e, 1);
});

// Affiche l'onglet "Ne répétez aucun numéro"
ONGLETS.getElementsByTagName("P")[1].addEventListener("click", (e) => {
    switchTab(e, 2);
});

ONGLETS.getElementsByTagName("P")[1].addEventListener("focus", (e) => {
    switchTab(e, 2);
});

// Affiche l'onglet "Processus d'élimination"
ONGLETS.getElementsByTagName("P")[2].addEventListener("click", (e) => {
    switchTab(e, 3);
});

ONGLETS.getElementsByTagName("P")[2].addEventListener("focus", (e) => {
    switchTab(e, 3);
});

function switchTab(element, tab) {
    if (!element.target.classList.contains("onglet_actif")) {

        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet actuel
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        element.target.classList.add("onglet_actif");

        // Affiche l'onglet actuel et masque les autres onglets
        ONGLET_GENERALITES.style.display = tab == 1 ? "flex" : "none";
        ONGLET_REPETEZ.style.display = tab == 2 ? "flex" : "none";
        ONGLET_PROCESSUS.style.display = tab == 3 ? "flex" : "none";
    }
}