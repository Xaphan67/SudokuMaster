 <?php
header("Content-Type: application/json");

$apiUrl = "https://youdosudoku.com/api/";

// tableau associatif PHP qui contient les données à envoyer à l’API
$data = [
    'difficulty' => 'hard',
    'solution' => true,
    'array' => true
];

// Configure les options pour file_get_contents afin de faire une requête HTTP POST
$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data), // transforme le tableau $data en JSON pour l’envoyer dans le corps de la requête
        'ignore_errors' => true // pour voir la réponse même en erreur HTTP
    ],
];

// Crée un contexte de flux HTTP avec les options définies ci-dessus.
// Ce contexte est ensuite utilisé par file_get_contents pour personnaliser la requête HTTP.
$context  = stream_context_create($options);

// Envoie la requête HTTP POST à l’API externe via file_get_contents.
// false → pas de wrapper supplémentaire
// $context → les options POST définies juste avant
$result = file_get_contents($apiUrl, false, $context);


// Vérifie si file_get_content a échoué, si oui, renvoie un JSON d’erreur au frontend
if ($result === FALSE) {
    var_dump("Erreur : Impossible de récupérer la grille");
} else {
    echo $result;
}



