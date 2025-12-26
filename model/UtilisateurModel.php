<?php

    require_once "model.php";

    class UtilisateurModel extends Model {
        function getAll() {
            $query = "SELECT * FROM utilisateur";
            $utilisateurs = $this->connect()->query($query)->fetchAll();
            return $utilisateurs;
        }

        function add(Utilisateur $utilisateur) : bool {

            // Requête préparée pour ajouter l'utilisateur
            $query =
               "INSERT INTO utilisateur (pseudo, email, mdp)
                VALUES(:pseudo, :email, :mdp)";

            $prepare = $this->connect()->prepare($query);

            // Définition des paramettres de la requête préparée
            $prepare->bindValue(":pseudo", $utilisateur->getPseudo(), PDO::PARAM_STR);
			$prepare->bindValue(":email", $utilisateur->getEmail(), PDO::PARAM_STR);
			$prepare->bindValue(":mdp", $utilisateur->getMdp(), PDO::PARAM_STR);

            // Execute la requête. Retourne true (si réussite) ou false (si echec)
            return $prepare->execute();
        }

        function findByMail(string $email) {

            // Requête préparée pour récupérer les informations de l'utilisateur
            $query =
                "SELECT id_utilisateur, pseudo, email  FROM utilisateur
                WHERE email=:email";

            $prepare = $this->connect()->prepare($query);

            // Définition des paramettres de la requête préparée
			$prepare->bindValue(":email", $email, PDO::PARAM_STR);

            // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
            $prepare->execute();
            return $prepare->fetch();
        }

        function getPasswordHash(string $email) {

            // Requête préparée pour trouver le hash du mort de passe de l'utilisateur
            $query =
                "SELECT mdp FROM utilisateur
                WHERE email=:email";

            $prepare = $this->connect()->prepare($query);

            // Définition des paramettres de la requête préparée
			$prepare->bindValue(":email", $email, PDO::PARAM_STR);

            // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
            $prepare->execute();
            return $prepare->fetch();
        }
    }

?>