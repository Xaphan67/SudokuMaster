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

class PartieApi extends Controller {

    // Retourne si l'utilisateur est l'hôte de la partie multijoueur
    // Si non, retourne la salle qu'il souhaite rejoindre
    public function getRoomInfo() {

        // Si aucun utilisateur n'est connecté
        if (!isset($_SESSION["utilisateur"])) {

            echo $this->jsonErrorResponse(403, "Vous devez vous connecter pour acceder a cette page");
            exit();
        }

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

        // Génère une grille complète (solution), puis 3 versions de cette grille (1 par difficulté)
        // Et renvoie le résultat en format JSON
        function getGrid() {

            // Crée une grille vide
            function generateEmptyGrild() : array {

                $grilleVide = [];
                for ($i = 0; $i <= 8; $i++) {
                    $grilleVide[$i] = [0, 0, 0, 0, 0, 0, 0, 0, 0];
                }

                return $grilleVide;
            }

            // Détermine si un chiffre est valide
            function isValid($grille, $ligne, $colonne, $chiffre) : bool {

                // Vérifie que le chiffre n'est pas déjà présent sur la ligne
                for ($c = 0; $c <= 8; $c++) {
                    if ($grille[$ligne][$c] == $chiffre) {
                        return false;
                    }
                }

                // Vérifie que le chiffre n'est pas déjà présent sur la colonne
                for ($l = 0; $l <= 8; $l++) {
                    if ($grille[$l][$colonne] == $chiffre) {
                        return false;
                    }
                }

                // Vérifie que le chiffre n'est pas déjà dans le bloc 3x3
                $ligneBloc = floor($ligne / 3) * 3;
                $colonneBloc = floor($colonne / 3) * 3;
                for ($l = 0; $l <= 2; $l++) {
                    for ($c = 0; $c <= 2; $c++) {
                        if ($grille[$ligneBloc + $l][$colonneBloc + $c] == $chiffre) {
                            return false;
                        }
                    }
                }

                // Si toutes les vérifications sont ok, le nombre peut être placé
                return true;
            }

            // Remplit la grille à l'aide du backtracking récursif
            function generateGrid($grille) {

                // Pour chaque ligne, et chaque colonne...
                for ($ligne = 0; $ligne < 9; $ligne++) {
                    for ($colonne = 0; $colonne < 9; $colonne++) {

                        // Si le chiffre n'a pas encore été déterminé
                        if ($grille[$ligne][$colonne] === 0) {

                            // Crée un tableu vaec les chiffres possibles et le mélange
                            $chiffres = range(1, 9);
                            shuffle($chiffres);

                            // Pour chaque chiffre...
                            foreach ($chiffres as $chiffre) {

                                // Teste s'il peut être placé dans la grille
                                if (isValid($grille, $ligne, $colonne, $chiffre)) {
                                    $grille[$ligne][$colonne] = $chiffre;

                                    // Propage le tableau pour pouvoir le renvoyer en fin de fonction
                                    $resultat = generateGrid($grille);
                                    if ($resultat !== false) {
                                        return $resultat;
                                    }

                                    // Backtracking récursif
                                    $grille[$ligne][$colonne] = 0;
                                }
                            }

                            // Aucun chiffre valide trouvé, on remonte
                            return false;
                        }
                    }
                }

                // Grille complète, on la renvoie
                return $grille;
            }

            // Compte le nombre de solutions (max 2)
            function countSolutions(array $grille): int
            {
                // --- Bitmasks : bit N = chiffre N déjà utilisé ---
                $lignes = array_fill(0, 9, 0);
                $colonnes = array_fill(0, 9, 0);
                $carres = array_fill(0, 9, 0);
                $cellulesVides = [];

                for ($ligne = 0; $ligne < 9; $ligne++) {
                    for ($colonne = 0; $colonne < 9; $colonne++) {
                        $valeur = $grille[$ligne][$colonne];
                        if ($valeur !== 0) {
                            $bit = 1 << $valeur;
                            $lignes[$ligne] |= $bit;
                            $colonnes[$colonne] |= $bit;
                            $carres[floor($ligne / 3) * 3 + floor($colonne / 3)] |= $bit;
                        } else {
                            $cellulesVides[] = [$ligne, $colonne];
                        }
                    }
                }

                return solve($grille, 0, $cellulesVides, $lignes, $colonnes, $carres);
            }

            // Résoud une case de la grille — retourne le nombre de solutions trouvées
            function solve(array $grille, int $solutions, array $cellulesVides, array $lignes, array $colonnes, array $carres): int
            {
                if ($solutions > 1) {
                    return $solutions;
                }

                if (empty($cellulesVides)) {
                    return $solutions + 1;
                }

                // --- MRV : choisir la cellule avec le moins de candidats ---
                $meilleurChoix = 0;
                $meilleurSolution = 10;

                foreach ($cellulesVides as $i => [$ligne, $colonne]) {
                    $carre = floor($ligne / 3) * 3 + floor($colonne / 3);
                    $utilise = $lignes[$ligne] | $colonnes[$colonne] | $carres[$carre];
                    $libre = 9 - substr_count(decbin($utilise & 0b1111111110), '1');

                    if ($libre < $meilleurSolution) {
                        $meilleurSolution = $libre;
                        $meilleurChoix = $i;
                        if ($libre === 0) {
                            return $solutions; // cellule sans candidat → impasse
                        }
                    }
                }

                [$ligne, $colonne] = $cellulesVides[$meilleurChoix];
                $carre = floor($ligne / 3) * 3 + floor($colonne / 3);
                $utilise = $lignes[$ligne] | $colonnes[$colonne] | $carres[$carre];

                // Retirer cette cellule de la liste pour les appels récursifs
                $nouvellesCellulesVides = $cellulesVides;
                array_splice($nouvellesCellulesVides, $meilleurChoix, 1);

                for ($chiffre = 1; $chiffre <= 9; $chiffre++) {

                    $bit = 1 << $chiffre;

                    if ($utilise & $bit) {
                        continue; // chiffre déjà utilisé
                    }

                    // Placer le chiffre
                    $nouvelleLigne = $lignes[$ligne] | $bit;
                    $nouvelleColonne = $colonnes[$colonne] | $bit;
                    $nouveauCarre = $carres[$carre] | $bit;

                    $nouvelleGrille = $grille;
                    $nouvelleGrille[$ligne][$colonne] = $chiffre;

                    $nouvelleLignes = $lignes;
                    $nouvelleLignes[$ligne] = $nouvelleLigne;

                    $nouvellesColonnes = $colonnes;
                    $nouvellesColonnes[$colonne] = $nouvelleColonne;

                    $nouveauxCarres = $carres;
                    $nouveauxCarres[$carre] = $nouveauCarre;

                    $solutions = solve($nouvelleGrille, $solutions, $nouvellesCellulesVides, $nouvelleLignes, $nouvellesColonnes, $nouveauxCarres);

                    if ($solutions > 1) {
                        return $solutions;
                    }
                }

                return $solutions;
            }

            // Détermine si la grille n'a qu'une solution
            function hasUniqueSolution($grille) {

                $count = 0;
                $count = countSolutions($grille, $count);
                return $count === 1;
            }

            // Génère une grille complète et 3 grilles basées sur la solution avec des numéros manquants en fonction de la difficulté
            function generateGrids() {

                // Récupère une grille vide
                $grilleVide = generateEmptyGrild();

                // Génère un puzzle
                $puzzle = generateGrid($grilleVide);

                // Variables qui contiendront les données à renvoyer
                $solution = $puzzle;
                $facile = [];
                $moyen = [];
                $difficile = [];

                // Indices 0..80 mélangés aléatoirement
                $cellules = range(0, 80);
                shuffle($cellules);

                // Nombre total d'indices au départ (grille pleine)
                $indices = 81;

                foreach ($cellules as $idx) {

                    // Coordonnées de la cellule
                    $ligne = floor($idx / 9);
                    $colonne = $idx % 9;

                    // Stoke le chiffre correspondant
                    $backup = $puzzle[$ligne][$colonne];

                    // Cellule déjà vide, on passe
                    if ($backup === 0) {
                        continue;
                    }

                    // On ne descend pas sous le minimum d'indices
                    // et stoke la grille obtenue en fonction de la difficulté
                    if ($indices - 1 < 80 && $facile == []) {
                        $facile = $puzzle;
                        continue;
                    }
                    else if ($indices - 1 < 40 && $moyen == []) {
                        $moyen = $puzzle;
                        continue;
                    }
                    else if ($indices - 1 < 30 && $difficile == []) {
                        $difficile = $puzzle;
                        continue;
                    }

                    // On supprime temporairement le chiffre
                    $puzzle[$ligne][$colonne] = 0;

                    // Crée un clone de la grille pour effectuer le test d'unicité
                    $cloneGrille = $puzzle;

                    // Teste si la grille n'a qu'une solution à ce stade
                    if (!hasUniqueSolution($cloneGrille)) {

                        // Remet le chiffre
                        $puzzle[$ligne][$colonne] = $backup;
                    } else {

                        // Déduit un indice du total
                        $indices--;
                    }
                }

                return ["solution" => $solution, "facile" => $facile, "moyen" => $moyen, "difficile" => $difficile];
            }

            // Récupère une grille et ses modes de difficulté
            $grilles = generateGrids();

            return ["solution" => $grilles["solution"], "grilles" => ["facile" => $grilles["facile"], "moyen" => $grilles["moyen"], "difficile" => $grilles["difficile"]]];
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

        // Si un utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

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
        }

        // Récupère une nouvelle grille (Solution + 3 difficultés) pour la partie
        $grille = getGrid();

        // Ajoute la solution à la partie
        $partie->setSolution(json_encode($grille["solution"]));
        $partieModel->setSolution($partie);

        // Retourne l'ID de la partie insérée pour pouvoir la récupérer en JS plus tard
        // ainsi que la grille, la série de victoires et le score global du joueur du joueur avant cette partie
        echo '{"partieId": ' . $partieID . ', "grille": ' . json_encode($grille["grilles"]) . ', "serie_victoires": ' . (isset($serieVictoires) ? $serieVictoires : 0) . ', "score_global": ' . (isset($scoreGlobal) ? $scoreGlobal : 1000) . ', "invite": ' . !isset($_SESSION["utilisateur"]) . '}';
    }

