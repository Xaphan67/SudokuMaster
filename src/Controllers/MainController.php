<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Models\ClasserModel;

class MainController extends Controller {

    // Affiche la page d'accueil
    public function home() {

        // Affiche le gabarit accueil
        $this->_display("main/accueil");
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

        // Indique au gabarit les variables nécessaires
        $scripts = ["classements.js"];
        $this->_donnees["scripts"] = $scripts;
        $this->_donnees["classements"] = $classements;

        // Affiche le gabarit classements
        $this->_display("main/classements");
    }

    // Affiche la page des règles
    public function rules() {

        // Indique au gabarit les variables nécessaires
        $scripts = ["regles.js"];
        $this->_donnees["scripts"] = $scripts;

        // Affiche le gabarit regles
        $this->_display("main/regles");
    }

    // Affiche la page des mentions légales
    public function legals() {

        // Affiche le gabarit mentions
        $this->_display("main/mentions");
    }
}