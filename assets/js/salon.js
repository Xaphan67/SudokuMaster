// Constantes
const SALLES = document.getElementById("salles");
const MESSAGE_SALLES = document.getElementsByClassName("message_salles")[0];
const CHARGEMENT = document.getElementsByClassName("chargement-petit")[0];
const REESSAYER = MESSAGE_SALLES.getElementsByTagName("div")[0];

// Variables
let connexion;
let statistiques;

connect();

function connect() {

    // Se connecte au serveur WebSocket
    connexion = new WebSocket('ws://localhost:8080');

    // En cas de problème de connexion au serveur WebSocket
    connexion.addEventListener("error", (event) => {
    
        // Affiche un mesage d'erreur
        MESSAGE_SALLES.style.display = "flex";

        // Masque l'animation de chargement
        CHARGEMENT.style.display = "none";

        // Tente à nouveau de se connecter en cas de clic sur le bouton "réessayer"
        REESSAYER.addEventListener("click", (e) => {
            MESSAGE_SALLES.style.display = "none";
            CHARGEMENT.style.display = "block";
            connect();
        });
    });

    // En cas de connexion réussie
    connexion.addEventListener("open", (event) => {

        // Envoie un message au serveur pour demander la liste des salles
        connexion.send(JSON.stringify({commande: "liste_salles"}));

        // Défini ce qui se passe quand le serveur WebSocket envoie un message à la connexion
        connexion.onmessage = async function (e) {
            let message = JSON.parse(e.data);

            switch (message.commande) {

                    // Le serveur renvoie la liste des salles
                case "liste_salles":

                    // Récupère les stats de tous les joueurs
                    const HOTE = await fetch("index.php?controller=api-classer&action=findAll", {
                        method: "POST",
                        headers: {
                                'Accept': 'application/json' // Indique qu'on attend du JSON en réponse
                            }
                        });
                    statistiques = await HOTE.json();

                    // Masque l'animation de chargement
                    CHARGEMENT.style.display = "none";

                    // S'il y à des salles à afficher...
                    if (message.salles.length > 0) {

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
                            const SALLE = SALLES.appendChild(document.createElement("div"));
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
                    else {

                        // Affiche un mesage indiquant qu'aucune salle n'est disponible
                        MESSAGE_SALLES.textContent = "Aucune salle disponible actuellement";
                        MESSAGE_SALLES.style.display = "flex";
                    }
                    break;
            }
        }
    });
}