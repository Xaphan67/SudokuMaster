<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Bannissement;

class BannissementModel extends Model {

    function add(Bannissement $bannissement) {

        // Requête préparée pour ajouter le bannissement
        $query = "INSERT INTO bannissement (id_utilisateur, date_debut_bannissement";

        if (!empty($bannissement->getDate_fin())) {
            $query .= ", date_fin_bannissement";
        }

        $query .= ", raison_bannissement)
            VALUES(:id_utilisateur, :date_debut_bannissement";

        if (!empty($bannissement->getDate_fin())) {
            $query .= ", :date_fin_bannissement";
        }

        $query .= ", :raison_bannissement)";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $bannissement->getUtilisateur(), PDO::PARAM_INT);
        $prepare->bindValue(":date_debut_bannissement", $bannissement->getDate_debut(), PDO::PARAM_STR);

        if (!empty($bannissement->getDate_fin())) {
            $prepare->bindValue(":date_fin_bannissement", $bannissement->getDate_fin(), PDO::PARAM_STR);
        }
        $prepare->bindValue(":raison_bannissement", $bannissement->getRaison(), PDO::PARAM_STR);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function edit(Bannissement $bannissement) : bool {

        // Requête préparée pour modifier le bannissement
        $query =
            "UPDATE bannissement
            SET date_annulation = :date_annulation
            WHERE id_bannissement = :id_bannissement";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":date_annulation", $bannissement->getDate_annulation(), PDO::PARAM_STR);
        $prepare->bindValue(":id_bannissement", $bannissement->getId(), PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function findAllByUser($utilisateurId) {

        // Requête préparée pour récupérer les bannissements d'un utilisateur
        $query = "SELECT date_debut_bannissement, date_fin_bannissement, raison_bannissement, date_annulation
            FROM bannissement
            WHERE id_utilisateur = :id_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $utilisateurId, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetchAll();
    }

    function findLastByUser($utilisateurId) {

        // Requête préparée pour récupérer le dernier bannissement de l'utilisateur
        $query = "SELECT id_bannissement, id_utilisateur, date_debut_bannissement, date_fin_bannissement, raison_bannissement, date_annulation
            FROM bannissement
            WHERE id_utilisateur = :id_utilisateur
            ORDER BY date_debut_bannissement DESC
            LIMIT 1;";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $utilisateurId, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}