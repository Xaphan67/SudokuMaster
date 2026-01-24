<?php

namespace Xaphan67\SudokuMaster\Controllers;

class PartieController extends Controller {

    // Afficher l'écran de partie solo
    public function soloBoard() {

        // Indique au gabarit les variables nécessaires
        $scripts = ["jeu.js", "api.js"];
        $this->_donnees["scripts"] = $scripts;

        // Affiche le gabarit jeuSolo
        $this->_display("partie/jeuSolo");
    }

    // Afficher l'écran de lobby pour partie multijoueur
    public function lobby() {

        // Indique au gabarit vue les variables nécessaires
        $this->_donnees ["utilisateurConnecte"] = isset($_SESSION["utilisateur"]);

        // Affiche le gabarit salon
        $this->_display("partie/salon");

        // Efface les erreurs et saisies relatives aux formulaires stockées en session
        unset($_SESSION["erreurs"]);
        unset($_SESSION["saisie"]["salle"]);
    }

    // Afficher l'écran de partie multijoueur
    public function multiBoard() {

        // Si aucun utilisateur n'est connecté
        if (!isset($_SESSION["utilisateur"])) {

            // Appelle la fonction _forbidden() du controller mère
             $this->_forbidden();
        }

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire "Créer une salle" est soumis
        if (isset($_POST["creer_salle"])) {

            // Stocke en session le fait que le joueur est hote de la partie
            // et les informations de la partie
            $_SESSION["partie"]["hote"] = true;
            $_SESSION["partie"]["mode"] = $_POST["mode"];
            $_SESSION["partie"]["difficulte"] =  $_POST["difficulte"];
        }

        // Si le formulaire "Rejoindre une salle" est soumis
        if (isset($_POST["rejoindre_salle"])) {

            // Filtrage des données
            // Protège contre la faille XSS
            $salle = trim(filter_input(INPUT_POST, "salle", FILTER_SANITIZE_SPECIAL_CHARS));

            // Test des données
            if (!$salle) {
                $erreurs["salle"] = "Ce champ est obligatoire";
            }
            else if (preg_match("/([^0-9])/",($salle))) {
                $erreurs["salle"] = "L'ID de la salle ne peut contenir que des chiffres";
            }

            // Si il n'y à aucune erreur
            if (count($erreurs) == 0) {
                $_SESSION["partie"]["hote"] = false;
                $_SESSION["partie"]["salle"] = $salle;
            }
            else {

                // Stocke les erreurs en session
                $_SESSION["erreurs"] = $erreurs;

                // Stocke les données saisies par l'utilisateur
                // pour les afficher au chargement de la page salon
                $_SESSION["saisie"]["salle"] = $_POST["salle"];

                // Redirige l'utilisateur vers la page salon
                header("Location:salon");
            }
        }

        // Indique au gabarit les variables nécessaires
        $scripts = ["jeu.js", "api.js"];
        $this->_donnees["scripts"] = $scripts;

        // Affiche le gabarit multijoueur
        $this->_display("partie/multijoueur");
    }
}