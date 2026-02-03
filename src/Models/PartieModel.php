<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Partie;

class PartieModel extends Model {
    function getAll() {
        $query = "SELECT * FROM partie";
        $parties = $this->_db->query($query)->fetchAll();
        return $parties;
    }

    function add(Partie $partie, bool $duree = false) {

        // Requête préparée pour ajouter la partie
        $query =
            "INSERT INTO partie (id_mode_de_jeu, id_difficulte, duree_partie, date_partie)
            VALUES (:id_mode_de_jeu, :id_difficulte, ";

        if ($duree) {
            $query .= ":duree_partie";
        }
        else {
            $query .= "'00:15:00'";
        }

        $query .= ", CURRENT_DATE)";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_mode_de_jeu", $partie->getMode_de_jeu(), PDO::PARAM_INT);
        $prepare->bindValue(":id_difficulte", $partie->getDifficulte(), PDO::PARAM_INT);

        if ($duree) {
            $prepare->bindValue(":duree_partie", $partie->getDuree(), PDO::PARAM_STR);
        }

        // Execute la requête. Retourne l'ID de la partie insérée (si réussite) ou false (si echec)
        if ($prepare->execute()) {

            // Retourner l'ID de la partie insérée
            return $this->_db->lastInsertId();
        }
        else {
            return false;
        }
    }

    function setTime(Partie $partie) : bool {

        // Requête préparée pour modifier la durée de la partie
        $query =
            "UPDATE partie SET duree_partie = :duree_partie
             WHERE id_partie = :id_partie";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":duree_partie", $partie->getDuree(), PDO::PARAM_STR);
        $prepare->bindValue(":id_partie", $partie->getId(), PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function findById($id) {

        // Requête préparée pour récupérer les informations de la partie
        $query =
            "SELECT id_partie, duree_partie, id_mode_de_jeu, id_difficulte FROM partie
            WHERE id_partie=:id_partie";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_partie", $id, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function getAverageTime($id, $mode) {

        // Requête préparée pour trouver le temps moyen de l'utilisateur
        $query =
            "SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(duree_partie))) AS temps_moyen
            FROM partie
            INNER JOIN participer ON participer.id_partie = partie.id_partie
            WHERE id_utilisateur = :id_utilisateur AND id_mode_de_jeu = :id_mode_de_jeu";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $id, PDO::PARAM_INT);
        $prepare->bindValue("id_mode_de_jeu", $mode, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function getBestTime($id, $mode) {

        // Requête préparée pour trouver le meilleur temps de l'utilisateur
        $query =
            "SELECT MIN(duree_partie) AS meilleur_temps
            FROM partie
            INNER JOIN participer ON participer.id_partie = partie.id_partie
            WHERE id_utilisateur = :id_utilisateur AND id_mode_de_jeu = :id_mode_de_jeu";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $id, PDO::PARAM_INT);
        $prepare->bindValue("id_mode_de_jeu", $mode, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}