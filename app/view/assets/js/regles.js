const ONGLETS = document.getElementsByClassName("onglets")[0];
const ONGLET_GENERALITES = document.getElementById("regles_generalites");
const ONGLET_REPETEZ = document.getElementById("regles_repetez");
const ONGLET_PROCESSUS = document.getElementById("regles_processus");

// Affiche l'onglet "Généralités"
ONGLETS.getElementsByTagName("P")[0].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Généralités"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet "Généralités" et masque les autres onglets
        ONGLET_GENERALITES.style.display = "flex";
        ONGLET_REPETEZ.style.display = "none";
        ONGLET_PROCESSUS.style.display = "none";
    }
});

// Affiche l'onglet "Ne répétez aucun numéro"
ONGLETS.getElementsByTagName("P")[1].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Ne répétez aucun numéro"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet "Ne répétez aucun numéro" et masque les autres onglets
        ONGLET_GENERALITES.style.display = "none";
        ONGLET_REPETEZ.style.display = "flex";
        ONGLET_PROCESSUS.style.display = "none";
    }
});

// Affiche l'onglet "Processus d'élimination"
ONGLETS.getElementsByTagName("P")[2].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Processus d'élimination"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet "Processus d'élimination" et masque les autres onglets
        ONGLET_GENERALITES.style.display = "none";
        ONGLET_REPETEZ.style.display = "none";
        ONGLET_PROCESSUS.style.display = "flex";
    }
});