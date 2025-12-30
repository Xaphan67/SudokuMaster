<?php

    require("model/ClasserModel.php");
    require("model/DifficulteModel.php");
    require("model/ModeDeJeuModel.php");
    require("model/ParticiperModel.php");
    require("model/PartieModel.php");
    require("model/UtilisateurModel.php");
    require("model/entities/Classer.php");
    require("model/entities/Difficulte.php");
    require("model/entities/ModeDeJeu.php");
    require("model/entities/Participer.php");
    require("model/entities/Partie.php");
    require("model/entities/Utilisateur.php");

    class PartieController {

        // Afficher l'écran de partie solo
        public function soloBoard() {

            $script = ["jeu.js", "api.js"];

            require_once("view/partials/header.php");
            include("view/partie/jeuSolo.php");
            require_once("view/partials/footer.php");
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
                $partie->setMode_de_jeu($modeDeJeu);
                $partie->setDifficulte($difficulte);

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
                $participer->setUtilisateur($utilisateur);
                $participer->setPartie($partie);

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
                $classer->setUtilisateur($utilisateur);
                $classer->setMode_de_jeu($modeDeJeu);

                // Si aucune statistiques enregistrée en base de donnée
                if (!$donneesClasser) {

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

                    // Met à jour les données en base de donnée
                    $classerModel->edit($classer);
                }

                // Retourne l'ID de la partie insérée pour pouvoir la récupérer en JS plus tard
                echo '{"partieId": ' . $partieID . ', "serie_victoires": ' . (isset($serieVictoires) ? $serieVictoires : 0) . '}';
            }
            else {

                // Aucune partie créée
                echo '{"partieId": 0}';
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

                // Crée une instance du modèle Utilisateur
                $utilisateurModel = new UtilisateurModel;

                // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
                $utilisateur = new Utilisateur;
                $utilisateur->hydrate($utilisateurModel->findById($_SESSION["utilisateur"]["id_utilisateur"]));

                // En cas de victoire du joueur
                if ($dataJS["victoire"]) {

                    // Ajoute le gagnant à l'objet Partie
                    $partie->setGagnant($utilisateur);
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
                $classer->setUtilisateur($utilisateur);
                $classer->setMode_de_jeu($modeDeJeu);
                $classer->hydrate($donneesClasser);

                // Récupère le temps moyen du joueur
                $tempsMoyen = $partieModel->getAverageTime($utilisateur->getId());

                // Met à jour le temps moyen du joueur
                $classer->setTemps_moyen($tempsMoyen["temps_moyen"]);

                // Récupère le meilleur temps du joueur
                $meilleurTemps = $partieModel->getBestTime($utilisateur->getId());

                // Met à jour le meilleur temps du joueur
                $classer->setMeilleur_temps($meilleurTemps["meilleur_temps"]);

                // En cas de victoire du joueur
                if ($dataJS["victoire"]) {

                    // Ajoute une grille résolue
                    $classer->setGrilles_resolues($classer->getGrilles_resolues() + 1);

                    // Augmente la série de victoire
                    $classer->setSerie_victoires($dataJS["serieVictoires"] + 1);
                }

                // Met à jour les données en base de donnée
                $classerModel->edit($classer);
            }
        }
    }