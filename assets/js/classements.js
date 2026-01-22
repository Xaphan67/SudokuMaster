const ONGLETS = document.getElementsByClassName("onglets")[0];
const ONGLET_SOLO = document.getElementById("classements_solo");
const ONGLET_COOPERATIF = document.getElementById("classements_cooperatif");
const ONGLET_COMPETITIF = document.getElementById("classements_competitif");

// Affiche l'onglet "Solo"
ONGLETS.getElementsByTagName("P")[0].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Solo"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        ONGLETS.getElementsByTagName("P")[0].classList.add("onglet_actif");

        // Affiche l'onglet "Solo" et masque les autres onglets
        ONGLET_SOLO.style.display = "block";
        ONGLET_COOPERATIF.style.display = "none";
        ONGLET_COMPETITIF.style.display = "none";
    }
});

// Affiche l'onglet "Cooperatif"
ONGLETS.getElementsByTagName("P")[1].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Cooperatif"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
       ONGLETS.getElementsByTagName("P")[1].classList.add("onglet_actif");

        // Affiche l'onglet "Cooperatif" et masque les autres onglets
        ONGLET_SOLO.style.display = "none";
        ONGLET_COOPERATIF.style.display = "block";
        ONGLET_COMPETITIF.style.display = "none";
    }
});

// Affiche l'onglet "Competitif"
ONGLETS.getElementsByTagName("P")[2].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Competitif"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        ONGLETS.getElementsByTagName("P")[2].classList.add("onglet_actif");

        // Affiche l'onglet "Competitif" et masque les autres onglets
        ONGLET_SOLO.style.display = "none";
        ONGLET_COOPERATIF.style.display = "none";
        ONGLET_COMPETITIF.style.display = "block";
    }
});