<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Entities\ModeDeJeu;
use Xaphan67\SudokuMaster\Models\ClasserModel;
use Xaphan67\SudokuMaster\Models\ModeDeJeuModel;

class ClasserController extends Controller {

    // Affiche la page d'accueil
    public function getPlayerStats() {

        // Si un utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Récupération des données envoyées par JS
            $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
            $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

            // Crée une instance du modèle Mode et appelle la méthode
            // pour récupérer le mode en base de données
            $modeDeJeuModel = new ModeDeJeuModel;
            $donneesModeDeJeu = $modeDeJeuModel->findByLabel($dataJS["modeDeJeu"]);

            // Crée un objet ModeDeJeu et l'hydrate avec les données
            $modeDeJeu = new ModeDeJeu;
            $modeDeJeu->hydrate($donneesModeDeJeu);

            // Crée une instance du modèle Classer et appelle la méthode
            // pour récupérer les statistiques des joueur en base de données
            $classerModel = new ClasserModel;
            $statistiquesJ1 = $classerModel->findByUserAndMode($_SESSION["utilisateur"]["id_utilisateur"], $modeDeJeu->getId(), true);
            $statistiquesJ2 = $classerModel->findByUserAndMode($dataJS["idJoueur"], $modeDeJeu->getId(), true);

            // Retourne les statistiques des joueurs pour pouvoir les récupérer en JS plus tard
            echo '{"joueur_1": {"pseudo_utilisateur": "' . $statistiquesJ1["pseudo_utilisateur"]
                . '", "score_global": ' . $statistiquesJ1["score_global"]
                . ', "grilles_jouees": ' . $statistiquesJ1["grilles_jouees"]
                . ', "grilles_resolues": ' . $statistiquesJ1["grilles_resolues"]
                . ', "temps_moyen": "' . substr($statistiquesJ1["temps_moyen"],3 ,5)
                . '", "meilleur_temps": "' . substr($statistiquesJ1["meilleur_temps"],3 ,5)
                . '", "serie_victoires": ' . $statistiquesJ1["serie_victoires"] . '}, '
                . '"joueur_2": {"pseudo_utilisateur": "' . $statistiquesJ2["pseudo_utilisateur"]
                . '", "score_global": ' . $statistiquesJ2["score_global"]
                . ', "grilles_jouees": ' . $statistiquesJ2["grilles_jouees"]
                . ', "grilles_resolues": ' . $statistiquesJ2["grilles_resolues"]
                . ', "temps_moyen": "' . substr($statistiquesJ2["temps_moyen"],3 ,5)
                . '", "meilleur_temps": "' . substr($statistiquesJ2["meilleur_temps"],3 ,5)
                . '", "serie_victoires": ' . $statistiquesJ2["serie_victoires"] . '}}';
        }
    }
}