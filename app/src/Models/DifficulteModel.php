<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;

class DifficulteModel extends Model {
    function getAll() {
        $query = "SELECT * FROM difficulte";
        $difficultes = $this->_db->query($query)->fetchAll();
        return $difficultes;
    }

    function findByLabel(string $libelle) {

        // Requête préparée pour récupérer les informations de la difficulté
        $query =
            "SELECT id_difficulte, libelle_difficulte FROM difficulte
            WHERE libelle_difficulte=:libelle_difficulte";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":libelle_difficulte", $libelle, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}