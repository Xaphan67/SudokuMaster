<?php

namespace Xaphan67\SudokuMaster\Services\Validation;

use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class AdminValidator {

    public function validateRole(int $id) : ?string {

        // Crée une instance du modèle Utilisateur
        $utilisateurModel = new UtilisateurModel;

        // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
        $utilisateur = new Utilisateur;
        $utilisateur->hydrate($utilisateurModel->findById($id));

        // Récupère le rôle de l'utilisateur
        $role = $utilisateur->getRole();

        // Si le rôle correspond à l'administrateur, empèche le bannissement
        if ($role == 1) {
            return "Impossible de bannir cet utilisateur";
        }
        return null;
    }

    public function validateDate(string $date, string $maintenant) : ?string {

        if (!empty($date) && $date < $maintenant) {
            return "La date de fin ne peut pas déjà être passée";
        }
        return null;
    }

    public function validateRaison(string $raison) : ?string {

        if (!empty($raison)) {
            return "Ce champ est obligatoire";
        }
        return null;
    }
}