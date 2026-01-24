<?php

namespace Xaphan67\SudokuMaster\Api;

class PartieApi {

    function getGrid() {

        // Appeller l'API externe pour recevoir une grille
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

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
}