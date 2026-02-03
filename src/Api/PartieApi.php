<?php

namespace Xaphan67\SudokuMaster\Api;

use Xaphan67\SudokuMaster\Entities\Classer;
use Xaphan67\SudokuMaster\Entities\Difficulte;
use Xaphan67\SudokuMaster\Entities\ModeDeJeu;
use Xaphan67\SudokuMaster\Entities\Participer;
use Xaphan67\SudokuMaster\Entities\Partie;
use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\ClasserModel;
use Xaphan67\SudokuMaster\Models\DifficulteModel;
use Xaphan67\SudokuMaster\Models\ModeDeJeuModel;
use Xaphan67\SudokuMaster\Models\ParticiperModel;
use Xaphan67\SudokuMaster\Models\PartieModel;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class PartieApi {

    // Appelle l'api externe pour récupérer une grille
    // et retourne la grille reçue
    function getGrid() {

        // URL de l'API à requéter
        $apiUrl = "https://sudoku-game-and-api.netlify.app/api/sudoku";

        // Requête a envoyer à l'API
        $options = [
            'http' => [
                'method'  => 'POST',
                'ignore_errors' => false
            ],
        ];

        // Envoi de la requête et récupération de la réponse
        $context  = stream_context_create($options);
        $result = file_get_contents($apiUrl, false, $context);

        // Affiche la grille retournée si tout est ok, sinon retourne une ereur
        if ($result === false) {
            echo json_encode(['error' => 'Impossible de récupérer la grille']);
        }
        else {
            echo $result;
        }
    }

    // Retourne si l'utilisateur est l'hôte de la partie multijoueur
    // Si non, retourne la salle qu'il souhaite rejoindre
    public function getRoomInfo() {

        // Si les informations de la partie sont en session
        if (isset($_SESSION["partie"]["hote"])) {

            // Crée un tableau qui contiendra les informations de la partie à envoye au JS
            $infos = ["hote" => $_SESSION["partie"]["hote"]];

            // Si l'utilisateur est hote...
            if ($_SESSION["partie"]["hote"]) {

                // Ajoute le mode de jeu, la difficulté et la visibilité qu'il à choisie
                $infos += [
                    "mode" => $_SESSION["partie"]["mode"],
                    "difficulte" => $_SESSION["partie"]["difficulte"],
                    "visibilite" => $_SESSION["partie"]["visibilite"]
                ];
            }
            else {

                // Ajoute le numéro de salle qu'il demande à rejoindre
                $infos += ["salle" => $_SESSION["partie"]["salle"]];
            }
        }

        // Ajoute l'id de l'utilisateur
        $infos += ["utilisateur" => $_SESSION["utilisateur"]["id_utilisateur"]];

        // Retourne les informations au JS au format JSON
        echo json_encode($infos);

        // Retire les variables de la session
        unset($_SESSION["partie"]["hote"]);
        unset($_SESSION["partie"]["mode"]);
        unset($_SESSION["partie"]["difficulte"]);
        unset($_SESSION["partie"]["salle"]);
        unset($_SESSION["partie"]["visibilite"]);
    }

    // Crée une partie dans la base de données
    // et retourne l'ID de la partie qui vient d'être créée
    public function new() {

        // Si aucun utilisateur n'est connecté
        if (!isset($_SESSION["utilisateur"])) {

             // Aucune partie créée
            echo '{"partieId": 0}';
            exit();
        }

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Crée une instance du modèle ModeDeJeu
        $modeDeJeuModel = new ModeDeJeuModel;

        // Crée un nouvel objet ModeDeJeu et l'hydrate avec les données présentes en base de donnée
        $modeDeJeu = new ModeDeJeu;
        $modeDeJeu->hydrate($modeDeJeuModel->findByLabel($dataJS["modeDeJeu"]));

        // Crée une instance du modèle Difficulte
        $difficulteModel = new DifficulteModel;

        // Crée un nouvel objet Difficulte et l'hydrate avec les données présentes en base de donnée
        $difficulte = new Difficulte;
        $difficulte->hydrate($difficulteModel->findByLabel($dataJS["difficulte"]));

        // Crée un nouvel objet Partie et l'hydrate avec les données
        $partie = new Partie;
        $partie->setMode_de_jeu($modeDeJeu->getId());
        $partie->setDifficulte($difficulte->getId());

        // Crée une instance du modèle Partie et appelle la méthode
        // pour insérer la partie en base de données et récupérer son ID
        $partieModel = new PartieModel;
        $partieID = $partieModel->add($partie);

        // Affecte l'ID octroyé par la base de données à l'objet Partie
        $partie->setId($partieID);

        // Crée une instance du modèle Utilisateur
        $utilisateurModel = new UtilisateurModel;

        // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
        $utilisateur = new Utilisateur;
        $utilisateur->hydrate($utilisateurModel->findByMail($_SESSION["utilisateur"]["email_utilisateur"]));

        // Crée un nouvel objet Participer et l'hydrate avec les données
        $participer = new Participer;
        $participer->setUtilisateur($utilisateur->getId());
        $participer->setPartie($partie->getId());

        // Crée une instance du modèle Participer et appelle la méthode
        // pour insérer le participant en base de donnée
        $participerModel = new ParticiperModel;
        $participerModel->add($participer);

        // Crée une instance du modèle Classer
        $classerModel = new ClasserModel;

        // Crée un nouvel objet Classer et l'hydrate avec les données
        $classer = new Classer;
        $classer->setUtilisateur($utilisateur->getId());
        $classer->setMode_de_jeu($modeDeJeu->getId());

        // Appelle la méthode pour récupérer les statistiques en base de donnée
        $donneesClasser = $classerModel->findByUserAndMode($utilisateur->getId(), $modeDeJeu->getId());

        // Hydrate l'objet Classer avec les données récupérées en base de donnée
        $classer->hydrate($donneesClasser);

        // Ajoute une grille jouée
        $classer->setGrilles_jouees($classer->getGrilles_jouees() + 1);

        // Récupère la série de victoires actuelle de l'utilisateur
        $serieVictoires = $classer->getSerie_victoires();

        // Remet la série de victoires à 0 pour forcer l'utilisateur
        // à finir (et gagner) la partie pour conserver sa série de victoires
        $classer->setSerie_victoires(0);

        // Récupère le score global actuel de l'utilisateur
        $scoreGlobal = $classer->getScore_global();

        // Calcule le score global de l'utilisateur en cas de défaite de cette partie
        // pour forcer l'utilisateur à finir la partie en fonction de la difficulté choise
        $coefficientDifficulte = $dataJS["difficulte"] == "Facile" ? 10 : ($dataJS["difficulte"] == "Moyen" ? 20 : 30);
        $scoreGlobalDefaite = (int)($scoreGlobal + ($coefficientDifficulte * max(0.2, 1 - 900 / 900) * -1) * 1 / (sqrt(1 + $classer->getGrilles_jouees() / 20)));
        $classer->setScore_global($scoreGlobalDefaite);

        // Met à jour les données en base de donnée
        $classerModel->edit($classer);
        $participerModel->addScore($participer, $scoreGlobalDefaite - $scoreGlobal);

        // Retourne l'ID de la partie insérée pour pouvoir la récupérer en JS plus tard
        // ainsi que la série de victoires et le score global du joueur du joueur avant cette partie
        echo '{"partieId": ' . $partieID . ', "serie_victoires": ' . (isset($serieVictoires) ? $serieVictoires : 0) . ', "score_global": ' . (isset($scoreGlobal) ? $scoreGlobal : 1000) . '}';
    }

    // Rejoint une partie
    public function join() {

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Crée une instance du modèle ModeDeJeu
        $modeDeJeuModel = new ModeDeJeuModel;

        // Crée un nouvel objet ModeDeJeu et l'hydrate avec les données présentes en base de donnée
        $modeDeJeu = new ModeDeJeu;
        $modeDeJeu->hydrate($modeDeJeuModel->findByLabel($dataJS["modeDeJeu"]));

        // Crée un nouvel objet Partie et l'hydrate avec les données
        $partie = new Partie;
        $partie->setId($dataJS["idPartie"]);

        // Crée une instance du modèle Utilisateur
        $utilisateurModel = new UtilisateurModel;

        // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
        $utilisateur = new Utilisateur;
        $utilisateur->hydrate($utilisateurModel->findByMail($_SESSION["utilisateur"]["email_utilisateur"]));

        // Crée un nouvel objet Participer et l'hydrate avec les données
        $participer = new Participer;
        $participer->setUtilisateur($utilisateur->getId());
        $participer->setPartie($partie->getId());

        // Crée une instance du modèle Participer et appelle la méthode
        // pour insérer le participant en base de donnée
        $participerModel = new ParticiperModel;
        $participerModel->add($participer);

        // Crée une instance du modèle Classer et appelle la méthode
        // pour récupérer les statistiques en base de donnée
        $classerModel = new ClasserModel;
        $donneesClasser = $classerModel->findByUserAndMode($utilisateur->getId(), $modeDeJeu->getId());

        // Crée un nouvel objet Classer et l'hydrate avec les données
        $classer = new Classer;
        $classer->setUtilisateur($utilisateur->getId());
        $classer->setMode_de_jeu($modeDeJeu->getId());

        // Hydrate l'objet Classer avec les données récupérées en base de donnée
        $classer->hydrate($donneesClasser);

        // Ajoute une grille jouée
        $classer->setGrilles_jouees($classer->getGrilles_jouees() + 1);

        // Récupère la série de victoires actuelle de l'utilisateur
        $serieVictoires = $classer->getSerie_victoires();

        // Remet la série de victoires à 0 pour forcer l'utilisateur
        // à finir (et gagner) la partie pour conserver sa série de victoires
        $classer->setSerie_victoires(0);

        // Récupère le score global actuel de l'utilisateur
        $scoreGlobal = $classer->getScore_global();

        // Calcule le score global de l'utilisateur en cas de défaite de cette partie
        // pour forcer l'utilisateur à finir la partie en fonction de la difficulté choise
        $coefficientDifficulte = $dataJS["difficulte"] == "Facile" ? 10 : ($dataJS["difficulte"] == "Moyen" ? 20 : 30);
        $scoreGlobalDefaite = (int)($scoreGlobal + ($coefficientDifficulte * max(0.2, 1 - 900 / 900) * -1) * 1 / (sqrt(1 + $classer->getGrilles_jouees() / 20)));
        $classer->setScore_global($scoreGlobalDefaite);

        // Met à jour les données en base de donnée
        $classerModel->edit($classer);
        $participerModel->addScore($participer, $scoreGlobalDefaite - $scoreGlobal);

        // Retourne la série de victoires et le score global du joueur du joueur avant cette partie
        echo '{"serie_victoires": ' . (isset($serieVictoires) ? $serieVictoires : 0) . ', "score_global": ' . (isset($scoreGlobal) ? $scoreGlobal : 1000) . '}';
    }

    // Met fin à la partie
    public function end() {

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Crée une instance du modèle Utilisateur
        $utilisateurModel = new UtilisateurModel;

        // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
        $utilisateur = new Utilisateur;
        $utilisateur->hydrate($utilisateurModel->findById($_SESSION["utilisateur"]["id_utilisateur"]));

        // Crée une instance du modèle Participer et appelle la méthode
        // pour récupérer la participation en base de données via l'ID de l'utilisateur et de la partie
        $participerModel = new ParticiperModel;
        $donneesParticiper = $participerModel->findByUserAndGame($utilisateur->getId(), $dataJS["idPartie"]);

        // Crée un nouvel objet Participer et l'hydrate avec les données
        $participer = new Participer;
        $participer->hydrate($donneesParticiper);

        // En cas de victoire du joueur
        if ($dataJS["victoire"]) {

            // Met à jour les le gagnant de la participation en base de donnée
            $participerModel->addWinner($participer);
        }

        // Calcule le temps de la partie
        // Il faut ajouter une seconde car le timer commence a 14:59
        $minutes = $dataJS["timerMinutes"];
        $secondes = $dataJS["timerSecondes"];

        if ($secondes + 1 == 60) {
            $minutes += 1;
            $secondes = 0;
        }

        // Crée une instance du modèle Partie et appelle la méthode
        // pour récupérer la partie en base de données et via son ID
        $partieModel = new PartieModel;
        $donneesPartie = $partieModel->findById($dataJS["idPartie"]);

        // Crée un nouvel objet Partie et l'hydrate avec les données
        $partie = new Partie;
        $partie->hydrate($donneesPartie);

        // Met à jour le temps dans l'objet Partie
        $partie->setDuree("00:" . ($minutes < 10 ? "0" : "") . $minutes . ":" . ($secondes < 10 ? "0" : "") . $secondes);

        // Met à jour la durée de la partie en base de donnée
        $partieModel->setTime($partie);

        // Crée une instance du modèle ModeDeJeu
        $modeDeJeuModel = new ModeDeJeuModel;

        // Crée un nouvel objet ModeDeJeu et l'hydrate avec les données présentes en base de donnée
        $modeDeJeu = new ModeDeJeu;
        $modeDeJeu->hydrate($modeDeJeuModel->findByLabel($dataJS["modeDeJeu"]));

        // Crée une instance du modèle Classer et appelle la méthode
        // pour récupérer les statistiques en base de donnée
        $classerModel = new ClasserModel;
        $donneesClasser = $classerModel->findByUserAndMode($utilisateur->getId(), $modeDeJeu->getId());

        // Crée un nouvel objet Classer et l'hydrate avec les données
        $classer = new Classer;
        $classer->setUtilisateur($utilisateur->getId());
        $classer->setMode_de_jeu($modeDeJeu->getId());
        $classer->hydrate($donneesClasser);

        // Récupère le temps moyen du joueur
        $tempsMoyen = $partieModel->getAverageTime($utilisateur->getId(), $modeDeJeu->getId());

        // Met à jour le temps moyen du joueur
        $classer->setTemps_moyen($tempsMoyen["temps_moyen"]);

        // Récupère le meilleur temps du joueur
        $meilleurTemps = $partieModel->getBestTime($utilisateur->getId(), $modeDeJeu->getId());

        // Met à jour le meilleur temps du joueur
        $classer->setMeilleur_temps($meilleurTemps["meilleur_temps"]);

        // En cas de victoire du joueur
        if ($dataJS["victoire"]) {

            // Ajoute une grille résolue
            $classer->setGrilles_resolues($classer->getGrilles_resolues() + 1);

            // Augmente la série de victoire
            $classer->setSerie_victoires($dataJS["serieVictoires"] + 1);

            // Met à jour le score global du joueur
            $coefficientDifficulte = $dataJS["difficulte"] == "Facile" ? 10 : ($dataJS["difficulte"] == "Moyen" ? 20 : 30);
            $scoreGlobal = (int)($dataJS["scoreGlobal"] + ($coefficientDifficulte * max(0.2, 1 - ($minutes * 60 + $secondes) / 900)) * 1 / (sqrt(1 + $classer->getGrilles_jouees() / 20)));
            $classer->setScore_global($scoreGlobal);

            // Met à jour la quantité de score obtenu
            $participerModel->addScore($participer, $scoreGlobal - $dataJS["scoreGlobal"]);
        }
        else {
            // Récupère le score global déjà égal à celui d'une defaite
            $scoreGlobal = $classer->getScore_global();
        }

        // Met à jour les données en base de donnée
        $classerModel->edit($classer);

        // Retourne la différence entre le score global avant la partie et après
        echo '{"difference_score": ' . ($scoreGlobal - $dataJS["scoreGlobal"]) . "}";
    }

    // Stocke les informations de la partie terminée en session
    public function store() {

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Stocke les données en session
        $_SESSION["partie_precedente"]["difficulte"] = $dataJS["difficulte"];
        $_SESSION["partie_precedente"]["victoire"] = $dataJS["victoire"];
        $_SESSION["partie_precedente"]["timerMinutes"] = $dataJS["timerMinutes"];
        $_SESSION["partie_precedente"]["timerSecondes"] = $dataJS["timerSecondes"];
    }

    // Enregistre les informations de la partie terminée en session
    public function register(int $utilisateurID) {

        // Crée une instance du modèle ModeDeJeu
        $modeDeJeuModel = new ModeDeJeuModel;

        // Crée un nouvel objet ModeDeJeu et l'hydrate avec les données présentes en base de donnée
        $modeDeJeu = new ModeDeJeu;
        $modeDeJeu->hydrate($modeDeJeuModel->findByLabel("Solo"));

        // Crée une instance du modèle Difficulte
        $difficulteModel = new DifficulteModel;

        // Crée un nouvel objet Difficulte et l'hydrate avec les données présentes en base de donnée
        $difficulte = new Difficulte;
        $difficulte->hydrate($difficulteModel->findByLabel($_SESSION["partie_precedente"]["difficulte"]));

        // Calcule le temps de la partie
        // Il faut ajouter une seconde car le timer commence a 14:59
        $minutes = $_SESSION["partie_precedente"]["timerMinutes"];
        $secondes = $_SESSION["partie_precedente"]["timerSecondes"];

        if ($secondes + 1 == 60) {
            $minutes += 1;
            $secondes = 0;
        }

        $duree = "00:" . ($minutes < 10 ? "0" : "") . $minutes . ":" . ($secondes < 10 ? "0" : "") . $secondes;

        // Crée un nouvel objet Partie et l'hydrate avec les données
        $partie = new Partie;
        $partie->setMode_de_jeu($modeDeJeu->getId());
        $partie->setDifficulte($difficulte->getId());
        $partie->setDuree($duree);

        // Crée une instance du modèle Partie et appelle la méthode
        // pour insérer la partie en base de données et récupérer son ID
        $partieModel = new PartieModel;
        $partieID = $partieModel->add($partie, true);

        // Calcule le score global de l'utilisateur
        $coefficientDifficulte = $_SESSION["partie_precedente"]["difficulte"] == "Facile" ? 10 : ($_SESSION["partie_precedente"]["difficulte"] == "Moyen" ? 20 : 30);

        if ($_SESSION["partie_precedente"]["victoire"]) {
            $scoreGlobal = (int)(1000 + ($coefficientDifficulte * max(0.2, 1 - ($minutes * 60 + $secondes) / 900)) * 1 / (sqrt(1 + 1 / 20)));
            $score = $scoreGlobal - 1000;
        }
        else {
            $scoreGlobal = (int)(1000 + ($coefficientDifficulte * max(0.2, 1 - 900 / 900) * -1) * 1 / (sqrt(1 + 1 / 20)));
            $score = 1000 - $scoreGlobal;
        }

        // Crée un nouvel objet Participer et l'hydrate avec les données
        $participer = new Participer;
        $participer->setUtilisateur($utilisateurID);
        $participer->setPartie($partieID);
        $participer->setGagnant($_SESSION["partie_precedente"]["victoire"]);
        $participer->setScore($score);

        // Crée une instance du modèle Participer et appelle la méthode
        // pour insérer le participant en base de donnée
        $participerModel = new ParticiperModel;
        $participerModel->add($participer, $_SESSION["partie_precedente"]["victoire"], $score);

        // Crée une instance du modèle Classer et appelle la méthode
        // pour récupérer les statistiques en base de donnée
        $classerModel = new ClasserModel;
        $donneesClasser = $classerModel->findByUserAndMode($utilisateurID, $modeDeJeu->getId());

        // Crée un nouvel objet Classer et l'hydrate avec les données
        $classer = new Classer;
        $classer->setUtilisateur($utilisateurID);
        $classer->setMode_de_jeu($modeDeJeu->getId());
        $classer->hydrate($donneesClasser);
        $classer->setTemps_moyen($duree);
        $classer->setMeilleur_temps($duree);
        $classer->setGrilles_jouees(1);
        $classer->setScore_global($scoreGlobal);

        // En cas de victoire du joueur
        if ($_SESSION["partie_precedente"]["victoire"]) {
            $classer->setGrilles_resolues(1);
            $classer->setSerie_victoires(1);
        }

        // Met à jour les données en base de donnée
        $classerModel->edit($classer);

        // Retire les variables de la session
        unset($_SESSION["partie_precedente"]);

        // Redirige l'utilisateur vers la page de connexion
        header("Location:connexion");
    }
}