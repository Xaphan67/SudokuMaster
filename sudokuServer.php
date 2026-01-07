<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SudokuServer implements MessageComponentInterface {
    protected \SplObjectStorage $clients;
    protected array $salles;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->salles = [];
    }

    public function onOpen(ConnectionInterface $conn) {

        // Quand une connexion est faite au serveur
        // Ajoute la connection à la liste des clients
        $this->clients->attach($conn);

        echo "Nouvelle connexion! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        // Quand un message est envoyé (en JSON)
        // Décode le JSON et le stocke dans une variable
        $message = json_decode($msg);

        // Effectue une action en fonction du message reçu
        // Lit l'attribut 'commande' du message pour savoir quoi faire

        switch ($message->commande) {

            // Le client veux créer une salle
            case "creer_salle":

                // Génère un numéro de salle au format idConnexion heures(format sur 24 heures) minutes
                $salle = $from->resourceId . date("G") . date("i");

                // Ajoute le joueur à la salle
                $this->salles[$from->resourceId] = ["numero" => $salle, "mode" => $message->mode, "difficulte" => $message->difficulte, "id" => $message->utilisateur];

                // Renvoie le numéro de la salle au client
                $from->send(json_encode(["commande" => "numero_salle", "numero" => $salle]));

                echo "Le joueur " . $message->utilisateur . " à créé la salle " . $salle . "\n";
                break;

            // Le client veux rejoindre une salle
            case "rejoindre_salle":

                // Vérifie que la salle demandée existe
                // Si oui, récupère ses informations
                $salleExiste = false;
                foreach($this->salles as $salle) {
                    if ($salle["numero"] == $message->salle) {
                        $salleExiste = $salle;
                        break;
                    }
                }

                if (is_array($salleExiste)) {

                    // Ajoute le joueur à la salle
                    $this->salles[$from->resourceId] = ["numero" => $message->salle, "mode" => $salleExiste["mode"], "difficulte" => $salleExiste["difficulte"], "id" => $message->utilisateur];

                    // Renvoie les informations de la salle au client
                    $from->send(json_encode(["commande" => "infos_salle", "mode" => $salleExiste["mode"], "difficulte" => $salleExiste["difficulte"], "hoteId" => $salleExiste["id"]]));

                    // Notifie l'arrivée de cette connexion à l'autre connexion déjà dans la salle
                    $destId = null;
                    foreach ($this->salles as $clientId => $infos) {
                        if ($clientId != $from->resourceId && $infos["numero"] == $message->salle) {
                            $destId = $clientId;
                            break;
                        }
                    }

                    foreach($this->clients as $client) {
                        if ($client->resourceId == $destId) {
                            $client->send(json_encode(["commande" => "joueur_rejoint", "joueur" => $message->utilisateur]));
                            break;
                        }
                    }

                    echo "Le joueur " . $message->utilisateur . " à rejoint la salle " . $message->salle . "\n";
                }
                else {

                    // Renvoie au client un message indiquant que la salle n'existe pas
                    $from->send(json_encode(["commande" => "salle_inexistante"]));
                }
                break;

            // L'hôte à créé une partie
            case "partie_prete":

                // Envoie les informations de la partie au 2eme joueur
                $destId = null;
                foreach ($this->salles as $clientId => $infos) {
                    if ($clientId != $from->resourceId && $infos["numero"] == $message->salle) {
                        $destId = $clientId;
                        break;
                    }
                }

                foreach($this->clients as $client) {
                    if ($client->resourceId == $destId) {
                        $client->send(json_encode(["commande" => "partie_prete", "idPartie" => $message->idPartie, "grille" => $message->grille, "solution" => $message->solution]));
                        break;
                    }
                }
                break;

            // Un joueur à changé la valeur d'une case de sa grille
            case "changer_case":

                // Envoie les informations de la case changée au 2eme joueur
                $destId = null;
                foreach ($this->salles as $clientId => $infos) {
                    if ($clientId != $from->resourceId && $infos["numero"] == $message->salle) {
                        $destId = $clientId;
                        break;
                    }
                }

                foreach($this->clients as $client) {
                    if ($client->resourceId == $destId) {
                        $client->send(json_encode(["commande" => "changer_case", "Y" => $message->Y, "X" => $message->X, "valeur" => $message->valeur]));
                        break;
                    }
                }

                echo "changer case";
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {

        // Quand une connexion quitte le serveur
        // Supprime la connexion de la liste des clients
        $this->clients->detach($conn);

        // Retire le joueur de la salle
        if (array_key_exists($conn->resourceId, $this->salles)) {
            unset($this->salles[$conn->resourceId]);
        }

        echo "La connexion {$conn->resourceId} s'est déconnectée\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {

        // En cas d'erreur, affiche le message de l'erreur
        echo "Une erreur est survenue : {$e->getMessage()}\n";

        // Déconnecte la connection en erreur
        $conn->close();
    }
}
