<?php

namespace Xaphan67\SudokuMaster\Api;

use Xaphan67\SudokuMaster\Entities\Classer;
use Xaphan67\SudokuMaster\Entities\ModeDeJeu;
use Xaphan67\SudokuMaster\Entities\Difficulte;
use Xaphan67\SudokuMaster\Models\ClasserModel;
use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\ModeDeJeuModel;
use Xaphan67\SudokuMaster\Models\DifficulteModel;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class ClasserApi {

    // Récupérer les statistiques de tous les joueurs
    public function findAll() {

        // Crée une instance du modèle Classer et appelle la méthode
        // pour récupérer les statistiques des joueurs en base de données
        $classerModel = new ClasserModel;
        $statistiques = $classerModel->findAll();

        // Crée une instance du modèle Utilisateur et appèle la méthode
        // pour récupérer le pseudo de tous les utilisateurs
        $utilisateurModel = new UtilisateurModel;
        $pseudos = $utilisateurModel->findAllUsernames();

        // Retourne les statistiques des joueurs pour pouvoir les récupérer en JS plus tard
        echo json_encode(["pseudos" => $pseudos, "statistiques" => $statistiques]);
    }

    // Récupérer les statistiques d'un joueur et celle du joueur en faisant la demande
    public function getPlayerStats() {

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

        // Si aucune statistiques enregistrée en base de donnée pour l'un des joueurs
        if (!$statistiquesJ1 || !$statistiquesJ2) {

            // Crée une instance du modèle Utilisateur
            $utilisateurModel = new UtilisateurModel;

            // Crée une instance du modèle Difficulte
            $difficulteModel = new DifficulteModel;

            // Crée un nouvel objet Difficulte et l'hydrate avec les données présentes en base de donnée
            $difficulte = new Difficulte;
            $difficulte->hydrate($difficulteModel->findByLabel($dataJS["difficulte"]));


            // S'il manque les statistiques du 1er joueur
            if (!$statistiquesJ1) {

                // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
                $utilisateur = new Utilisateur;
                $utilisateur->hydrate($utilisateurModel->findById($_SESSION["utilisateur"]["id_utilisateur"]));

                // Crée un nouvel objet Classer et l'hydrate avec les données
                $classer = new Classer;
                $classer->setUtilisateur($utilisateur->getId());
                $classer->setMode_de_jeu($modeDeJeu->getId());

                // Calcule le score global de base en fonction de la difficulté choise
                $coefficientDifficulte = $dataJS["difficulte"] == "Facile" ? 10 : ($dataJS["difficulte"] == "Moyen" ? 20 : 30);
                $scoreGlobalBase = (int)(1000 + ($coefficientDifficulte * max(0.2, 1 - 900 / 900) * -1) * 1 / (sqrt(1 + 1 / 20)));

                // Défini le score global de base
                $classer->setScore_global($scoreGlobalBase);

                // Insère les statistiques en base de donnée
                $classerModel->add($classer);

                // Récupère les données insérées
                $statistiquesJ1 = $classerModel->findByUserAndMode($_SESSION["utilisateur"]["id_utilisateur"], $modeDeJeu->getId(), true);
            }

            // S'il manque les statistiques du 2eme joueur
            if (!$statistiquesJ2) {

                // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
                $utilisateur = new Utilisateur;
                $utilisateur->hydrate($utilisateurModel->findById($dataJS["idJoueur"]));

                // Crée un nouvel objet Classer et l'hydrate avec les données
                $classer = new Classer;
                $classer->setUtilisateur($utilisateur->getId());
                $classer->setMode_de_jeu($modeDeJeu->getId());

                // Calcule le score global de base en fonction de la difficulté choise
                $coefficientDifficulte = $dataJS["difficulte"] == "Facile" ? 10 : ($dataJS["difficulte"] == "Moyen" ? 20 : 30);
                $scoreGlobalBase = (int)(1000 + ($coefficientDifficulte * max(0.2, 1 - 900 / 900) * -1) * 1 / (sqrt(1 + 1 / 20)));

                // Défini le score global de base
                $classer->setScore_global($scoreGlobalBase);

                // Insère les statistiques en base de donnée
                $classerModel->add($classer);

                // Récupère les données insérées
                $statistiquesJ2 = $classerModel->findByUserAndMode($dataJS["idJoueur"], $modeDeJeu->getId(), true);
            }
        }

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