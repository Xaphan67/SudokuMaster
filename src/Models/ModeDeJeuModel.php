<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;

class ModeDeJeuModel extends Model {
    function getAll() {
        $query = "SELECT * FROM mode";
        $modes = $this->connect()->query($query)->fetchAll();
        return $modes;
    }

    function findByLabel(string $libelle) {

        // Requête préparée pour récupérer les informations du mode de jeu
        $query =
            "SELECT id_mode_de_jeu, libelle_mode_de_jeu FROM mode_de_jeu
            WHERE libelle_mode_de_jeu=:libelle_mode_de_jeu";

        $prepare = $this->connect()->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":libelle_mode_de_jeu", $libelle, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }
}