<?php

    require_once "model.php";

    class ClasserModel extends Model {
        function getAll() {
            $query = "SELECT * FROM classer";
            $classers = $this->connect()->query($query)->fetchAll();
            return $classers;
        }

        function add(Classer $classer) {

            // Requête préparée pour ajouter les statistiques
            $query = "INSERT INTO classer (id_utilisateur, id_mode_de_jeu, score_global, grilles_jouees, grilles_resolues, temps_moyen, meilleur_temps, serie_victoires)
                VALUES(:id_utilisateur, :id_mode_de_jeu, '0', '1', '0', '00:00:00', '00:00:00', '0')";

            $prepare = $this->connect()->prepare($query);

            // Définition des paramettres de la requête préparée
            $prepare->bindValue(":id_utilisateur", $classer->getUtilisateur()->getId(), PDO::PARAM_INT);
			$prepare->bindValue(":id_mode_de_jeu", $classer->getMode_de_jeu()->getId(), PDO::PARAM_INT);

            // Execute la requête. Retourne true (si réussite) ou false (si echec)
            return $prepare->execute();
        }

        function edit(Classer $classer) {

            // Requête préparée pour modifier les statistiques
            $query =
                "UPDATE classer
                SET score_global = :score_global, grilles_jouees = :grilles_jouees, grilles_resolues = :grilles_resolues, temps_moyen = :temps_moyen, meilleur_temps = :meilleur_temps, serie_victoires = :serie_victoires
                WHERE id_utilisateur = :id_utilisateur AND id_mode_de_jeu = :id_mode_de_jeu";

            $prepare = $this->connect()->prepare($query);

            // Définition des paramettres de la requête préparée
            $prepare->bindValue(":score_global", $classer->getScore_global(), PDO::PARAM_INT);
			$prepare->bindValue(":grilles_jouees", $classer->getGrilles_jouees(), PDO::PARAM_INT);
            $prepare->bindValue(":grilles_resolues", $classer->getGrilles_resolues(), PDO::PARAM_INT);
            $prepare->bindValue(":temps_moyen", $classer->getTemps_moyen(), PDO::PARAM_STR);
			$prepare->bindValue(":meilleur_temps", $classer->getMeilleur_temps(), PDO::PARAM_STR);
            $prepare->bindValue(":serie_victoires", $classer->getSerie_victoires(), PDO::PARAM_INT);
            $prepare->bindValue(":id_utilisateur", $classer->getUtilisateur()->getId(), PDO::PARAM_INT);
			$prepare->bindValue(":id_mode_de_jeu", $classer->getMode_de_jeu()->getId(), PDO::PARAM_INT);

            // Execute la requête. Retourne true (si réussite) ou false (si echec)
            return $prepare->execute();
        }

        function findByUserAndMode(int $utilisateurId, int $modeId) {

            // Requête préparée pour récupérer les sttistiques de l'utilisateur
            $query =
                "SELECT score_global, grilles_jouees, grilles_resolues, temps_moyen, meilleur_temps, serie_victoires FROM classer
                WHERE id_utilisateur=:id_utilisateur AND id_mode_de_jeu = :id_mode_de_jeu";

            $prepare = $this->connect()->prepare($query);

            // Définition des paramettres de la requête préparée
			$prepare->bindValue(":id_utilisateur", $utilisateurId, PDO::PARAM_INT);
            $prepare->bindValue(":id_mode_de_jeu", $modeId, PDO::PARAM_INT);

            // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
            $prepare->execute();
            return $prepare->fetch();
        }
    }

?>