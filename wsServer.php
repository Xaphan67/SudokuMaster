<?php
set_time_limit(0);
ob_implicit_flush();

$hote = 'localhost';
$port = 8080;

// Ouvre un nouveau socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, $hote, $port);
socket_listen($socket);

echo "Serveur WebSocket démarré sur {$hote}:{$port}\n";

$clients = [];
$salles = [];

while (true) {
    $read = array_merge([$socket], $clients);
    socket_select($read, $write, $except, 0, 10);

    // Lors d'une nouvelle connexion d'un client
    if (in_array($socket, $read)) {
        $nouveauClient = socket_accept($socket);

        $clients["temp"] = $nouveauClient;

        // Effectue le handshake WebSocket
        $header = socket_read($nouveauClient, 1024);
        performHandshake($header, $nouveauClient);

        echo "Nouveau joueur connecté\n";
        unset($read[array_search($socket, $read)]);
    }

    // Traitement des messages des clients
    foreach ($read as $client) {
        $data = @socket_read($client, 1024, PHP_BINARY_READ);

        // Si le message est vide (un client se déconnecte)
        if ($data === false || $data === '' || $data === null) {

            // Notifie le 2eme joueur dans la salle du joueur qui quitte le serveur (s'il y en a un)
            foreach ($salles as $numero => $infos) {
                if ($client == $infos["socket_hote"] || $client == $infos["socket_client"]) {

                    if (in_array($infos["socket_hote"], $clients) && in_array($infos["socket_client"], $clients)) {
                        socket_write($clients[$salles[$numero][$client == $infos["socket_hote"] ? "client" : "hote"]], mask(json_encode(["commande" => "abandonner_partie"])));
                    }

                    // Supprime la salle si le deuxième joueur se déconnecte
                    if (!in_array($infos["socket_hote"], $clients) || !in_array($infos["socket_client"], $clients)) {
                        unset($salles[$numero]);
                    }
                    break;
                }
            }

            // Déconnecte le client du serveur
            $key = array_search($client, $clients);
            unset($clients[$key]);
            socket_close($client);
            echo "Joueur déconnecté\n";
            continue;
        }

        // Décode le message reçu
        $message = unmask($data);
        echo "Message reçu: " . $message . "\n";
        $message = json_decode($message);

        // Effectue une action en fonction du message reçu
        // Lit l'attribut 'commande' du message pour savoir quoi faire

        if ($message != null) {

            switch ($message->commande) {

                // Le client demande la liste des salles
                case "liste_salles":

                    // Crée un tableau pour y stocker la liste des salles à envoyer
                    $listeSalles = ["commande" => "liste_salles", "salles" => []];

                    // Récupère les informations de chaque salle
                    // et les stocke dans le tableau $listeSalles
                    foreach ($salles as $numero => $infos) {
                        if (!array_key_exists("clos", $infos)) {
                            $listeSalles["salles"][] = ["numero" => $numero, "mode" => $infos["mode"], "difficulte" => $infos["difficulte"], "hote" => $infos["hote"]];
                        }
                    }

                    // Envoie le tableau au client
                    socket_write($client, mask(json_encode($listeSalles)));
                    break;

                // Le client veux créer une salle
                case "creer_salle":

                    // Génère un numéro de salle au format idConnexion heures(format sur 24 heures) minutes
                    $numeroSalle =$message->utilisateur . date("G") . date("i");

                    // Ajoute le joueur à la salle
                    $clients[$message->utilisateur] = $clients["temp"];
                    unset($clients["temp"]);
                    $salles[$numeroSalle] = ["socket_hote" => $client, "mode" => $message->mode, "difficulte" => $message->difficulte, "hote" => $message->utilisateur, "hote_pret" => "0"];

                    // Renvoie le numéro de la salle au client
                    socket_write($client, mask(json_encode(["commande" => "numero_salle", "numero" => $numeroSalle])));

                    echo "Le joueur " . $message->utilisateur . " à créé la salle " . $numeroSalle . "\n";
                    break;

                // Le client veux rejoindre une salle
                case "rejoindre_salle":

                    // Vérifie que la salle demandée existe
                    // Si oui, récupère ses informations
                    $salleExiste = false;
                    foreach($salles as $numero => $salle) {
                        if ($numero == $message->salle) {
                            $salleExiste = $salle;
                            break;
                        }
                    }

                    if (is_array($salleExiste)) {

                        // Ajoute le joueur à la salle
                        $salles[$message->salle] += ["socket_client" => $client, "client" => $message->utilisateur, "client_pret" => "0", "clos" => true];
                        $clients[$message->utilisateur] = $clients["temp"];
                        unset($clients["temp"]);

                        // Renvoie les informations de la salle au client
                        socket_write($client, mask(json_encode(["commande" => "infos_salle", "mode" => $salleExiste["mode"], "difficulte" => $salleExiste["difficulte"], "hoteId" => $salleExiste["hote"]])));

                        // Notifie l'arrivée de cette connexion à l'autre connexion déjà dans la salle
                        socket_write($clients[$salleExiste["hote"]], mask(json_encode(["commande" => "joueur_rejoint", "joueur" => $message->utilisateur])));

                        echo "Le joueur " . $message->utilisateur . " à rejoint la salle " . $message->salle . "\n";
                    }
                    else {

                        // Renvoie au client un message indiquant que la salle n'existe pas
                        socket_write($client, mask(json_encode(["commande" => "salle_inexistante"])));
                    }
                    break;

                // L'hôte à créé une partie
                case "partie_prete":

                    // Envoie les informations de la partie au 2eme joueur
                    socket_write($clients[$salles[$message->salle]["client"]], mask(json_encode(["commande" => "partie_prete", "idPartie" => $message->idPartie, "grille" => $message->grille, "solution" => $message->solution])));
                    break;

                // L'hote à envoyé les statiqtiques des deux joueurs
                case "statistiques":

                    // Envoie les statistiques au 2eme joueur
                    socket_write($clients[$salles[$message->salle]["client"]], mask(json_encode(["commande" => "statistiques", "statistiques" => $message->statistiques])));
                    break;

                // Un joueur est prêt
                case "joueur_pret":

                    echo "Joueur " . $message->utilisateur . " indique qu'il est prêt\n";

                    // Enregistre que le joueur est prêt
                    $salles[$message->salle][($message->hote ? "hote" : "client") . "_pret"] = "1";

                    // Informe le 2eme joueur que le joueur est prêt
                    socket_write($clients[$salles[$message->salle][$message->hote ? "client" : "hote"]], mask(json_encode(["commande" => "joueur_pret"])));

                    // Si les deux joueurs de la salle sont prêts
                    // Informe les deux joueurs de démarrer la partie
                    if ($salles[$message->salle]["hote_pret"] && $salles[$message->salle]["client_pret"]) {
                        socket_write($clients[$salles[$message->salle]["hote"]], mask(json_encode(["commande" => "commencer_partie"])));
                        socket_write($clients[$salles[$message->salle]["client"]], mask(json_encode(["commande" => "commencer_partie"])));
                    }
                    break;

                // Un joueur à changé la valeur d'une case de sa grille
                case "changer_case":

                    // Envoie les informations de la case changée au 2eme joueur
                    $destId = null;
                    socket_write($clients[$salles[$message->salle][$message->hote ? "client" : "hote"]], mask(json_encode(["commande" => "changer_case", "Y" => $message->Y, "X" => $message->X, "valeur" => $message->valeur])));
                    break;

                // Un joueur à terminé la partie
                case "fin_partie":

                    // Envoie l'information au 2eme joueur que la partie est terminée
                    socket_write($clients[$salles[$message->salle][$message->hote ? "client" : "hote"]], mask(json_encode(["commande" => "fin_partie"])));
                    break;
            }
        }
    }
}

