// Constantes
const CONTENEUR_PRINCIPAL = document.getElementById("conteneur_principal");
const BOUTON_MODIFIER_COMPTE = document.getElementById("bouton_modifier");
const BOUTON_SUPPRIMER_COMPTE = document.getElementById("bouton_supprimer");
const BOUTON_ANNULER_MODIFIER_COMPTE = document.getElementById("bouton_annuler_modifier");
const BOUTON_ANNULER_SUPPRIMER_COMPTE = document.getElementById("bouton_annuler_supprimer");
const POPUP_MODIFIER_COMPTE = document.getElementById("modifier_compte");
const POPUP_SUPPRIMER_COMPTE = document.getElementById("supprimer_compte");
const ERREURS_FORMULAIRES = document.getElementById("erreurs");
const MODIFIER_COMPTE_PSEUDO = document.getElementById("pseudo");
const MODIFIER_COMPTE_PSEUDO_VALEUR = MODIFIER_COMPTE_PSEUDO.placeholder;
const MODIFIER_COMPTE_EMAIL = document.getElementById("email");
const MODIFIER_COMPTE_EMAIL_VALEUR = MODIFIER_COMPTE_EMAIL.placeholder;
const MODIFIER_COMPTE_MDP = document.getElementById("mdp");
const MODIFIER_COMPTE_MDP_CONFIRM = document.getElementById("mdp_confirm");
const MODIFIER_COMPTE_MDP_CHECK = document.getElementById("modifier_compte_mdp_check");
const SUPPRIMER_COMPTE_MDP_CHECK = document.getElementById("supprimer_compte_mdp_check");

const ONGLETS = document.getElementsByClassName("onglets")[0];
const ONGLET_STATISTIQUES_SOLO = document.getElementById("statistiques_solo");
const ONGLET_STATISTIQUES_COOPERATIF = document.getElementById("statistiques_cooperatif");
const ONGLET_STATISTIQUES_COMPETITIF = document.getElementById("statistiques_competitif");

// Affiche le popup pour modifier le compte
BOUTON_MODIFIER_COMPTE.addEventListener("click", (e) => {
    openEditAccount();
});

// Affiche le popup pour supprimer le compte
BOUTON_SUPPRIMER_COMPTE.addEventListener("click", (e) => {
    openDeleteAccount();
});

// Ferme le popup pour modifier le compte
BOUTON_ANNULER_MODIFIER_COMPTE.addEventListener("click", (e) => {
    // Cache le popup
    POPUP_MODIFIER_COMPTE.style.display = "none";
    CONTENEUR_PRINCIPAL.style.filter = "none";
    CONTENEUR_PRINCIPAL.inert = false;

    // Retire l'affichage des erreurs si l'utilisateur rouvre le popup plus tard
    Array.from(document.getElementsByClassName("erreur")).forEach(erreur => {
        erreur.innerHTML = "";
    });

    // Restaure les données initiales du formulaire si l'utilisateur rouvre le popup plus tard
    MODIFIER_COMPTE_PSEUDO.value = MODIFIER_COMPTE_PSEUDO_VALEUR;
    MODIFIER_COMPTE_EMAIL.value = MODIFIER_COMPTE_EMAIL_VALEUR;
    MODIFIER_COMPTE_MDP.value = "";
    MODIFIER_COMPTE_MDP_CONFIRM.value = "";
    MODIFIER_COMPTE_MDP_CHECK.value = "";
});

// Ferme le popup pour supprimer le compte
BOUTON_ANNULER_SUPPRIMER_COMPTE.addEventListener("click", (e) => {
    // Cache le popup
    POPUP_SUPPRIMER_COMPTE.style.display = "none";
    CONTENEUR_PRINCIPAL.style.filter = "none";
    CONTENEUR_PRINCIPAL.inert = false;

    // Retire l'affichage des erreurs si l'utilisateur rouvre le popup plus tard
    Array.from(document.getElementsByClassName("erreur")).forEach(erreur => {
        erreur.innerHTML = "";
    });

    // Restaure les données initiales du formulaire si l'utilisateur rouvre le popup plus tard
    SUPPRIMER_COMPTE_MDP_CHECK.value = "";
});

// Vérifie qi'il y a des erreurs dans un formulaire
// Si oui, ouvre immédiatement le popup qui contient le formulaire au chargement de la page
if (ERREURS_FORMULAIRES.value !== "") {
    switch (ERREURS_FORMULAIRES.value) {
        case "modifier_compte":
            openEditAccount();
            break;
        case "supprimer_compte":
            openDeleteAccount();
            break;
    }
}

// Affiche les statistiques du mode Solo
ONGLETS.getElementsByTagName("P")[0].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet Solo
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet Solo et masque les autres onglets
        ONGLET_STATISTIQUES_SOLO.style.display = "flex";
        ONGLET_STATISTIQUES_COOPERATIF.style.display = "none";
        ONGLET_STATISTIQUES_COMPETITIF.style.display = "none";
    }
});

// Affiche les statistiques du mode Coopératif
ONGLETS.getElementsByTagName("P")[1].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet Coopératif
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet Coopératif et masque les autres onglets
        ONGLET_STATISTIQUES_SOLO.style.display = "none";
        ONGLET_STATISTIQUES_COOPERATIF.style.display = "flex";
        ONGLET_STATISTIQUES_COMPETITIF.style.display = "none";
    }
});

// Affiche les statistiques du mode Compétitif
ONGLETS.getElementsByTagName("P")[2].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet Compétitif
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet Compétitif et masque les autres onglets
        ONGLET_STATISTIQUES_SOLO.style.display = "none";
        ONGLET_STATISTIQUES_COOPERATIF.style.display = "none";
        ONGLET_STATISTIQUES_COMPETITIF.style.display = "flex";
    }
});

// Ouvre le popup "Modifier informations du compte"
function openEditAccount() {
    POPUP_MODIFIER_COMPTE.style.display = "flex";
    CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
    CONTENEUR_PRINCIPAL.inert = true;
}

// Ouvre le popup "Supprimer le compte"
function openDeleteAccount() {
    POPUP_SUPPRIMER_COMPTE.style.display = "flex";
    CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
    CONTENEUR_PRINCIPAL.inert = true;
}