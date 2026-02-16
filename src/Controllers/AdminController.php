<?php

namespace Xaphan67\SudokuMaster\Controllers;

use Xaphan67\SudokuMaster\Entities\Bannissement;
use Xaphan67\SudokuMaster\Models\BannissementModel;
use Xaphan67\SudokuMaster\Models\PartieModel;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class AdminController extends Controller {

    // Affiche la page d'accueil de l'administration
    public function home() {

        // Si l'utilisateur n'est pas connecté
        if (!isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:index.php");
            exit();
        }
        else {

            // Si l'utilisateur n'a pas le rôle administrateur
            if ($_SESSION["utilisateur"]["id_role"] != 1) {

                // Appelle la fonction _forbidden() du controller mère
                $this->_forbidden();
            }
        }

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire est soumis
        if (count($_POST) > 0) {

            // Filtrage des données
            // Protège contre la faille XSS
            $raison = trim(filter_input(INPUT_POST, "raison", FILTER_SANITIZE_SPECIAL_CHARS));
            $date = str_replace("T", " ", $_POST["dateFin"]);
            $maintenant = date('Y-m-d H:i', time());

            // Test des données
            if (!empty($date) && $date < $maintenant) {
                $erreurs["dateFin"] = "La date de fin ne peut pas déjà être passée";
            }

            if (!$raison) {
                $erreurs["raison"] = "Ce champ est obligatoire";
            }

            // Si il n'y à aucune erreur
            if (count($erreurs) == 0) {

                // Crée un nouvel objet Banissement et l'ydrate avec les données
                $banissement = new Bannissement;
                $banissement->setUtilisateur($_POST["id_utilisateur"]);
                $banissement->setDate_debut($maintenant);
                $banissement->setDate_fin($date);
                $banissement->setRaison($raison);

                // Crée une instance du modèle Bannissement et appelle la méthode
                // pour ajouter le bannissement en base de données
                $banissementModel = new BannissementModel;
                $banissementModel->add($banissement);
            }
        }

        // Récupère la liste des utilisateurs
        $utilisateurModel = new UtilisateurModel;
        $utilisateurs = $utilisateurModel->findAll(5, true);

        // Récupère la liste des parties
        $partieModel = new PartieModel;
        $parties = $partieModel->findAll(10, true);

        // Retire l'affichage des heures (qui sera toujours 00:) et tronque les millisecondes
        foreach ($parties as $key => $partie) {
            $partie["duree_partie"] = substr($partie["duree_partie"], 3, 5);
            $parties[$key] = $partie;
        }

        // Fusionne les joueurs ayant participé à la même partie dans un nouveau tableau
        $partiesFusion = [];
        foreach ($parties as $partie) {
            if (!isset($partiesFusion[$partie["id_partie"]])) {
                $partiesFusion[$partie["id_partie"]] = $partie;
                $partiesFusion[$partie["id_partie"]]["pseudo_utilisateur_2"] = "";
                $partiesFusion[$partie["id_partie"]]["gagnant_2"] = "";
            }
            else {
                $partiesFusion[$partie["id_partie"]]["pseudo_utilisateur_2"] = $partie["pseudo_utilisateur"];
                $partiesFusion[$partie["id_partie"]]["gagnant_2"] = $partie["gagnant"];
            }
        }

        // Garde uniquement 5 parties
        $parties = array_slice($partiesFusion, 0, 5);

        // S'il y a au moins une erreur dans le formulaire
        // Ajoute l'ID de l'utilisateur au tableau d'erreurs pour le récupérer en JS
        if (count($erreurs) > 0) {
            $erreurs["id_utilisateur"] = $_POST["id_utilisateur"];
        }

        // Affiche le gabarit accueil
        // et lui indique les variables nécessaires
        $this->_twig->display("admin/accueil.html.twig",[
            'scripts' => ["admin.js"],
            'erreurs' => $erreurs,
            'utilisateurs' => $utilisateurs,
            'parties' => $parties
        ]);
    }

    // Page de gestion des utilisateurs
    public function usersManagement() {

        // Si l'utilisateur n'est pas connecté
        if (!isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:index.php");
            exit();
        }
        else {

            // Si l'utilisateur n'a pas le rôle administrateur
            if ($_SESSION["utilisateur"]["id_role"] != 1) {

                // Appelle la fonction _forbidden() du controller mère
                $this->_forbidden();
            }
        }

        // Crée un tableau pour gérer les erreurs
        $erreurs = [];

        // Si le formulaire est soumis
        if (count($_POST) > 0) {

            // Filtrage des données
            // Protège contre la faille XSS
            $raison = trim(filter_input(INPUT_POST, "raison", FILTER_SANITIZE_SPECIAL_CHARS));
            $date = str_replace("T", " ", $_POST["dateFin"]);
            $maintenant = date('Y-m-d H:i', time());

            // Test des données
            if (!empty($date) && $date < $maintenant) {
                $erreurs["dateFin"] = "La date de fin ne peut pas déjà être passée";
            }

            if (!$raison) {
                $erreurs["raison"] = "Ce champ est obligatoire";
            }

            // Si il n'y à aucune erreur
            if (count($erreurs) == 0) {

                // Crée un nouvel objet Banissement et l'ydrate avec les données
                $banissement = new Bannissement;
                $banissement->setUtilisateur($_POST["id_utilisateur"]);
                $banissement->setDate_debut($maintenant);
                $banissement->setDate_fin($date);
                $banissement->setRaison($raison);

                // Crée une instance du modèle Bannissement et appelle la méthode
                // pour ajouter le bannissement en base de données
                $banissementModel = new BannissementModel;
                $banissementModel->add($banissement);
            }
        }

        // Récupère la liste des utilisateurs
        $utilisateurModel = new UtilisateurModel;
        $utilisateurs = $utilisateurModel->findAll(desc: true);

        // S'il y a au moins une erreur dans le formulaire
        // Ajoute l'ID de l'utilisateur au tableau d'erreurs pour le récupérer en JS
        if (count($erreurs) > 0) {
            $erreurs["id_utilisateur"] = $_POST["id_utilisateur"];
        }

        // Affiche le gabarit gestion utilisateurs
        // et lui indique les variables nécessaires
        $this->_twig->display("admin/gestionUtilisateurs.html.twig",[
            'scripts' => ["admin.js"],
            'erreurs' => $erreurs,
            'utilisateurs' => $utilisateurs
        ]);
    }

    // Page de gestion des parties
    public function gamesManagement() {

        // Si l'utilisateur n'est pas connecté
        if (!isset($_SESSION["utilisateur"])) {

            // Redirige l'utilisateur vers la page de son profil
            header("Location:index.php");
            exit();
        }
        else {

            // Si l'utilisateur n'a pas le rôle administrateur
            if ($_SESSION["utilisateur"]["id_role"] != 1) {

                // Appelle la fonction _forbidden() du controller mère
                $this->_forbidden();
            }
        }

        // Récupère la liste des parties
        $partieModel = new PartieModel;
        $parties = $partieModel->findAll(desc: true);

        // Retire l'affichage des heures (qui sera toujours 00:) et tronque les millisecondes
        foreach ($parties as $key => $partie) {
            $partie["duree_partie"] = substr($partie["duree_partie"], 3, 5);
            $parties[$key] = $partie;
        }

        // Fusionne les joueurs ayant participé à la même partie dans un nouveau tableau
        $partiesFusion = [];
        foreach ($parties as $partie) {
            if (!isset($partiesFusion[$partie["id_partie"]])) {
                $partiesFusion[$partie["id_partie"]] = $partie;
                $partiesFusion[$partie["id_partie"]]["pseudo_utilisateur_2"] = "";
                $partiesFusion[$partie["id_partie"]]["gagnant_2"] = "";
            }
            else {
                $partiesFusion[$partie["id_partie"]]["pseudo_utilisateur_2"] = $partie["pseudo_utilisateur"];
                $partiesFusion[$partie["id_partie"]]["gagnant_2"] = $partie["gagnant"];
            }
        }

        // Affiche le gabarit gestion parties
        // et lui indique les variables nécessaires
        $this->_twig->display("admin/gestionParties.html.twig",[
            'scripts' => ["admin.js"],
            'parties' => $partiesFusion
        ]);
    }
}