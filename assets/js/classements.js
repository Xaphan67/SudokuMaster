const CONTENEUR_PRINCIPAL = document.getElementById("conteneur_principal");
const ONGLETS = document.getElementsByClassName("onglets")[0];
const ONGLET_SOLO = document.getElementById("classements_solo");
const ONGLET_COOPERATIF = document.getElementById("classements_cooperatif");
const ONGLET_COMPETITIF = document.getElementById("classements_competitif");
const POPUPS_MOBILE = Array.from(document.getElementsByClassName("info_joueur_mobile"));
const PLACES_TOP_3_SOLO_MOBILE = Array.from(document.getElementById("classements_solo").getElementsByClassName("top_3")[0].getElementsByTagName("div"));
const PLACES_TOP_10_SOLO_MOBILE = Array.from(document.getElementById("classements_solo").getElementsByClassName("top_10")[0].getElementsByTagName("div"));
const PLACES_TOP_3_COOPERATIF_MOBILE = Array.from(document.getElementById("classements_cooperatif").getElementsByClassName("top_3")[0].getElementsByTagName("div"));
const PLACES_TOP_10_COOPERATIF_MOBILE = Array.from(document.getElementById("classements_cooperatif").getElementsByClassName("top_10")[0].getElementsByTagName("div"));
const PLACES_TOP_3_COMPETITIF_MOBILE = Array.from(document.getElementById("classements_competitif").getElementsByClassName("top_3")[0].getElementsByTagName("div"));
const PLACES_TOP_10_COMPETITIF_MOBILE = Array.from(document.getElementById("classements_competitif").getElementsByClassName("top_10")[0].getElementsByTagName("div"));

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

// Affiche les statistiques du joueur sur lequel l'utilisateur à cliqué
PLACES_TOP_3_SOLO_MOBILE.forEach((place, index) => {
    place.addEventListener("click", (e) => {
        const POPUP_INFOS = document.getElementById("infos-" + index + "-1");

        // Si la place est occupée par un joueur
        // affiche le popup correspondant
        if (POPUP_INFOS != undefined) {
            CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
            CONTENEUR_PRINCIPAL.inert = true;
            POPUP_INFOS.style.display = "flex";
        }
    });
});

PLACES_TOP_10_SOLO_MOBILE.forEach((place, index) => {
    place.addEventListener("click", (e) => {
        const POPUP_INFOS = document.getElementById("infos-" + (index + 3)+ "-1");

        // Si la place est occupée par un joueur
        // affiche le popup correspondant
        if (POPUP_INFOS != undefined) {
            CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
            CONTENEUR_PRINCIPAL.inert = true;
            POPUP_INFOS.style.display = "flex";
        }
    });
});

PLACES_TOP_3_COOPERATIF_MOBILE.forEach((place, index) => {
    place.addEventListener("click", (e) => {
        const POPUP_INFOS = document.getElementById("infos-" + index + "-2");

        // Si la place est occupée par un joueur
        // affiche le popup correspondant
        if (POPUP_INFOS != undefined) {
            CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
            CONTENEUR_PRINCIPAL.inert = true;
            POPUP_INFOS.style.display = "flex";
        }
    });
});

PLACES_TOP_10_COOPERATIF_MOBILE.forEach((place, index) => {
    place.addEventListener("click", (e) => {
        const POPUP_INFOS = document.getElementById("infos-" + (index + 3) + "-2");

        // Si la place est occupée par un joueur
        // affiche le popup correspondant
        if (POPUP_INFOS != undefined) {
            CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
            CONTENEUR_PRINCIPAL.inert = true;
            POPUP_INFOS.style.display = "flex";
        }
    });
});

PLACES_TOP_3_COMPETITIF_MOBILE.forEach((place, index) => {
    place.addEventListener("click", (e) => {
        const POPUP_INFOS = document.getElementById("infos-" + index + "-3");

        // Si la place est occupée par un joueur
        // affiche le popup correspondant
        if (POPUP_INFOS != undefined) {
            CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
            CONTENEUR_PRINCIPAL.inert = true;
            POPUP_INFOS.style.display = "flex";
        }
    });
});

PLACES_TOP_10_COMPETITIF_MOBILE.forEach((place, index) => {
    place.addEventListener("click", (e) => {
        const POPUP_INFOS = document.getElementById("infos-" + (index + 3) + "-3");

        // Si la place est occupée par un joueur
        // affiche le popup correspondant
        if (POPUP_INFOS != undefined) {
            CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
            CONTENEUR_PRINCIPAL.inert = true;
            POPUP_INFOS.style.display = "flex";
        }
    });
});

// Ferme un popup affiché
POPUPS_MOBILE.forEach(popup => {
    const BOUTON = popup.getElementsByClassName("bouton")[0];
    BOUTON.addEventListener("click", () => {
        CONTENEUR_PRINCIPAL.style.filter = "none";
        CONTENEUR_PRINCIPAL.inert = false;
        popup.style.display = "none";
    });
})