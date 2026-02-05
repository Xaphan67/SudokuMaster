// Constantes
const CONTENEUR_PRINCIPAL = document.getElementById("conteneur_principal");
const POPUP_INFOS_UTILISATEUR = document.getElementById("infos_utilisateur");
const POPUP_INFOS_UTILISATEUR_FERMER = document.getElementById("bouton_fermer");
const POPUP_BANNIR_UTILISATEUR = document.getElementById("bannir_utilisateur");
const POPUP_BANNIR_UTILISATEUR_OUI = document.getElementById("bouton_bannir");
const POPUP_BANNIR_UTILISATEUR_NON = document.getElementById("bouton_annuler_bannir");
const POPUP_SUPPRIMER_UTILISATEUR = document.getElementById("supprimer_utilisateur");
const POPUP_SUPPRIMER_UTILISATEUR_OUI = document.getElementById("bouton_supprimer");
const POPUP_SUPPRIMER_UTILISATEUR_NON = document.getElementById("bouton_annuler_supprimer");
const ACTIONS = Array.from(document.getElementsByClassName("actions"));
const BOUTONS_ATIONS = Array.from(document.getElementsByClassName("boutonActions"));
const BOUTONS_INFOS = Array.from(document.getElementsByClassName("bouton-info"));
const BOUTONS_BANNIR = Array.from(document.getElementsByClassName("bouton-bannir"));
const BOUTONS_SUPPRIMER = Array.from(document.getElementsByClassName("bouton-supprimer"));
const BOUTONS_FERMER = Array.from(document.getElementsByClassName("bouton-fermer"));
const ONGLETS = POPUP_INFOS_UTILISATEUR.getElementsByClassName("onglets")[0];
const ERREURS_FORMULAIRES = document.getElementById("erreurs");

// Variables
let IdUtilisateur = null;
let infosUtilisateur = null;

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

// Pour chaque bouton info
BOUTONS_INFOS.forEach(bouton => {

    // Lorsqu'on clique dessus...
    bouton.addEventListener("click", (e) => {

        // stocke l'ID de l'utilisateur correspondant
        IdUtilisateur = bouton.getAttribute("name").split('-')[1];

        // Récupère les informations de l'utilisateur
        getUserInfos(IdUtilisateur);
    });
});