    // Rejoint une partie
    public function join() {

        // Si aucun utilisateur n'est connecté
        if (!isset($_SESSION["utilisateur"])) {

            echo $this->jsonErrorResponse(403, "Vous devez vous connecter pour acceder a cette page");
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

        // Si aucun utilisateur n'est connecté
        if (!isset($_SESSION["utilisateur"])) {

            echo $this->jsonErrorResponse(403, "Vous devez vous connecter pour acceder a cette page");
            exit();
        }

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
        $_SESSION["partie_precedente"]["id"] = $dataJS["idPartie"];
        $_SESSION["partie_precedente"]["difficulte"] = $dataJS["difficulte"];
        $_SESSION["partie_precedente"]["victoire"] = $dataJS["victoire"];
        $_SESSION["partie_precedente"]["timerMinutes"] = $dataJS["timerMinutes"];
        $_SESSION["partie_precedente"]["timerSecondes"] = $dataJS["timerSecondes"];
    }

    // Enregistre les informations de la partie terminée en session
    public function register(int $utilisateurID) {

        // Calcule le temps de la partie
        // Il faut ajouter une seconde car le timer commence a 14:59
        $minutes = $_SESSION["partie_precedente"]["timerMinutes"];
        $secondes = $_SESSION["partie_precedente"]["timerSecondes"];

        if ($secondes + 1 == 60) {
            $minutes += 1;
            $secondes = 0;
        }

        $duree = "00:" . ($minutes < 10 ? "0" : "") . $minutes . ":" . ($secondes < 10 ? "0" : "") . $secondes;

        // Crée une instance du modèle Partie
        $partieModel = new PartieModel;
        
        // Crée un nouvel objet Partie et l'hydrate avec les données présentes en base de données
        $partie = new Partie;
        $partie->hydrate($partieModel->findById($_SESSION["partie_precedente"]["id"]));

        // Ajoute la durée
        $partie->setDuree($duree);

        // Insére la partie en base de données
        $partieModel->setTime($partie);

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
        $participer->setPartie($_SESSION["partie_precedente"]["id"]);
        $participer->setGagnant($_SESSION["partie_precedente"]["victoire"]);
        $participer->setScore($score);

        // Crée une instance du modèle Participer et appelle la méthode
        // pour insérer le participant en base de donnée
        $participerModel = new ParticiperModel;
        $participerModel->add($participer, $_SESSION["partie_precedente"]["victoire"], $score);

        // Crée une instance du modèle Classer et appelle la méthode
        // pour récupérer les statistiques en base de donnée
        $classerModel = new ClasserModel;
        $donneesClasser = $classerModel->findByUserAndMode($utilisateurID, $partie->getMode_de_jeu());

        // Crée un nouvel objet Classer et l'hydrate avec les données
        $classer = new Classer;
        $classer->setUtilisateur($utilisateurID);
        $classer->setMode_de_jeu($partie->getMode_de_jeu());
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

    // Vérifie si la grille envoyée correspond à la solution
    function checkGrid() {

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Crée une instance du modèle Partie et appelle la méthode
        // pour récupérer la solution
        $partieModel = new PartieModel;
        $solution = $partieModel->getSolution($dataJS["idPartie"]);

        // Compare la grille envoyée à la solution
        $identique = $dataJS["grille"] === json_decode($solution["solution_partie"]);

        echo json_encode(["grilleResolue" => $identique]);
    }
}