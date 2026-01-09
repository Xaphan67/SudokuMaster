<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Models\ClasserModel;

class MainController extends Controller {

    // Affiche la page d'accueil
    public function home() {

        // Affiche la vue accueil
        $this->display("main/accueil");
    }

    // Affiche la page des classements
    public function leaderboard() {

        // Déclare un tableau vide $classement qui contiendra une entrée par mode de jeu
        $classements = [];

        // Pour chaque mode de jeu...
        for ($mode = 1; $mode <= 3; $mode++) {

            // Crée une instance du modèle Classer et appelle la méthode
            // pour récupérer les statistiques du mode en base de donnée
            $classerModel = new ClasserModel;
            $donneesClasser = $classerModel->findAllByMode($mode, 10);

            // Ajoute les statistiques du mode dans le tableau $classement
            $classements[$mode] = $donneesClasser;
        }

        // Indique à la vue le tableau classement
        $this->_donnees["classements"] = $classements;

        // Affiche la vue classements
        $this->display("main/classements");
    }

    // Affiche la page des règles
    public function rules() {

        // Indique à la vue les variables nécessaires
        $script = ["regles.js"];
        $this->_donnees["script"] = $script;

        // Affiche la vue regles
        $this->display("main/regles");
    }

    // Affiche la page des mentions légales
    public function legals() {

        // Affiche la vue mentions
        $this->display("main/mentions");
    }

    // Affiche la page des conditions générales d'utilisation
    public function gcu() {

        // Affiche la vue cgu
        $this->display("main/cgu");
    }
}