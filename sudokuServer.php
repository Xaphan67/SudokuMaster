<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SudokuServer implements MessageComponentInterface {
    protected \SplObjectStorage $clients;
    protected array $joueurs;
    protected array $salles;
    protected array $modes;
    protected array $difficultes;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->joueurs = [];
        $this->salles = [];
        $this->modes = [];
        $this->difficultes = [];
    }

    public function onOpen(ConnectionInterface $conn) {

        // Quand une connexion est faite au serveur
        // Ajoute la connection à la liste des clients
        $this->clients->attach($conn);

        // Ajoute la connexion à la liste des joueurs connectés
        // Pour pouvoir facilement lui envoyer des messages
        $this->joueurs[$conn->resourceId] = $conn;

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

                // Ajoute l'Id du client dans le tableau des salles, et lui attribue une salle
                // au format idConnexion heures(format sur 24 heures) minutes
                $salle = $from->resourceId . date("G") . date("i");
                $this->salles[$from->resourceId] = $salle;
                echo "La connexion " . $from->resourceId . " à créé la salle " . $salle . "\n";

                // Ajoute les informations de la salle dans leurs tableaux respectifs
                $this->modes[$salle] = $message->mode;
                $this->difficultes[$salle] = $message->difficulte;

                // Renvoie le numéro de la salle au client
                $from->send(json_encode(["commande" => "numero_salle", "numero" => $salle]));
                break;

            // Le client veux rejoindre une salle
            case "rejoindre_salle":

                // Vérifie que la salle demandée existe
                if (in_array($message->salle, $this->salles)) {

                    // Ajoute l'Id du client dans le tableau des salles
                    $this->salles[$from->resourceId] = $message->salle;
                    echo "La connexion " . $from->resourceId . " à rejoint la salle " . $message->salle . "\n";

                    // Renvoie les informations de la salle au client
                    $from->send(json_encode(["commande" => "infos_salle", "mode" => $this->modes[$message->salle], "difficulte" => $this->difficultes[$message->salle]]));

                    // Notifie l'arrivée de cette connexion à l'autre connexion déjà dans la salle
                    foreach ($this->salles as $clientId => $salle) {
                        if ($clientId != $from->resourceId && $salle == $message->salle) {
                            $this->joueurs[$clientId]->send(json_encode(["commande" => "joueur_rejoint"]));
                            echo "Indique à la connexion " . $clientId . " que " . $from->resourceId . " à rejoint la salle\n";
                        }
                    }
                }
                else {

                    // Renvoie au client un message indiquant que la salle n'existe pas
                    $from->send(json_encode(["commande" => "salle_inexistante"]));
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {

        // Quand une connexion quitte le serveur
        // Supprime la connexion de la liste des clients
        $this->clients->detach($conn);

        // Supprime la connexion de la liste des joueurs connectés
        unset($this->joueurs[$conn->resourceId]);

        // Si le client était encore dans une salle, on l'enlève
        if (array_key_exists($conn->resourceId, $this->salles)) {
            $salle =$this->salles[$conn->resourceId];
            unset($this->salles[$conn->resourceId]);

            // Si la salle est vide, on enlève les infos qui la concernent
            if (!in_array($salle, $this->salles)) {
                unset($this->modes[$salle]);
                unset($this->difficultes[$salle]);
            }
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
