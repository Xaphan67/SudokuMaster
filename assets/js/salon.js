// Constantes
const SECTION_SALON = document.getElementById("salon");
const POPUP_ERREUR_SERVEUR = document.getElementById("erreur_serveur");
const POPUP_ERREUR_SERVEUR_PARTIES_BOUTON = POPUP_ERREUR_SERVEUR.getElementsByTagName("div")[0];

// Variables
let connexion;
let statistiques;

// Se connecte au serveur WebSocket
connexion = new WebSocket('ws://localhost:8080');

// En cas de problème de connexion au serveur WebSocket
connexion.addEventListener("error", (event) => {

    // Affiche un popup d'erreur
    POPUP_ERREUR_SERVEUR.style.display = "flex";
});

// Ferme le popup d'erreur lors du clic sur le bouton ok
POPUP_ERREUR_SERVEUR_PARTIES_BOUTON.addEventListener("click", (e) => {

    // Ferme le popup d'erreur
    POPUP_ERREUR_SERVEUR.style.display = "none";
});

// Envoie un message au serveur pour demander la liste des salles
connexion.onopen = async function (e) {
    connexion.send(JSON.stringify({commande: "liste_salles"}));
}

// Défini ce qui se passe quand le serveur WebSocket envoie un message à la connexion
connexion.onmessage = async function (e) {
    let message = JSON.parse(e.data);

    switch (message.commande) {

         // Le serveur renvoie la liste des salles
        case "liste_salles":

            // Si il y à des salles à afficher...
            if (message.salles.length > 0) {

                // Crée une nouvelle section et y ajoute un titre
                const SECTION_SALLES = document.createElement("section");
                SECTION_SALLES.setAttribute("id", "salles");

                const TITRE_SALLES = document.createElement("h2");
                TITRE_SALLES.textContent = "Salles disponibles";

                SECTION_SALON.insertAdjacentElement("afterend", SECTION_SALLES);
                SECTION_SALLES.appendChild(TITRE_SALLES);

                // Récupère les stats de tous les joueurs
                const HOTE = await fetch("index.php?controller=api-classer&action=findAll", {
                    method: "POST",
                    headers: {
                            'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
                        }
                    });
                statistiques = await HOTE.json();

                // Affiche les salles disponibles
                message.salles.forEach(element => {

                    // Récupère le pseudo du joueur hôte
                    let pseudoJoueur;
                    for (const pseudo of statistiques.pseudos) {
                        if (pseudo["id_utilisateur"] == element.hote) {
                            pseudoJoueur = pseudo["pseudo_utilisateur"];
                            break;
                        }
                    }

                    // Récupère le score du joueur hôte
                    let score = 1000;
                    for (const statistique of statistiques.statistiques) {
                        if (statistique["id_utilisateur"] == element.hote && statistique["libelle_mode_de_jeu"] == element.mode) {
                            score = statistique["score_global"];
                            break;
                        }
                    }

                    // Crée les élements constituants l'affichage de la salle
                    const SALLE = SECTION_SALLES.appendChild(document.createElement("div"));
                    const SALLE_INFOS = SALLE.appendChild(document.createElement("div"));
                    const SCORE = document.createElement("p");
                    const HOTE = document.createElement("p");
                    const HOTE_INFOS = SALLE_INFOS.appendChild(document.createElement("div"));
                    const DIFFICULTE = document.createElement("p");
                    const LIEN = document.createElement("a");

                    // Remplit et ajoute les classes aux éléments constituants l'affichage de la salle
                    SCORE.textContent = score;
                    SCORE.classList.add("score_petit", "score_principal");
                    HOTE.textContent = pseudoJoueur;
                    DIFFICULTE.textContent = element.difficulte;
                    LIEN.textContent = "Rejoindre";
                    LIEN.href = "multijoueur?salle=" + element.numero;
                    LIEN.classList.add("bouton", "boutonPrincipal", "boutonLarge");

                    // Ajoute la salle à la liste
                    SALLE.classList.add("salle");
                    HOTE_INFOS.appendChild(SCORE);
                    HOTE_INFOS.appendChild(HOTE);
                    SALLE_INFOS.appendChild(DIFFICULTE);
                    SALLE.appendChild(LIEN);
                });
            }
            break;
    }
}