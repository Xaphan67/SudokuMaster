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

            // Création d'une nouvelle salle
            case "creer_salle":
                $this->salles[$from->resourceId] = $message->salle;
                echo "La connexion " . $from->resourceId . " à créé la salle " . $message->salle . "\n";
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {

        // Quand une connexion quitte le serveur
        // Supprime la connexion de la liste des clients
        $this->clients->detach($conn);

        // Si le client était encore dans une salle, on l'enlève
        unset($this->salles[array_search($conn->resourceId, $this->salles)]);

        echo "La connexion {$conn->resourceId} s'est déconnectée\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {

        // En cas d'erreur, affiche le message de l'erreur
        echo "Une erreur est survenue : {$e->getMessage()}\n";

        // Déconnecte la connection en erreur
        $conn->close();
    }
}
