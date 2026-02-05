<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Bannissement;

class BannissementModel extends Model {

    function add(Bannissement $bannissement) {

        // Requête préparée pour ajouter les statistiques
        $query = "INSERT INTO bannissement (id_utilisateur, date_debut_bannissement, date_fin_bannissement, raison_bannissement)
            VALUES(:id_utilisateur, :date_debut_bannissement, :date_fin_bannissement, :raison_bannissement)";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $bannissement->getUtilisateur(), PDO::PARAM_INT);
        $prepare->bindValue(":date_debut_bannissement", $bannissement->getDate_debut(), PDO::PARAM_STR);
        $prepare->bindValue(":date_fin_bannissement", $bannissement->getDate_fin(), PDO::PARAM_STR);
        $prepare->bindValue(":raison_bannissement", $bannissement->getRaison(), PDO::PARAM_STR);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function findAllByUser($utilisateurId) {

        // Requête préparée pour ajouter les statistiques
        $query = "SELECT date_debut_bannissement, date_fin_bannissement, raison_bannissement
            FROM bannissement
            WHERE id_utilisateur = :id_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $utilisateurId, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetchAll();
    }
}