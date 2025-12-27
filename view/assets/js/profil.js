// Constantes
const CONTENEUR_PRINCIPAL = document.getElementById("conteneur_principal");
const BOUTON_MODIFIER_COMPTE = document.getElementById("bouton_modifier");
const BOUTON_ANNULER_MODIFIER_COMPTE = document.getElementById("bouton_annuler_modifier");
const POPUP_MODIFIER_COMPTE = document.getElementById("modifier_compte");
const ERREURS_FORMULAIRES = document.getElementById("erreurs");

// Données initiales des formulaires
const MODIFIER_COMPTE_PSEUDO = document.getElementById("pseudo");
const MODIFIER_COMPTE_PSEUDO_VALEUR = MODIFIER_COMPTE_PSEUDO.placeholder;
const MODIFIER_COMPTE_EMAIL = document.getElementById("email");
const MODIFIER_COMPTE_EMAIL_VALEUR = MODIFIER_COMPTE_EMAIL.placeholder;

// Affiche le popup pour modifier le compte
BOUTON_MODIFIER_COMPTE.addEventListener("click", (e) => {
    openEditAccount();
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
});

// Vérifie qi'il y a des erreurs dans un formulaire
// Si oui, ouvre immédiatement le popup qui contient le formulaire au chargement de la page
if (ERREURS_FORMULAIRES.value !== "") {
    switch (ERREURS_FORMULAIRES.value) {
        case "modifier_compte":
            openEditAccount();
            break;
    }
}

// Ouvre le popup "Modifier informations du compte"
function openEditAccount() {
    POPUP_MODIFIER_COMPTE.style.display = "flex";
    CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
    CONTENEUR_PRINCIPAL.inert = true;
}