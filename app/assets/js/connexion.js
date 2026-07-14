// Constantes
const CONTENEUR_PRINCIPAL = document.getElementById("conteneur_principal");
const POPUP_BANNI = document.getElementById("banni");

// Opacifie le fond et le rends non interactible si le popup est affiché
if (POPUP_BANNI != undefined) {
    CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
    CONTENEUR_PRINCIPAL.inert = true;

    // Masque le popup lors du click sur le bouton OK
    const BOUTON_OK = document.getElementById("bouton_ok");
    BOUTON_OK.addEventListener("click", (e) => {
        POPUP_BANNI.style.display = "none";
        CONTENEUR_PRINCIPAL.style.filter = "none";
        CONTENEUR_PRINCIPAL.inert = false;
    });
}