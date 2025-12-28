<?php

    require_once "model.php";

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
               "INSERT INTO partie (id_mode_de_jeu, id_difficulte)
                VALUES (:id_mode_de_jeu, :id_difficulte)";

            $prepare = $db->prepare($query);

            // Définition des paramettres de la requête préparée
            $prepare->bindValue(":id_mode_de_jeu", $partie->getMode_de_jeu()->getId(), PDO::PARAM_INT);
			$prepare->bindValue(":id_difficulte", $partie->getDifficulte()->getId(), PDO::PARAM_INT);

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
    }

?>