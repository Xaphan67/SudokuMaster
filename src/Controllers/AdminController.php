<?php

namespace Xaphan67\SudokuMaster\Controllers;

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

        // Indique au gabarit les variables nécessaires
        $scripts = ["admin.js"];
        $this->_donnees["scripts"] = $scripts;
        $this->_donnees["utilisateurs"] = $utilisateurs;
        $this->_donnees["parties"] = $parties;

        // Affiche le gabarit accueil
        $this->_display("admin/accueil");
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

        // Récupère la liste des utilisateurs
        $utilisateurModel = new UtilisateurModel;
        $utilisateurs = $utilisateurModel->findAll(desc: true);

        // Indique au gabarit les variables nécessaires
        $scripts = ["admin.js"];
        $this->_donnees["scripts"] = $scripts;
        $this->_donnees["utilisateurs"] = $utilisateurs;

        // Affiche le gabarit gestion utilisateurs
        $this->_display("admin/gestionUtilisateurs");
    }
}