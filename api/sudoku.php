<?php
// Récupération des données envoyées par JS
$json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
$dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

// URL de l'API à requéter
$apiUrl = "https://youdosudoku.com/api/";

// Données que l'on souhaite obtenir
$data = [
    'difficulty' => $dataJS['difficulte'], // Difficulté de la grille à générer
    'solution' => true, // Avec la solution
    'array' => true // Résultat sous forme de tableaux
];

// Requête a envoyer à l'API
$options = [
    'http' => [
        'header'  => "Content-Type: application/json",
        'method'  => 'POST',
        'content' => json_encode($data),
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