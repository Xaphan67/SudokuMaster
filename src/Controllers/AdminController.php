<?php

namespace Xaphan67\SudokuMaster\Controllers;

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

        // Affiche le gabarit accueil
        $this->_display("admin/accueil");
    }
}