// Pour chaque bouton de bannissement...
BOUTONS_BANNIR.forEach(bouton => {

    // Si le bouton est actif...
    if (!bouton.classList.contains("inactif")) {

        // Lorsqu'on clique dessus...
        bouton.addEventListener("click", (e) => {

            // stocke l'ID de l'utilisateur correspondant
            IdUtilisateur = bouton.getAttribute("name").split('-')[1];

            // Ouvre le popup avec le formulaire de bannissement
            openBanUser(IdUtilisateur);
        });
    }
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

            // Lors du clic sur le bouton Oui
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

            // Lors du clic sur le bouton Non
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

async function getUserInfos() {

    // Récupère les infos de l'utilisateur
    const INFOS = await fetch("index.php?controller=api-utilisateur&action=getInfos", {
        method: "POST",
        headers: {
                'Content-Type': 'application/json', // Indique qu'on envoie du JSON
                'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
            },
            body: JSON.stringify({id: IdUtilisateur}) // Objet JS converti en chaîne JSON
    });
    let resInfos = await INFOS.json();

    // Affiche les informations dans le popup
    const TITRE = POPUP_INFOS_UTILISATEUR.getElementsByTagName("H3")[0];
    const ROLE = POPUP_INFOS_UTILISATEUR.getElementsByTagName("P")[0];
    const EMAIL = POPUP_INFOS_UTILISATEUR.getElementsByTagName("P")[1];
    const DATE_INSCRIPTION = POPUP_INFOS_UTILISATEUR.getElementsByTagName("DIV")[0].getElementsByTagName("P")[0];
    TITRE.innerText = resInfos["utilisateur"].pseudo_utilisateur;
    ROLE.innerText = resInfos["utilisateur"].libelle_role;
    EMAIL.innerText = resInfos["utilisateur"].email_utilisateur;
    DATE_INSCRIPTION.innerText = "Inscrit le " + new Date(resInfos["utilisateur"].date_inscription_utilisateur).toLocaleDateString();

    for (i = 1; i <= 3; i++) {

        let id = "mode_" + (resInfos["statistiques"][i].id_mode_de_jeu == 1 ? "solo" : (resInfos["statistiques"][i].id_mode_de_jeu == 2 ? "cooperatif" : "competitif"));
        const CONTENEUR = document.getElementById(id);

        if (i >= 2) {
            CONTENEUR.style.display = "none";
        }

        let grillesJouees = document.createElement("DIV");
        let grillesJoueesTexte = document.createElement("P");
        let grillesJoueesValeur = document.createElement("P");
        grillesJoueesTexte.innerText = "Grilles jouées :";
        grillesJoueesValeur.innerText = resInfos["statistiques"][i].grilles_jouees;
        grillesJouees.appendChild(grillesJoueesTexte);
        grillesJouees.appendChild(grillesJoueesValeur);
        CONTENEUR.appendChild(grillesJouees);

        let grillesResolues = document.createElement("DIV");
        let grillesResoluesTexte = document.createElement("P");
        let grillesResoluesValeur = document.createElement("P");
        grillesResoluesTexte.innerText = "Grilles résolues :";
        grillesResoluesValeur.innerText = resInfos["statistiques"][i].grilles_resolues;
        grillesResolues.appendChild(grillesResoluesTexte);
        grillesResolues.appendChild(grillesResoluesValeur);
        grillesJouees.insertAdjacentElement("afterend", grillesResolues);

        let tempsMoyen = document.createElement("DIV");
        let tempsMoyenTexte = document.createElement("P");
        let tempsMoyenValeur = document.createElement("P");
        tempsMoyenTexte.innerText = "Temps moyen :";
        tempsMoyenValeur.innerText = resInfos["statistiques"][i].temps_moyen;
        tempsMoyen.appendChild(tempsMoyenTexte);
        tempsMoyen.appendChild(tempsMoyenValeur);
        grillesResolues.insertAdjacentElement("afterend", tempsMoyen);

        let meilleurTemps = document.createElement("DIV");
        let meilleurTempsTexte = document.createElement("P");
        let meilleurTempsValeur = document.createElement("P");
        meilleurTempsTexte.innerText = "Meilleur temps :";
        meilleurTempsValeur.innerText = resInfos["statistiques"][i].meilleur_temps;
        meilleurTemps.appendChild(meilleurTempsTexte);
        meilleurTemps.appendChild(meilleurTempsValeur);
        tempsMoyen.insertAdjacentElement("afterend", meilleurTemps);

        let serieVictoires = document.createElement("DIV");
        let serieVictoiresTexte = document.createElement("P");
        let serieVictoiresValeur = document.createElement("P");
        serieVictoiresTexte.innerText = "Série de victoires :";
        serieVictoiresValeur.innerText = resInfos["statistiques"][i].serie_victoires;
        serieVictoires.appendChild(serieVictoiresTexte);
        serieVictoires.appendChild(serieVictoiresValeur);
        meilleurTemps.insertAdjacentElement("afterend", serieVictoires);

        ONGLETS.insertAdjacentElement("afterend", CONTENEUR);
    }

    // Affiche le popup d'informations
    CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
    CONTENEUR_PRINCIPAL.inert = true;
    POPUP_INFOS_UTILISATEUR.style.display = "flex";

    // Lors du clic sur le bouton Fermer
    POPUP_INFOS_UTILISATEUR_FERMER.addEventListener("click", (e) => {
        
        // Masque le popup de confirmation
        CONTENEUR_PRINCIPAL.style.filter = "none";
        CONTENEUR_PRINCIPAL.inert = false;
        POPUP_INFOS_UTILISATEUR.style.display = "none";

        // Supprime les informations du popup
        const CONTENEUR_SOLO = document.getElementById("mode_solo");
        while (CONTENEUR_SOLO.firstChild) {
            CONTENEUR_SOLO.removeChild(CONTENEUR_SOLO.firstChild);
        }

        const CONTENEUR_COOPERATIF = document.getElementById("mode_cooperatif");
        while (CONTENEUR_COOPERATIF.firstChild) {
            CONTENEUR_COOPERATIF.removeChild(CONTENEUR_COOPERATIF.firstChild);
        }

        const CONTENEUR_COMPETITIF = document.getElementById("mode_competitif");
        while (CONTENEUR_COMPETITIF.firstChild) {
            CONTENEUR_COMPETITIF.removeChild(CONTENEUR_COMPETITIF.firstChild);
        }

        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Solo"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        ONGLETS.getElementsByTagName("P")[0].classList.add("onglet_actif");

        // Affiche l'onglet "Solo" et masque les autres onglets
        ONGLET_SOLO.style.display = "block";
        ONGLET_COOPERATIF.style.display = "none";
        ONGLET_COMPETITIF.style.display = "none";
    });
}

const ONGLET_SOLO = document.getElementById("mode_solo");
const ONGLET_COOPERATIF = document.getElementById("mode_cooperatif");
const ONGLET_COMPETITIF = document.getElementById("mode_competitif");

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

// Vérifie qi'il y a des erreurs dans le formulaire
// Si oui, ouvre immédiatement le popup qui contient le formulaire au chargement de la page
if (ERREURS_FORMULAIRES.value !== "") {
    openBanUser(ERREURS_FORMULAIRES.value);
}

function openBanUser(IdUtilisateur) {

    // Passe l'ID de l'utilisateur au formulaire
    const CHAMP_FORMULAIRE = document.getElementsByName("id_utilisateur")[0];
    CHAMP_FORMULAIRE.value = IdUtilisateur;

    // Affiche le popup avec le formulaire
    CONTENEUR_PRINCIPAL.style.filter = "opacity(0.40)";
    CONTENEUR_PRINCIPAL.inert = true;
    POPUP_BANNIR_UTILISATEUR.style.display = "flex";

    // Lors du clic sur le bouton Annuler
    POPUP_BANNIR_UTILISATEUR_NON.addEventListener("click", (e) => {
        
        // Masque le popup
        CONTENEUR_PRINCIPAL.style.filter = "none";
        CONTENEUR_PRINCIPAL.inert = false;
        POPUP_BANNIR_UTILISATEUR.style.display = "none";

        // Retire l'affichage des erreurs si l'utilisateur rouvre le popup plus tard
        Array.from(document.getElementsByClassName("erreur")).forEach(erreur => {
            erreur.innerHTML = "";
        });
    });

}