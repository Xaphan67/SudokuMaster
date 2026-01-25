<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Participer;

class ParticiperModel extends Model {
    function getAll() {
        $query = "SELECT * FROM participer";
        $participers = $this->_db->query($query)->fetchAll();
        return $participers;
    }

    function add(Participer $participer) : bool {

        // Requête préparée pour ajouter la participation
        $query = "INSERT INTO participer (id_utilisateur, id_partie, gagnant)
            VALUES(:id_utilisateur, :id_partie, '0')";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $participer->getUtilisateur(), PDO::PARAM_INT);
        $prepare->bindValue(":id_partie", $participer->getPartie(), PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function addWinner(Participer $participer) : bool {

        // Requête préparée pour ajouter le gagnant à la participation
        $query = "UPDATE participer SET gagnant = 1
            WHERE id_utilisateur = :id_utilisateur AND id_partie = :id_partie";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $participer->getUtilisateur(), PDO::PARAM_INT);
        $prepare->bindValue(":id_partie", $participer->getPartie(), PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function addScore(Participer $participer, $score) : bool {

        // Requête préparée pour ajouter le score à la participation
        $query = "UPDATE participer SET score = :score
            WHERE id_utilisateur = :id_utilisateur AND id_partie = :id_partie";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $participer->getUtilisateur(), PDO::PARAM_INT);
        $prepare->bindValue(":id_partie", $participer->getPartie(), PDO::PARAM_INT);
        $prepare->bindValue(":score", $score, PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function findAllByUser(int $utilisateurId, int $limit = 5, bool $desc = false) {

        // Requête préparée pour récupérer les participations de l'utilisateur
        $query = "SELECT gagnant, score, date_partie, duree_partie, id_mode_de_jeu, id_difficulte
            FROM participer
            INNER JOIN partie ON partie.id_partie = participer.id_partie
            WHERE id_utilisateur = :id_utilisateur
            ORDER BY partie.id_partie";

        if ($desc) {
            $query .= " DESC";
        }

        $query .= " LIMIT :limit";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $utilisateurId, PDO::PARAM_INT);
        $prepare->bindValue("limit", $limit, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetchAll();
    }

    function findByUserAndGame(int $utilisateurId, int $partieId) {

        // Requête préparée pour récupérer la participation de l'utilisateur
        $query = "SELECT id_utilisateur AS utilisateur_participer, id_partie AS partie_participer, gagnant
            FROM participer
            WHERE id_utilisateur = :id_utilisateur AND id_partie = :id_partie";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $utilisateurId, PDO::PARAM_INT);
        $prepare->bindValue(":id_partie", $partieId, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}