// Constantes
const CONTENEUR_PRINCIPAL = document.getElementById("conteneur_principal");
const CHAMP_EMAIL = document.getElementById("email");
const BOUTON_ENVOI_FORMULAIRE = document.getElementsByClassName("bouton")[0];

// Lors du clic sur le bouton, vérifie que l'email est dans un format valide
// et rends la page inert et opaque le temps que le popup d'email envoyé s'affiche
BOUTON_ENVOI_FORMULAIRE.addEventListener("click", (e) => {
    let regex = /[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?/i;
    if (CHAMP_EMAIL.value != "" && regex.test(CHAMP_EMAIL.value)) {
        CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
        CONTENEUR_PRINCIPAL.inert = "true";
    }
});