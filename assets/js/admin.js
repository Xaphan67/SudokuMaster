// Constantes
const CONTENEUR_PRINCIPAL = document.getElementById("conteneur_principal");
const POPUP_SUPPRIMER_UTILISATEUR = document.getElementById("supprimer_utilisateur");
const POPUP_SUPPRIMER_UTILISATEUR_OUI = document.getElementById("bouton_supprimer");
const POPUP_SUPPRIMER_UTILISATEUR_NON = document.getElementById("bouton_annuler");
const ACTIONS = Array.from(document.getElementsByClassName("actions"));
const BOUTONS_ATIONS = Array.from(document.getElementsByClassName("boutonActions"));
const BOUTONS_SUPPRIMER = Array.from(document.getElementsByClassName("bouton-supprimer"));
const BOUTONS_FERMER = Array.from(document.getElementsByClassName("bouton-fermer"));

// Variables
let IdUtilisateur = null;

// Pour chaque bouton d'action...
BOUTONS_ATIONS.forEach(bouton => {

    // Lorsqu'on clique dessus...
    bouton.addEventListener("click", (e) => {

        // stocke l'ID de l'utilisateur correspondant
        IdUtilisateur = bouton.getAttribute("name").split('-')[1];

        // Affiche les actions correspondantes et masque les autres
        ACTIONS.forEach(element => {
            if (element.getAttribute("name") == "actions-" + IdUtilisateur) {
                element.style.display = "flex";
            }
            else {
                element.style.display = "none";
            }
        });
    });
});

// Pour chaque bouton de suppression...
BOUTONS_SUPPRIMER.forEach(bouton => {

    // Si le bouton est actif...
    if (!bouton.classList.contains("inactif")) {

        // Lorsqu'on clique dessus...
        bouton.addEventListener("click", (e) => {

            // stocke l'ID de l'utilisateur correspondant
            IdUtilisateur = bouton.getAttribute("name").split('-')[1];

            // Affiche le popup de confirmation
            CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
            CONTENEUR_PRINCIPAL.inert = true;
            POPUP_SUPPRIMER_UTILISATEUR.style.display = "flex";

            // Lors du clic que le bouton Oui
            POPUP_SUPPRIMER_UTILISATEUR_OUI.addEventListener("click", (e) => {
                
                fetch("index.php?controller=api-utilisateur&action=delete", {
                    method: "POST",
                    headers: {
                            'Content-Type': 'application/json', // Indique qu'on envoie du JSON
                        },
                        body: JSON.stringify({id: IdUtilisateur}) // Objet JS converti en chaîne JSON
                });

                // Redirige vers l'accueil de l'administration
                window.location.replace("administration");
            });

            // Lors du clic que le bouton Non
            POPUP_SUPPRIMER_UTILISATEUR_NON.addEventListener("click", (e) => {
                
                // Masque le popup de confirmation
                CONTENEUR_PRINCIPAL.style.filter = "none";
                CONTENEUR_PRINCIPAL.inert = false;
                POPUP_SUPPRIMER_UTILISATEUR.style.display = "none";
            });
        });
    };
});

// Pour chaque bouton de fermeture
BOUTONS_FERMER.forEach(bouton => {

    // Lorsqu'on clique dessus...
    bouton.addEventListener("click", (e) => {

        // stocke l'ID de l'utilisateur correspondant
        IdUtilisateur = bouton.getAttribute("name").split('-')[1];

        // Masque les actions correspondantes
        const ACTIONS = document.getElementsByName("actions-" + IdUtilisateur)[0];
        ACTIONS.style.display = "none";
    });
});