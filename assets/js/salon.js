// Constantes
const SALLES = document.getElementById("salles");
const ERREUR_LISTE_SALLES = document.getElementsByClassName("erreur_liste_salles")[0];
const CHARGEMENT = document.getElementsByClassName("chargement-petit")[0];
const REESSAYER = ERREUR_LISTE_SALLES.getElementsByTagName("div")[0];
const LISTE_SALLES = document.getElementById("liste_salles");
const MESSAGE_SALLES = document.getElementsByClassName("message_salles")[0];
const ONGLETS = document.getElementsByClassName("onglets")[0];
const SALLES_COOPERATIF = document.getElementById("salles_cooperatif");
const SALLES_COMPETITIF = document.getElementById("salles_competitif");

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
        ERREUR_LISTE_SALLES.style.display = "flex";

        // Masque l'animation de chargement
        CHARGEMENT.style.display = "none";

        // Tente à nouveau de se connecter en cas de clic sur le bouton "réessayer"
        REESSAYER.addEventListener("click", (e) => {
            ERREUR_LISTE_SALLES.style.display = "none";
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

                    // Affiche la liste des salles avec les onglets
                    LISTE_SALLES.style.display = "flex";

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
                                let mode = statistique["libelle_mode_de_jeu"].replace("é", "e");
                                if (statistique["id_utilisateur"] == element.hote && mode == element.mode) {
                                    score = statistique["score_global"];
                                    break;
                                }
                            }

                            // Masque le message indiquant qu'aucune salle n'est disponible
                            (element.mode == "Cooperatif" ? SALLES_COOPERATIF : SALLES_COMPETITIF).getElementsByClassName("message_salles")[0].style.display = "none";

                            // Crée les élements constituants l'affichage de la salle
                            const SALLE = (element.mode == "Cooperatif" ? SALLES_COOPERATIF : SALLES_COMPETITIF).appendChild(document.createElement("div"));
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
    });
}

// Affiche l'onglet "Cooperatif"
ONGLETS.getElementsByTagName("P")[0].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Cooperatif"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet "Cooperatif" et masque les autres onglets
        SALLES_COOPERATIF.style.display = "flex";
        SALLES_COMPETITIF.style.display = "none";
    }
});

// Affiche l'onglet "Competitif"
ONGLETS.getElementsByTagName("P")[1].addEventListener("click", (e) => {
    if (!e.target.classList.contains("onglet_actif")) {
        // Retire la classe onglet_actif de tout les onglets, puis l'ajoute à l'onglet "Competitif"
        Array.from(ONGLETS.getElementsByTagName("P")).forEach(element => {
            element.classList.remove("onglet_actif");
        });
        e.target.classList.add("onglet_actif");

        // Affiche l'onglet "Competitif" et masque les autres onglets
        SALLES_COOPERATIF.style.display = "none";
        SALLES_COMPETITIF.style.display = "flex";
    }
});
