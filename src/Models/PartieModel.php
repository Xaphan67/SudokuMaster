<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Partie;

class PartieModel extends Model {
    function getAll() {
        $query = "SELECT * FROM partie";
        $parties = $this->connect()->query($query)->fetchAll();
        return $parties;
    }

    function add(Partie $partie) {

        $db = $this->connect();

        // Requête préparée pour ajouter la partie
        $query =
            "INSERT INTO partie (id_mode_de_jeu, id_difficulte, duree_partie)
            VALUES (:id_mode_de_jeu, :id_difficulte, '00:15:00')";

        $prepare = $db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_mode_de_jeu", $partie->getMode_de_jeu(), PDO::PARAM_INT);
        $prepare->bindValue(":id_difficulte", $partie->getDifficulte(), PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        $prepare->execute();

        /* Devrait retourner l'ID de la partie insérée mais retourne toujours 1 ?
        $partieID = $db->lastInsertId() */

        // Retourne l'ID de la partie ajoutée

        // Requête préparée pour pour récupérer l'ID de la dernière partie
        $query = "SELECT COUNT(*) AS id_partie FROM partie";

        $prepare = $db->prepare($query);
        $prepare->execute();
        $partieID = $prepare->fetch();

        return $partieID["id_partie"];
    }

    function edit(Partie $partie) : bool {

        // Requête préparée pour modifier la partie
        $query =
            "UPDATE partie SET";

        $multiple = false;

        if (!empty($partie->getDuree())) {
            $query .= " duree_partie = :duree_partie";
            $multiple = true;
        }

        if (!empty($partie->getGagnant())) {
            $query .= $multiple ? "," : "";
            $query .= " gagnant_partie = :gagnant_partie";
            $multiple = true;
        }

        if (!empty($partie->getCo_gagnant())) {
            $query .= $multiple ? "," : "";
            $query .= " co_gagnant_partie = :co_gagnant_partie";
        }

        $query .= " WHERE id_partie = :id_partie";

        $prepare = $this->connect()->prepare($query);

        // Définition des paramettres de la requête préparée
        if (!empty($partie->getDuree())) {
            $prepare->bindValue(":duree_partie", $partie->getDuree(), PDO::PARAM_STR);
        }

        if (!empty($partie->getGagnant())) {
            $prepare->bindValue(":gagnant_partie", $partie->getGagnant(), PDO::PARAM_INT);
        }

        if (!empty($partie->getCo_gagnant())) {
            $prepare->bindValue(":co_gagnant_partie", $partie->getCo_gagnant(), PDO::PARAM_INT);
        }

        $prepare->bindValue(":id_partie", $partie->getId(), PDO::PARAM_INT);


        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function findById($id) {

        // Requête préparée pour récupérer les informations de la partie
        $query =
            "SELECT id_partie, duree_partie, gagnant_partie, co_gagnant_partie, id_mode_de_jeu, id_difficulte FROM partie
            WHERE id_partie=:id_partie";

        $prepare = $this->connect()->prepare($query);

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

        $prepare = $this->connect()->prepare($query);

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

        $prepare = $this->connect()->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $id, PDO::PARAM_INT);
        $prepare->bindValue("id_mode_de_jeu", $mode, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}