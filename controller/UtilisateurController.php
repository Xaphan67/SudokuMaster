<?php

    require("model/UtilisateurModel.php");
    require("model/entities/Utilisateur.php");

    class UtilisateurController {

        // Affiche la page d'inscription
        public function signUp() {

            // Si le formulaire est soumis
            if (count($_POST) > 0) {

                // Filtrage des données
                // Protège contre la faille XSS
                $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);

                // Hashe le mot de passe de l'utilisateur
                $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);

                // Crée un tableau avec les données de l'utilisateur
                $donneesUtilisateur["pseudo"] = $pseudo;
                $donneesUtilisateur["email"] = $email;
                $donneesUtilisateur["mdp"] = $mdp;

                // Crée un nouvel objet Utilisateur et l'hydrate avec les données
                $utilisateur = new Utilisateur;
                $utilisateur->hydrate($donneesUtilisateur);

                // Crée une instance du modèle Utilisateur et appelle la méthode
                // pour insérer l'utilisateur en base de données
                $utilisateurModel = new UtilisateurModel;
                $utilisateurAjoute = $utilisateurModel->add($utilisateur);

                // Si l'utilisateur à été ajouté correctement en base de données
                if ($utilisateurAjoute) {

                    // Redirige l'utilisateur vers la page de connexion
                    header("Location:index.php?controller=utilisateur&action=login");
                }
            }

            // Affiche le formulaire
            require_once("view/partials/header.php");
            include("view/utilisateur/inscription.php");
            require_once("view/partials/footer.php");
        }

        // Affiche la page de connexion
        public function login() {
            require_once("view/partials/header.php");
            include("view/utilisateur/connexion.php");
            require_once("view/partials/footer.php");
        }

        // Deconnecte l'utilisateur
        public function logout() {

        }

        // Affiche le profil de l'utilisateur
        public function profil() {
            require_once("view/partials/header.php");
            include("view/utilisateur/profil.php");
            require_once("view/partials/footer.php");
        }
    }