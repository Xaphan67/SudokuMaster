<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Participer;

class ParticiperModel extends Model {
    function getAll() {
        $query = "SELECT * FROM participer";
        $participers = $this->connect()->query($query)->fetchAll();
        return $participers;
    }

    function add(Participer $participer) : bool {

        // Requête préparée pour ajouter la participation
        $query = "INSERT INTO participer (id_utilisateur, id_partie)
            VALUES(:id_utilisateur, :id_partie)";

        $prepare = $this->connect()->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $participer->getUtilisateur(), PDO::PARAM_INT);
        $prepare->bindValue(":id_partie", $participer->getPartie(), PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }
}