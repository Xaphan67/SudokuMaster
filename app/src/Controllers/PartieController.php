<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Services\ResponseService;
use Xaphan67\SudokuMaster\Services\TokenCSRFService;
use Xaphan67\SudokuMaster\Services\Validation\PartieValidator;

class PartieController extends Controller {

    private PartieValidator $validation;
    private TokenCSRFService $tokenCSRFService;
    private ResponseService $responseService;

    public function __construct(
        $validation = new PartieValidator,
        $tokenCSRFService = new TokenCSRFService,
        $responseService = new ResponseService
    ) {

        // Appelle le constructeur de la classe parente

        parent::__construct();

        // Instancie les services
        $this->validation = $validation;
        $this->tokenCSRFService = $tokenCSRFService;
        $this->responseService = $responseService;
    }

    // Afficher l'écran de partie solo
    public function soloBoard() {

        // Variables d'affichage
        $affichage["titre"] = "Jeu solo";
        $affichage["description"] = "Testez-vous sur des grilles de Sudoku à la difficulté variable";

        // Affiche le gabarit jeuSolo
        // et lui indique les variables nécessaires
        $this->_twig->display("partie/jeuSolo.html.twig",[
            'scripts' => ["jeu.js"],
            'affichage' => $affichage
        ]);
    }

    // Afficher l'écran de lobby pour partie multijoueur
    public function lobby() {

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire "Créer une salle" est soumis
        if (isset($_POST["creer_salle"])) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->tokenCSRFService->checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

            // Si il n'y à aucune erreur
            if (count($erreurs) == 0) {

                // Stocke en session le fait que le joueur est hote de la partie
                // et les informations de la partie
                $_SESSION["partie"]["hote"] = true;
                $_SESSION["partie"]["mode"] = $_POST["mode"];
                $_SESSION["partie"]["difficulte"] =  $_POST["difficulte"];
                $_SESSION["partie"]["visibilite"] =  $_POST["visibilite"];

                // Redirige l'utilisateur vers la page multijoueur
                $this->responseService->redirect("multijoueur");
            }
        }

        // Si le formulaire "Rejoindre une salle" est soumis
        if (isset($_POST["rejoindre_salle"])) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->tokenCSRFService->checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

            // Filtrage des données
            // Protège contre la faille XSS
            $salle = trim(filter_input(INPUT_POST, "salle", FILTER_SANITIZE_SPECIAL_CHARS) ?? "");

            // Test des données
            $erreurs["salle"] = $this->validation->validateSalle($salle);

            // Retire les valeures null du tableau d'erreur
            $erreurs = array_filter($erreurs);

            // Si il n'y à aucune erreur
            if (count($erreurs) == 0) {
                $_SESSION["partie"]["hote"] = false;
                $_SESSION["partie"]["salle"] = $salle;

                // Redirige l'utilisateur vers la page multijoueur
                $this->responseService->redirect("multijoueur");
            }
        }

        // Si le joueur rejoint une salle via un bouton rejoindre
        if (isset($_GET["salle"])) {

            // Filtrage des données
            // Protège contre la faille XSS
            $salle = trim($_GET["salle"]);

            // Test des données
            $erreurs["salle"] = $this->validation->validateSalle($salle);

            // Retire les valeures null du tableau d'erreur
            $erreurs = array_filter($erreurs);

            // Si il n'y à aucune erreur
            if (count($erreurs) == 0) {
                $_SESSION["partie"]["hote"] = false;
                $_SESSION["partie"]["salle"] = $salle;

                // Redirige l'utilisateur vers la page multijoueur
                $this->responseService->redirect("multijoueur");
            }
        }

        // Génère un token CSRF si aucun en session
        if (!isset($_SESSION["tokenCSRF"]["token"])) {
            $this->tokenCSRFService->generateCSRFToken();
        }

        // Variables d'affichage
        $affichage["titre"] = "Multijoueur";
        $affichage["description"] = "Créez ou trouvez une partie de Sudoku pour jouer à plusieurs";

        // Affiche le gabarit salon
        // et lui indique les variables nécessaires
        $this->_twig->display("partie/salon.html.twig",[
            'affichage' => $affichage,
            'scripts' => ["salon.js"],
            'erreurs' => $erreurs,
            'utilisateurConnecte' => isset($_SESSION["utilisateur"]),
            'tokenCSRF' => $_SESSION["tokenCSRF"]["token"] ?? null
        ]);

        // Efface les saisies relatives aux formulaires stockées en session
        unset($_SESSION["saisie"]["salle"]);
    }

    // Afficher l'écran de partie multijoueur
    public function multiBoard() {

        // Si aucun utilisateur n'est connecté
        if (!isset($_SESSION["utilisateur"])) {

            // Appelle la fonction _forbidden() du controller mère
             $this->_forbidden();
        }

        // Variables d'affichage
        $affichage["titre"] = "Multijoueur";
        $affichage["description"] = "Jouez au Sudoku avec ou conte vos amis, ou d'autres joueurs";

        // Affiche le gabarit multijoueur
        // et lui indique les variables nécessaires
        $this->_twig->display("partie/multijoueur.html.twig",[
            'affichage' => $affichage,
            'scripts' => ["jeu.js"]
        ]);
    }
}