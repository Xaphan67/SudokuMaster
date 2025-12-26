<?php

    require("model/UtilisateurModel.php");
    require("model/entities/Utilisateur.php");

    class UtilisateurController {

        // Affiche la page d'inscription
        public function signUp() {

            // Crée un tableau pour gérer les erreurs
            $erreurs = [];

            // Si le formulaire est soumis
            if (count($_POST) > 0) {

                // Filtrage des données
                // Protège contre la faille XSS
                $pseudo = trim(filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS));
                $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));

                // Test si l'email est dans un format valide
                $emailValide = filter_var($email, FILTER_VALIDATE_EMAIL);

                // Test des données
                if (!$pseudo) {
                    $erreurs["pseudo"] = "Ce champ est obligatoire";
                }

                if (!$email) {
                    $erreurs["email"] = "Ce champ est obligatoire";
                }
                else if (!$emailValide) {
                    $erreurs["email"] = "Adresse mail invalide";
                }

                if (empty($_POST["mdp"])) {
                    $erreurs["mdp"] = "Ce champ est obligatoire";
                }

                if (empty($_POST["mdp_confirm"])) {
                    $erreurs["mdp_confirm"] = "Ce champ est obligatoire";
                }
                else if ($_POST["mdp"] != $_POST["mdp_confirm"]) {
                    $erreurs["mdp_confirm"] = "Les mots de passe ne sont pas identiques";
                }

                // Si il n'y à aucune erreur
                if (count($erreurs) == 0) {

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
            }

            // Affiche le formulaire
            require_once("view/partials/header.php");
            include("view/utilisateur/inscription.php");
            require_once("view/partials/footer.php");
        }

        // Affiche la page de connexion
        public function login() {

            // Crée un tableau pour gérer les erreurs
            $erreurs = [];

            // Si le formulaire est soumis
            if (count($_POST) > 0) {

                // Filtrage des données
                // Protège contre la faille XSS
                $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));

                // Test si l'email est dans un format valide
                $emailValide = filter_var($email, FILTER_VALIDATE_EMAIL);

                // Test des données
                if (!$email) {
                    $erreurs["email"] = "Ce champ est obligatoire";
                }
                else if (!$emailValide) {
                    $erreurs["email"] = "Adresse mail invalide";
                }

                if (empty($_POST["mdp"])) {
                    $erreurs["mdp"] = "Ce champ est obligatoire";
                }

                // Si il n'y à aucune erreur
                if (count($erreurs) == 0) {

                    // Crée une instance du modèle Utilisateur et appelle la méthode
                    $utilisateurModel = new UtilisateurModel;

                    // Récupère les informations de l'utilisateur et le hash de son mot de passe via son email
                    $donneesUtilisateur = $utilisateurModel->findByMail($email);
                    $mdpHash = $utilisateurModel->getPasswordHash($email);

                    // Si l'utilisateur à été trouvé dans la base de données
                    if ($donneesUtilisateur) {

                        // Vérifie que le mot de passe entré via le formulaire correspond à l'utilisateur demandé
                        if (password_verify($_POST["mdp"], $mdpHash["mdp"])) {

                            // Enregistre les données de l'utilisateur en session
                            $_SESSION["utilisateur"] = $donneesUtilisateur;

                            // Redirige l'utilisateur vers la page d'accueil
                            header("Location:index.php");
                        }
                    }

                    // Si l'utilisateur n'est pas trouvé ou que le mot de passe n'est pas bon
                    // Affiche une erreur
                     $erreurs["identifiants"] = "Identifiants invalides. Veuillez réessayer";
                }
            }

            // Affiche le formulaire
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