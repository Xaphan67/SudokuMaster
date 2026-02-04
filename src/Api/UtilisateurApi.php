<?php

namespace Xaphan67\SudokuMaster\Api;

use Xaphan67\SudokuMaster\Entities\Classer;
use Xaphan67\SudokuMaster\Models\ClasserModel;
use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class UtilisateurApi {

    function delete() {

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Crée une instance du modèle Utilisateur
        $utilisateurModel = new UtilisateurModel;

        // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
        $utilisateur = new Utilisateur;
        $utilisateur->hydrate($utilisateurModel->findById($dataJS["id"]));

        // Supprime l'utilisateur en base de données
        $utilisateurSupprime = $utilisateurModel->delete($utilisateur);
    }

    function getInfos() {

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Crée une instance du modèle Classer et appelle la méthode
        // pour récupérer les statistiques en base de donnée
        $classerModel = new ClasserModel;

        // Instancie un tableau qui contiendra les statistiques
        $statistiques = [];

        // Pour chaque mode de jeu, récupère les statistiques
        for($mode = 1; $mode <= 3; $mode++) {
            $donneesClasser = $classerModel->findByUserAndMode($dataJS["id"], $mode, true);

            // S'il y à des statistiques pour le mode
            if ($donneesClasser) {

                // Retire l'affichage des heures (qui sera toujours 00:) et tronque les millisecondes
                $donneesClasser["temps_moyen"] = substr($donneesClasser["temps_moyen"], 3, 5);
                $donneesClasser["meilleur_temps"] = substr($donneesClasser["meilleur_temps"], 3, 5);

                // Ajoute l'objet Classer au tableau de statistiques
                $statistiques[$mode] = $donneesClasser;
            }
        };

        echo json_encode($statistiques);
    }
}