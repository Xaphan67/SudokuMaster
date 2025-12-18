<?php

    class UtilisateurController {

        // Affiche la page d'inscription
        public function signUp() {
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