socket_close($socket);

function performHandshake($headers, $client) {
    preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $headers, $matches);
    $key = trim($matches[1]);

    $acceptKey = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));

    $upgrade = "HTTP/1.1 101 Switching Protocols\r\n" .
               "Upgrade: websocket\r\n" .
               "Connection: Upgrade\r\n" .
               "Sec-WebSocket-Accept: {$acceptKey}\r\n\r\n";

    socket_write($client, $upgrade);
}

function unmask($payload) {
    $length = ord($payload[1]) & 127;

    if ($length == 126) {
        $masks = substr($payload, 4, 4);
        $data = substr($payload, 8);
    } elseif ($length == 127) {
        $masks = substr($payload, 10, 4);
        $data = substr($payload, 14);
    } else {
        $masks = substr($payload, 2, 4);
        $data = substr($payload, 6);
    }

    $text = '';
    for ($i = 0; $i < strlen($data); $i++) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }
    return $text;
}

function mask($text) {
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length > 125 && $length < 65536) {
        $header = pack('CCn', $b1, 126, $length);
    } else {
        $header = pack('CCNN', $b1, 127, 0, $length);
    }

    return $header . $text;
}

function msgOtherPlayer($from, $salle, $message, $salles, $clients) {
    $destId = null;
    foreach ($salles as $clientId => $infos) {
        if ($clientId != $from && $infos["numero"] == $salle) {
            $destId = $clientId;
            break;
        }
    }

    $message = json_encode($message);
    socket_write($clients[$destId], mask($message));
    echo "Message envoyé au joueur {$destId} : {$message}\n";
}
?>