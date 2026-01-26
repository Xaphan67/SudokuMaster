<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use Xaphan67\SudokuMaster\Entities\Utilisateur;

class UtilisateurModel extends Model {

    function add(Utilisateur $utilisateur) : bool {

        // Requête préparée pour ajouter l'utilisateur
        $query =
            "INSERT INTO utilisateur (pseudo_utilisateur, email_utilisateur, mdp_utilisateur)
            VALUES(:pseudo_utilisateur, :email_utilisateur, :mdp_utilisateur)";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":pseudo_utilisateur", $utilisateur->getPseudo(), PDO::PARAM_STR);
        $prepare->bindValue(":email_utilisateur", $utilisateur->getEmail(), PDO::PARAM_STR);
        $prepare->bindValue(":mdp_utilisateur", $utilisateur->getMdp(), PDO::PARAM_STR);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function edit(Utilisateur $utilisateur) : bool {

        // Requête préparée pour modifier l'utilisateur
        $query =
            "UPDATE utilisateur
            SET pseudo_utilisateur = :pseudo_utilisateur, email_utilisateur = :email_utilisateur";

        if (!empty($utilisateur->getMdp())) {
            $query .= ", mdp_utilisateur = :mdp_utilisateur";
        }

        $query .= " WHERE id_utilisateur = :id_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":pseudo_utilisateur", $utilisateur->getPseudo(), PDO::PARAM_STR);
        $prepare->bindValue(":email_utilisateur", $utilisateur->getEmail(), PDO::PARAM_STR);
        $prepare->bindValue(":id_utilisateur", $utilisateur->getId(), PDO::PARAM_INT);

        if (!empty($utilisateur->getMdp())) {
            $prepare->bindValue(":mdp_utilisateur", $utilisateur->getMdp(), PDO::PARAM_STR);
        }

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function delete(Utilisateur $utilisateur) : bool {

        // Requête préparée pour supprimer (anonymiser) l'utilisateur
        $query =
            "UPDATE utilisateur
            SET pseudo_utilisateur = 'Utilisateur supprimé', email_utilisateur = 'utilisateur@supprime.com', mdp_utilisateur = '', inactif = 1
            WHERE id_utilisateur=:id_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $utilisateur->getId(), PDO::PARAM_INT);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function findAllUsernames() {

        // Requête préparée pour récupérer l'id et le pseudo de tout les utilisateurs
        $query =
            "SELECT id_utilisateur, pseudo_utilisateur FROM utilisateur";

        $prepare = $this->_db->prepare($query);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetchAll();
    }

    function findById(int $id) {

        // Requête préparée pour récupérer les informations de l'utilisateur
        $query =
            "SELECT id_utilisateur, pseudo_utilisateur, email_utilisateur FROM utilisateur
            WHERE id_utilisateur=:id_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":id_utilisateur", $id, PDO::PARAM_INT);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function findByMail(string $email) {

        // Requête préparée pour récupérer les informations de l'utilisateur
        $query =
            "SELECT id_utilisateur, pseudo_utilisateur, email_utilisateur FROM utilisateur
            WHERE email_utilisateur=:email_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":email_utilisateur", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function getPasswordHash(string $email) {

        // Requête préparée pour trouver le hash du mot de passe de l'utilisateur
        $query =
            "SELECT mdp_utilisateur FROM utilisateur
            WHERE email_utilisateur=:email_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":email_utilisateur", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function setToken(string $email, string $tokenHash, string $tokenDateExpiration) {

        // Requête préparée pour stocker le token de changement de mot de passe de l'utilisateur
        $query =
            "UPDATE utilisateur
            SET reset_token_hash = :reset_token_hash, reset_token_date_expiration = :reset_token_date_expiration
            WHERE email_utilisateur=:email_utilisateur";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":reset_token_hash", $tokenHash, PDO::PARAM_STR);
        $prepare->bindValue(":reset_token_date_expiration", $tokenDateExpiration, PDO::PARAM_STR);
        $prepare->bindValue(":email_utilisateur", $email, PDO::PARAM_STR);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }

    function findToken(string $tokenHash) {

        // Requête préparée pour trouver le token de l'utilisateur
        $query =
            "SELECT reset_token_hash, reset_token_date_expiration FROM utilisateur
            WHERE reset_token_hash=:reset_token_hash";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":reset_token_hash", $tokenHash, PDO::PARAM_STR);

        // Execute la requête. Retourne un tableau (si résussite) ou false (si echec)
        $prepare->execute();
        return $prepare->fetch();
    }

    function resetPassword(string $tokenHash, $mdp) : bool {

        // Requête préparée pour modifier l'utilisateur
        $query =
            "UPDATE utilisateur
            SET mdp_utilisateur = :mdp_utilisateur, reset_token_hash = NULL, reset_token_date_expiration = NULL
            WHERE reset_token_hash = :reset_token_hash";

        $prepare = $this->_db->prepare($query);

        // Définition des paramettres de la requête préparée
        $prepare->bindValue(":mdp_utilisateur", $mdp, PDO::PARAM_STR);
        $prepare->bindValue(":reset_token_hash", $tokenHash, PDO::PARAM_STR);

        // Execute la requête. Retourne true (si réussite) ou false (si echec)
        return $prepare->execute();
    }
}