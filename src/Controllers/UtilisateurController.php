<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Entities\Classer;
use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\ClasserModel;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class UtilisateurController extends Controller {

    // Affiche la page d'inscription
    public function signUp() {

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:index.php?controller=utilisateur&action=profil&utilisateur_id=" . $_SESSION["utilisateur"]["id_utilisateur"]);
        }
        else {

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

                    // Crée un nouvel objet Utilisateur et l'hydrate avec les données
                    $utilisateur = new Utilisateur;
                    $utilisateur->setPseudo($pseudo);
                    $utilisateur->setEmail($email);
                    $utilisateur->setMdp($mdp);

                    // Crée une instance du modèle Utilisateur et appelle la méthode
                    // pour insérer l'utilisateur en base de données
                    $utilisateurModel = new UtilisateurModel;
                    $utilisateurAjoute = $utilisateurModel->add($utilisateur);

                    // Si l'utilisateur à été ajouté correctement en base de données
                    if ($utilisateurAjoute) {

                        // Si l'utilisateur à été redirigé par une autre page
                        // on le renvoie vers cette page
                        if (isset($_GET["from"])) {

                            // Récupère le contrôleur et la méthode à appeler
                            $infos = explode(':',$_GET["from"]);

                            // Redirige l'utilisateur
                            header("Location:index.php?controller=" . $infos[0] . "&action=" . $infos[1]);
                        }
                        else {

                            // Redirige l'utilisateur vers la page de connexion
                            header("Location:index.php?controller=utilisateur&action=login");
                        }
                    }
                }
            }

            // Affiche la vue inscription
            $this->display("utilisateur/inscription");
        }
    }

    // Affiche la page de connexion
    public function login() {

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:index.php?controller=utilisateur&action=profil&utilisateur_id=" . $_SESSION["utilisateur"]["id_utilisateur"]);
        }
        else {

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
                        if (password_verify($_POST["mdp"], $mdpHash["mdp_utilisateur"])) {

                            // Enregistre les données de l'utilisateur en session
                            $_SESSION["utilisateur"] = $donneesUtilisateur;

                            // Si l'utilisateur à été redirigé par une autre page
                            // on le renvoie vers cette page
                            if (isset($_GET["from"])) {

                                // Récupère le contrôleur et la méthode à appeler
                                $infos = explode(':',$_GET["from"]);

                                // Redirige l'utilisateur
                                header("Location:index.php?controller=" . $infos[0] . "&action=" . $infos[1]);
                            }
                            else {

                                // Redirige l'utilisateur vers la page d'accueil
                                header("Location:index.php");
                            }
                        }
                    }

                    // Si l'utilisateur n'est pas trouvé ou que le mot de passe n'est pas bon
                    // Affiche une erreur
                        $erreurs["identifiants"] = "Identifiants invalides. Veuillez réessayer";
                }
            }

            // Affiche la vue connexion
            $this->display("utilisateur/connexion");
        }
    }

    // Déconnecte l'utilisateur
    public function logout() {

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Retire l'utilisateur de la session
            unset($_SESSION["utilisateur"]);
        }

        // Redirige l'utilisateur vers la page d'accueil
        header("Location:index.php");
    }

    // Affiche le profil de l'utilisateur
    public function profil() {

        // Indique à la vue le fichier JS à utiliser
        $script = ["profil.js"];
        $this->_donnees["script"] = $script;

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Crée un tableau pour gérer les erreurs
            $erreurs = [];

            // Si le formulaire de modification des données du compte est soumis
            if (isset($_POST["modifier_compte"])) {

                // Crée une instance du modèle Utilisateur
                $utilisateurModel = new UtilisateurModel;

                // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
                $utilisateur = new Utilisateur;
                $utilisateur->hydrate($utilisateurModel->findById($_SESSION["utilisateur"]["id_utilisateur"]));

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

                $changerMdp = false;
                if (!empty($_POST["mdp"])) {
                    if ($_POST["mdp"] != $_POST["mdp_confirm"]) {
                        $erreurs["mdp_confirm"] = "Les mots de passe ne sont pas identiques";
                    }
                    else {
                        $changerMdp = true;
                    }
                }

                if (empty($_POST["mdp_check"])) {
                    $erreurs["mdp_check"] = "Ce champ est obligatoire";
                }

                // Si il n'y à aucune erreur
                if (count($erreurs) == 0) {

                    // S'il faut changer le mot de passe
                    if ($changerMdp) {

                        // Hashe le mot de passe de l'utilisateur
                        $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
                    }

                    // Hhydrate l'objet utilisateur avec les données mises à jour
                    $utilisateur->setId($_SESSION["utilisateur"]["id_utilisateur"]);
                    $utilisateur->setPseudo($pseudo);
                    $utilisateur->setEmail($email);
                    $utilisateur->setMdp(isset($mdp) ? $mdp : "");

                    // Modifie l'utilisateur en base de données
                    $utilisateurModifie = $utilisateurModel->edit($utilisateur);

                    // Si l'utilisateur à été modifié correctement en base de données
                    if ($utilisateurModifie) {

                        // Met à jour les données en session
                        $_SESSION["utilisateur"]["pseudo_utilisateur"] = $utilisateur->getPseudo();
                        $_SESSION["utilisateur"]["email_utilisateur"] = $utilisateur->getEmail();

                        // Redirige l'utilisateur vers la page de son profil
                        header("Location:index.php?controller=utilisateur&action=profil&utilisateur_id=" . $utilisateur->getId());
                    }
                }
                else {

                    // Ajoute au tableau d'erreurs l'identifiant du formulaire
                    $erreurs["formulaire"] = "modifier_compte";

                    // Stocke les données saisies par l'utilisateur
                    // Pour les afficher à la place de celles en session
                    $pseudoSaisi = $_POST["pseudo"];
                    $emailSaisi = $_POST["email"];
                }
            }

            // Si le formulaire de suppression du compte est soumis
            if (isset($_POST["supprimer_compte"])) {

                // Crée une instance du modèle Utilisateur
                $utilisateurModel = new UtilisateurModel;

                // Test des données
                if (empty($_POST["mdp_check"])) {
                    $erreurs["mdp_check"] = "Ce champ est obligatoire";
                }

                // Si il n'y à aucune erreur
                if (count($erreurs) == 0) {

                    // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
                    $utilisateur = new Utilisateur;
                    $utilisateur->hydrate($utilisateurModel->findById($_SESSION["utilisateur"]["id_utilisateur"]));

                    // Supprime l'utilisateur en base de données
                    $utilisateurSupprime = $utilisateurModel->delete($utilisateur);

                    // Si l'utilisateur à été supprimé correctement en base de données
                    if ($utilisateurSupprime) {

                        // Détruit la session en cours
                        session_destroy();

                        // Redirige l'utilisateur vers la page d'accueil
                        header("Location:index.php");
                    }
                }
                else {

                    // Ajoute au tableau d'erreurs l'identifiant du formulaire
                    $erreurs["formulaire"] = "supprimer_compte";
                }
            }

            // Crée une instance du modèle Classer et appelle la méthode
            // pour récupérer les statistiques en base de donnée
            $classerModel = new ClasserModel;

            // Instancie un tableau qui contiendra les statistiques
            $statistiques = [];

            // Pour chaque mode de jeu, récupère les statistiques
            for($mode = 1; $mode <= 3; $mode++) {
                $donneesClasser = $classerModel->findByUserAndMode($_SESSION["utilisateur"]["id_utilisateur"], $mode);

                // S'il y à des statistiques pour le mode
                if ($donneesClasser) {

                    // Retire l'affichage des heures (qui sera toujours 00:) et tronque les millisecondes
                    $donneesClasser["temps_moyen"] = substr($donneesClasser["temps_moyen"], 3, 5);
                    $donneesClasser["meilleur_temps"] = substr($donneesClasser["meilleur_temps"], 3, 5);

                    // Crée un nouvel objet Classer et l'hydrate avec les données
                    $classer = new Classer;
                    $classer->hydrate($donneesClasser);

                    // Ajoute l'objet Classer au tableau de statistiques
                    $statistiques[$mode] = $classer;
                }
            };

            // Indique à la vue le tableau statistiques
            $this->_donnees["statistiques"] = $statistiques;

            // Affiche la vue profil
            $this->display("utilisateur/profil");
        }
        else {

            // Redirige l'utilisateur vers la page d'accueil
            header("Location:index.php");
        }
    }
}