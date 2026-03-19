<?php

namespace Xaphan67\SudokuMaster\Services\Validation;

class UtilisateurValidator {

    // Validation champ "pseudo"
    public function validatePseudo(string $pseudo) : ?string {

        if (empty($pseudo)) {
            return "Ce champ est obligatire";
        }
        return null;
    }

    // Validation champ "email"
    public function validateEmail(string $email) : ?string {

        if (empty($email)) {
            return "Ce champ est obligatoire";
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Adresse mail invalide";
        }
        return null;
    }

    // Validation champ "mot de passe"
    public function validateMotDePasse(string $mdp) : ?string {

        if (empty($mdp)) {
            return "Ce champ est obligatoire";
        }
        else if(!preg_match("/(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S/", $_POST["mdp"])) {
            return "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un nombre et un caractère spécial";
        }
        return null;
    }

    // Validation champ "confirmation mot de passe"
    public function validateMotDePasseConfirm(string $mdp, string $mdpConfirm) {

        if (empty($mdp)) {
            return "Ce champ est obligatoire";
        }
        else if ($mdp != $mdpConfirm) {
            return "Les mots de passe ne sont pas identiques";
        }
    }

    // Validation champ "conditions"
    public function validateConditions(bool $conditions) : ?string {

        if (!$conditions) {
            return "Vous devez accepter les conditions d'utilisation";
        }
        return null;
    }

    // Validation champ 'mot de passe check"
    public function validateMotDePasseCheck(string $mdp, string $mdpHash) : ?string {

        if (empty($mdp)) {
            return "Ce champ est obligatoire";
        }
        else if (!password_verify($mdp, $mdpHash)) {
            return "Mot de passe incorrect";
        }
        return null;
    }
}