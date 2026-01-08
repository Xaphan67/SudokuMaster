<?php

namespace Xaphan67\SudokuMaster\Controllers;

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

class PartieController extends Controller {

    // Afficher l'écran de partie solo
    public function soloBoard() {

        // Indique à la vue les fichiers JS à utiliser
        $script = ["jeu.js", "api.js"];
        $this->_donnees["script"] = $script;

        // Affiche la vue jeuSolo
        $this->display("partie/jeuSolo");
    }

    // Afficher l'écran de lobby pour partie multijoueur
    public function lobby() {

        // Affiche la vue salon
        $this->display("partie/salon");
    }

    // Afficher l'écran de partie multijoueur
    public function multiBoard() {

        // Indique à la vue les fichiers JS à utiliser
        $script = ["jeu.js", "api.js"];
        $this->_donnees["script"] = $script;

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
            $_SESSION["partie"]["hote"] = false;
            $_SESSION["partie"]["salle"] = $_POST["salle"];
        }

        // Affiche la vue multijoueur
        $this->display("partie/multijoueur");
    }

    // Retourne si l'utilisateur est l'hôte de la partie multijoueur
    // Si non, retourne la salle qu'il souhaite rejoindre
    public function getRoomInfo() {

        // Si un utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Si les informations de la partie sont en session
            if (isset($_SESSION["partie"]["hote"])) {

                // Crée un tableau qui contiendra les informations de la partie à envoye au JS
                $infos = ["hote" => $_SESSION["partie"]["hote"]];

                // Si l'utilisateur est hote...
                if ($_SESSION["partie"]["hote"]) {

                    // Ajoute le mode de jeu et la difficulté qu'il à choisie
                    $infos += [
                        "mode" => $_SESSION["partie"]["mode"],
                        "difficulte" => $_SESSION["partie"]["difficulte"]
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
        }
    }

    // Crée une partie dans la base de données
    // et retourne l'ID de la partie qui vient d'être créée
    public function new() {

        // Si un utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

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

            // Crée une instance du modèle Classer et appelle la méthode
            // pour récupérer les statistiques en base de donnée
            $classerModel = new ClasserModel;
            $donneesClasser = $classerModel->findByUserAndMode($utilisateur->getId(), $modeDeJeu->getId());

            // Crée un nouvel objet Classer et l'hydrate avec les données
            $classer = new Classer;
            $classer->setUtilisateur($utilisateur->getId());
            $classer->setMode_de_jeu($modeDeJeu->getId());

            // Si aucune statistiques enregistrée en base de donnée
            if (!$donneesClasser) {

                // Calcule le score global de base en fonction de la difficulté choise
                $coefficientDifficulte = $dataJS["difficulte"] == "Facile" ? 10 : ($dataJS["difficulte"] == "Moyen" ? 20 : 30);
                $scoreGlobalBase = (int)(1000 + ($coefficientDifficulte * max(0.2, 1 - 900 / 900) * -1) * 1 / (sqrt(1 + 1 / 20)));

                // Défini le score global de base
                $classer->setScore_global($scoreGlobalBase);

                // Insère les statistiques en base de donnée
                $classerModel->add($classer);
            }
            else {

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
            }

            // Retourne l'ID de la partie insérée pour pouvoir la récupérer en JS plus tard
            // ainsi que la série de victoires et le score global du joueur du joueur avant cette partie
            echo '{"partieId": ' . $partieID . ', "serie_victoires": ' . (isset($serieVictoires) ? $serieVictoires : 0) . ', "score_global": ' . (isset($scoreGlobal) ? $scoreGlobal : 1000) . '}';
        }
        else {

            // Aucune partie créée
            echo '{"partieId": 0}';
        }
    }

    // Rejoint une partie
    public function join() {
        // Si un utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

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

            // Si aucune statistiques enregistrée en base de donnée
            if (!$donneesClasser) {

                // Calcule le score global de base en fonction de la difficulté choise
                $coefficientDifficulte = $dataJS["difficulte"] == "Facile" ? 10 : ($dataJS["difficulte"] == "Moyen" ? 20 : 30);
                $scoreGlobalBase = (int)(1000 + ($coefficientDifficulte * max(0.2, 1 - 900 / 900) * -1) * 1 / (sqrt(1 + 1 / 20)));

                // Défini le score global de base
                $classer->setScore_global($scoreGlobalBase);

                // Insère les statistiques en base de donnée
                $classerModel->add($classer);
            }
            else {

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
            }

            // Retourne la série de victoires et le score global du joueur du joueur avant cette partie
            echo '{"serie_victoires": ' . (isset($serieVictoires) ? $serieVictoires : 0) . ', "score_global": ' . (isset($scoreGlobal) ? $scoreGlobal : 1000) . '}';
        }
    }

    // Met fin à la partie
    public function end() {
        // Si un utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Récupération des données envoyées par JS
            $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
            $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

            // Crée une instance du modèle Partie et appelle la méthode
            // pour récupérer la partie en base de données et via son ID
            $partieModel = new PartieModel;
            $donneesPartie = $partieModel->findById($dataJS["idPartie"]);

            // Crée un nouvel objet Partie et l'hydrate avec les données
            $partie = new Partie;
            $partie->hydrate($donneesPartie);

            // Crée une instance du modèle ModeDeJeu
            $modeDeJeuModel = new ModeDeJeuModel;

            // Crée un nouvel objet ModeDeJeu et l'hydrate avec les données présentes en base de donnée
            $modeDeJeu = new ModeDeJeu;
            $modeDeJeu->hydrate($modeDeJeuModel->findByLabel($dataJS["modeDeJeu"]));

            // Crée une instance du modèle Utilisateur
            $utilisateurModel = new UtilisateurModel;

            // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
            $utilisateur = new Utilisateur;
            $utilisateur->hydrate($utilisateurModel->findById($_SESSION["utilisateur"]["id_utilisateur"]));

            // En cas de victoire du joueur
            if ($dataJS["victoire"]) {

                // En partie solo, ou si hôte de la partie multijoueur
                if ($modeDeJeu->getLibelle() == "Solo" || (($modeDeJeu->getLibelle() != "Solo" && $dataJS["hote"])))
                {

                    // Ajoute le gagnant à l'objet Partie
                    $partie->setGagnant($utilisateur->getId());
                }

                // En partie multijoueur, si pas hôte
                else if ($modeDeJeu->getLibelle() != "Solo" && !$dataJS["hote"]) {

                    // Ajoute le co-gagnant à l'objet Partie
                    $partie->setCo_gagnant($utilisateur->getId());
                }
            }

            // Calcule le temps de la partie
            // Il faut ajouter une seconde car le timer commence a 14:59
            $minutes = $dataJS["timerMinutes"];
            $secondes = $dataJS["timerSecondes"];

            if ($secondes + 1 == 60) {
                $minutes += 1;
                $secondes = 0;
            }

            // Met à jour le temps dans l'objet Partie
            $partie->setDuree("00:" . ($minutes < 10 ? "0" : "") . $minutes . ":" . ($secondes < 10 ? "0" : "") . $secondes);

            // Met à jour les données de la partie en base de donnée
            $partieModel->edit($partie);

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
    }
}