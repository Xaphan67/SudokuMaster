<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Models\ClasserModel;

class MainController extends Controller {

    // Affiche la page d'accueil
    public function home() {

        // Affiche le gabarit accueil
        $this->_twig->display("main/accueil.html.twig");
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

        // Affiche le gabarit classements
        // et lui indique les variables nécessaires
        $this->_twig->display("main/classements.html.twig",[
            'scripts' => ["classements.js"],
            'classements' => $classements
        ]);
    }

    // Affiche la page des règles
    public function rules() {

        // Affiche le gabarit regles
        // et lui indique les variables nécessaires
        $this->_twig->display("main/regles.html.twig",[
            'scripts' => ["regles.js"]
        ]);
    }

    // Affiche la page des mentions légales
    public function legals() {

        // Affiche le gabarit mentions
        $this->_twig->display("main/mentions.html.twig");
    }
}