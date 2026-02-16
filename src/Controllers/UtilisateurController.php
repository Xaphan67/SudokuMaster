<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Api\PartieApi;
use Xaphan67\SudokuMaster\Entities\Classer;
use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\BannissementModel;
use Xaphan67\SudokuMaster\Models\ClasserModel;
use Xaphan67\SudokuMaster\Models\ParticiperModel;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class UtilisateurController extends Controller {

    // Affiche la page d'inscription
    public function signUp() {

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:profil");
            exit();
        }

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire est soumis
        if (count($_POST) > 0) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->_checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

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
            else if(!preg_match("/(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S/", $_POST["mdp"])) {
                $erreurs["mdp"] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un nombre et un caractère spécial";
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
                $utilisateurID = $utilisateurModel->add($utilisateur);

                // Si l'utilisateur à été ajouté correctement en base de données
                if ($utilisateurID) {

                    // Crée une instance du modèle Classer
                    $classerModel = new ClasserModel;

                    // Pour chaque mode de jeu, ajoute les statistiques de base du joueur
                    for ($mode = 1; $mode <= 3; $mode++) {

                        // Crée un nouvel objet Classer
                        $classer = new Classer;
                        $classer->setUtilisateur($utilisateurID);
                        $classer->setMode_de_jeu($mode);
                        $classer->setScore_global(1000);

                        // Insère les statistiques en base de donnée
                        $classerModel->add($classer);
                    }

                    // S'il y a des données d'une partie solo précédente en session
                    if (isset($_SESSION["partie_precedente"])) {

                        // Appelle la méthode dans PartieApi pour enregistrer la partie et mettre a à jour les statistiques en base de données
                        $api = new PartieApi;
                        $api->register($utilisateurID);
                    }
                    else {

                        // Redirige l'utilisateur vers la page de connexion
                        header("Location:connexion");
                    }
                }
                else {
                    $erreurs["email"] = "Adresse mail invalide";
                }
            }
        }

        // Génère un token CSRF si aucun en session
        if (!isset($_SESSION["tokenCSRF"]["token"])) {
            $this->_generateCSRFToken();
        }

        // Affiche le gabarit inscription
        // et lui indique les variables nécessaires
        $this->_twig->display("utilisateur/inscription.html.twig",[
            'erreurs' => $erreurs,
            'tokenCSRF' => $_SESSION["tokenCSRF"]["token"]
        ]);
    }

    // Affiche la page de connexion
    public function login() {

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:profil");
            exit();
        }

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire est soumis
        if (count($_POST) > 0) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->_checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

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

                // Crée une instance du modèle Utilisateur
                $utilisateurModel = new UtilisateurModel;

                // Récupère les informations de l'utilisateur et le hash de son mot de passe via son email
                $donneesUtilisateur = $utilisateurModel->findByMail($email);
                $mdpHash = $utilisateurModel->getPasswordHash($email);

                $valide = false;

                // Si l'utilisateur à été trouvé dans la base de données
                if ($donneesUtilisateur) {

                    // Vérifie que le mot de passe entré via le formulaire correspond à l'utilisateur demandé
                    if (password_verify($_POST["mdp"], $mdpHash["mdp_utilisateur"])) {

                        $valide = true;

                        // Crée une instance du modèle Bannissement et appelle la méthode
                        // pour récupérer les bannissements de l'utilisateur
                        $bannissementModel = new BannissementModel;
                        $donneesBannissement = $bannissementModel->findLastByUser($donneesUtilisateur["id_utilisateur"]);

                        // Si un bannissement est trouvé...
                        if ($donneesBannissement) {

                            // Vérifie si l'utilisateur est banni actuellement
                            if (empty($donneesBannissement["date_annulation"])) {
                                if (empty($donneesBannissement["date_fin_bannissement"])) {
                                        $erreurs["banni"] = "Vous avez été banni de manière permannente";
                                        $erreurs["raison_banni"] = $donneesBannissement["raison_bannissement"];
                                }
                                else if ($donneesBannissement["date_fin_bannissement"] > date('Y-m-d H:i', time())) {
                                    $erreurs["banni"] = "Vous avez été banni jusqu'au " . date("d/m/Y H:i", strtotime(($donneesBannissement["date_fin_bannissement"])));
                                    $erreurs["raison_banni"] = $donneesBannissement["raison_bannissement"];
                                }
                            }
                        }

                        // Si l'utilisateur n'est pas banni
                        if (!array_key_exists("banni", $erreurs)) {

                            // Enregistre les données de l'utilisateur en session
                            $_SESSION["utilisateur"] = $donneesUtilisateur;

                            // Si l'utilisateur à été redirigé par une autre page
                            // on le renvoie vers cette page
                            $page = strpos($_SERVER["HTTP_REFERER"], "from=");
                            if ($page) {

                                // Redirige l'utilisateur
                                header("Location:" . substr($_SERVER["HTTP_REFERER"], $page + 5));
                            }
                            else {

                                // Redirige l'utilisateur vers la page d'accueil
                                header("Location:index.php");
                            }
                        }
                    }
                }

                // Si l'utilisateur n'est pas trouvé ou que le mot de passe n'est pas bon
                // Affiche une erreur
                if (!$donneesUtilisateur || !$valide)
                $erreurs["identifiants"] = "Identifiants invalides. Veuillez réessayer";
            }
        }

        // Génère un token CSRF si aucun en session
        if (!isset($_SESSION["tokenCSRF"]["token"])) {
            $this->_generateCSRFToken();
        }

        // Affiche le gabarit connexion
        // et lui indique les variables nécessaires
        $this->_twig->display("utilisateur/connexion.html.twig",[
            'erreurs' => $erreurs,
            'scripts' => ["connexion.js"],
            'tokenCSRF' => $_SESSION["tokenCSRF"]["token"]
        ]);
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

        // Si aucun utilisateur n'est connecté
        if (!isset($_SESSION["utilisateur"])) {

            // Appelle la fonction _forbidden() du controller mère
             $this->_forbidden();
        }

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire de modification des données du compte est soumis
        if (isset($_POST["modifier_compte"])) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->_checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

            // Crée une instance du modèle Utilisateur
            $utilisateurModel = new UtilisateurModel;

            // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
            $utilisateur = new Utilisateur;
            $utilisateur->hydrate($utilisateurModel->findById($_SESSION["utilisateur"]["id_utilisateur"]));

            // Récupère le hash du mot de passe de l'utilisateur via son email
            $mdpHash = $utilisateurModel->getPasswordHash($_SESSION["utilisateur"]["email_utilisateur"]);

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
                if(!preg_match("/(?=\S{8,})(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S/", $_POST["mdp"])) {
                    $erreurs["mdp"] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un nombre et un caractère spécial";
                }
                else if ($_POST["mdp"] != $_POST["mdp_confirm"]) {
                    $erreurs["mdp_confirm"] = "Les mots de passe ne sont pas identiques";
                }
                else {
                    $changerMdp = true;
                }
            }

            if (empty($_POST["mdp_check"])) {
                $erreurs["mdp_check"] = "Ce champ est obligatoire";
            }
            else if (!password_verify($_POST["mdp_check"], $mdpHash["mdp_utilisateur"])) {
                $erreurs["mdp_check"] = "Mot de passe incorrect";
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
                    header("Location:profil");
                    exit();
                }
                else {
                    $erreurs["email"] = "Adresse mail invalide";
                }
            }

            // Ajoute au tableau d'erreurs l'identifiant du formulaire
            $erreurs["formulaire"] = "modifier_compte";

            // Stocke les données saisies par l'utilisateur
            // Pour les afficher à la place de celles en session
            $variablesSaisiesGabarit = ['pseudoSaisi' => $_POST["pseudo"], 'emailSaisi' => $_POST["email"]];
        }

        // Si le formulaire de suppression du compte est soumis
        if (isset($_POST["supprimer_compte"])) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->_checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

            // Crée une instance du modèle Utilisateur
            $utilisateurModel = new UtilisateurModel;

            // Récupère le hash du mot de passe de l'utilisateur via son email
            $mdpHash = $utilisateurModel->getPasswordHash($_SESSION["utilisateur"]["email_utilisateur"]);

            // Test des données
            if (empty($_POST["mdp_check"])) {
                $erreurs["mdp_check"] = "Ce champ est obligatoire";
            }

            if (empty($_POST["mdp_check"])) {
                $erreurs["mdp_check"] = "Ce champ est obligatoire";
            }
            else if (!password_verify($_POST["mdp_check"], $mdpHash["mdp_utilisateur"])) {
                $erreurs["mdp_check"] = "Mot de passe incorrect";
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
                    exit();
                }
            }
            
            // Ajoute au tableau d'erreurs l'identifiant du formulaire
            $erreurs["formulaire"] = "supprimer_compte";
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

        // Crée une instance du modèle Participer et appelle la méthode
        // pour récupérer les participations en base de donnée
        $participerModel = new ParticiperModel;

        // Récupère les participations
        $donneesParticiper = $participerModel->findAllByUser($_SESSION["utilisateur"]["id_utilisateur"], true);

        // Retire l'affichage des heures (qui sera toujours 00:) et tronque les millisecondes
        foreach ($donneesParticiper as $key => $participation) {
            $participation["duree_partie"] = substr($participation["duree_partie"], 3, 5);
            $donneesParticiper[$key] = $participation;
        }

        // Instancie un tableau qui contiendra le nombre de participations par mode
        $participationsModes = [1 => 0, 2 => 0, 3 => 0];

        foreach ($donneesParticiper as $participation) {
            $participationsModes[$participation["id_mode_de_jeu"]] ++;
        }

        // Génère un token CSRF si aucun en session
        if (!isset($_SESSION["tokenCSRF"]["token"])) {
            $this->_generateCSRFToken();
        }

        // Variables à passer au gabarit
        $variablesGabarit = [
            'erreurs' => $erreurs,
            'scripts' => ["profil.js"],
            'statistiques' => $statistiques,
            'participations' => $donneesParticiper,
            'participationsModes' => $participationsModes,
            'tokenCSRF' => $_SESSION["tokenCSRF"]["token"]
        ];
        $donneesGabarit = array_merge($variablesGabarit, $variablesSaisiesGabarit ?? []);

        // Affiche le gabarit profil
        // et lui indique les variables nécessaires
        $this->_twig->display("utilisateur/profil.html.twig", $donneesGabarit);
    }

    // Afficher la page de mot de passe oublié
    public function forgotPassword() {

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:profil");
            exit();
        }

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Déclare une variable pour indiquer à la vue si un email à été envoyé
        $emailEnvoye = false;

        // Si le formulaire est soumis
        if (count($_POST) > 0) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->_checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

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

            // Si il n'y à aucune erreur
            if (count($erreurs) == 0) {

                // Génère un token aléatoire
                $token = bin2hex(random_bytes(16));
                $tokenHash = hash("sha256", $token);
                $tokenDateExpiration = date("Y-m-d H:i:s", time() + 30 * 60); // Heure actuelle + 30 minutes (30 * 60 secondes)

                // Crée une instance du modèle Utilisateur et appelle la méthode
                // pour insérer le token de l'utilisateur en base de données
                $utilisateurModel = new UtilisateurModel;
                $tokenAjoute = $utilisateurModel->setToken($email, $tokenHash, $tokenDateExpiration);

                // Si le tocken à bien été ajouté en base de donnée,
                // appelle le mailer pour envoyer un email à l'utilisateur
                if ($tokenAjoute) {

                    // Ajoute l'adresse mail saisie en tant que destinataire
                    $this->_mailer->addAddress($email);

                    // Ajoute un sujet à l'email
                    $this->_mailer->Subject = "Sudoku Master - Réinitialisation de votre mot de passe";

                    // Ajoute le corps de l'email
                    $this->_mailer->Body = 'Bonjour, Vous avez demandé la réinitialisation de votre mot de passe Sudoku Master.
                    Pour ce faire, merci de cliquer sur <a href="' . $_ENV["DOMAIN_NAME"] . '/reinitialisationMdp?token=' . $token . '">ce lien</a>';

                    // Envoie l'email
                    try {
                        $this->_mailer->send();
                    }
                    catch (\Exception $e) {
                        echo "Erreur d'envoi : " . $this->_mailer->ErrorInfo;
                    }

                }

                // Indiquer à la vue qu'un email à été envoyé
                // (même si aucun envoi, par sécurité)
                $emailEnvoye = true;
            }
        }

        // Génère un token CSRF si aucun en session
        if (!isset($_SESSION["tokenCSRF"]["token"])) {
            $this->_generateCSRFToken();
        }

        // Affiche le gabarit mot de passe oublié
        // et lui indique les variables nécessaires
        $this->_twig->display("utilisateur/oubliMdp.html.twig",[
            'erreurs' => $erreurs,
            'scripts' => ["oubliMdp.js"],
            'emailEnvoye' => $emailEnvoye,
            'tokenCSRF' => $_SESSION["tokenCSRF"]["token"]
        ]);
    }

    // Afficher la page réinitialisation du mot de passe
    public function resetPassword() {

        // Si l'utilisateur est connecté
        if (isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:profil");
            exit();
        }

        // Déclare une variable qui indiquera si le token est valide (existe, non expiré)
        $tokenValide = false;

        // Récupère le token via l'URL, ou dans le post si le formulaire est soumis
        $token = count($_POST) > 0 ? $_POST["token"] : $_GET["token"];
        $tokenHash = hash("sha256", $token);

        // Crée une instance du modèle Utilisateur et appelle la méthode
        // pour récupérer le token de l'utilisateur en base de données
        $utilisateurModel = new UtilisateurModel;
        $donneesToken = $utilisateurModel->findToken($tokenHash);

        // Si le token existe
        if ($donneesToken) {

            // Vérifie si le token a expiré
            if (strtotime($donneesToken["reset_token_date_expiration"]) > time()) {
                $tokenValide = true;
            }
        }

        // Déclare une variable qui indiquera si l'utilisateur à réinitialisé son mot de passe
        $mdpReinitialise = false;

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire est soumis et que le token est valide
        if (count($_POST) > 0 && $tokenValide) {

            // Vérifie la validité du token CSRF
            if (!isset($_POST["tokenCSRF"]) || !$this->_checkCSRFToken($_POST["tokenCSRF"])) {
                $erreurs["general"] = "Une erreur s'est produite, Veuillez ré-essayer";
            }

            // Test des données
            if (empty($_POST["mdp"])) {
                $erreurs["mdp"] = "Ce champ est obligatoire";
            }

            if (empty($_POST["mdp_confirm"])) {
                $erreurs["mdp_confirm"] = "Ce champ est obligatoire";
            }
            else if ($_POST["mdp"] != $_POST["mdp_confirm"]) {
                $erreurs["mdp_confirm"] = "Les mots de passe ne sont pas identiques";
            }

            if (count($erreurs) == 0) {

                 // Hashe le mot de passe de l'utilisateur
                $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);

                // Modifie l'utilisateur en base de données
                // Et supprime les informations de son token
                $utilisateurModifie = $utilisateurModel->resetPassword($tokenHash, $mdp);

                // Si l'utilisateur à été modifié correctement en base de données
                if ($utilisateurModifie) {

                    // Indique que le mot de passe à été réinitialisé
                    $mdpReinitialise = true;
                }
            }
        }

        // Génère un token CSRF si aucun en session
        if (!isset($_SESSION["tokenCSRF"]["token"])) {
            $this->_generateCSRFToken();
        }

        // Affiche le gabarit réinitialisation du mot de passe
        // et lui indique les variables nécessaires
        $this->_twig->display("utilisateur/reinitialisationMdp.html.twig",[
            'erreurs' => $erreurs,
            'token' => $token,
            'tokenValide' => $tokenValide,
            'mdpReinitialise' => $mdpReinitialise,
            'tokenCSRF' => $_SESSION["tokenCSRF"]["token"]
        ]);
    }
}