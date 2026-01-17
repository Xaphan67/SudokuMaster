<?php

namespace Xaphan67\SudokuMaster\Controllers;

abstract class Controller {

    protected array $_donnees = [];

    // Appelle la vue demandée
    protected function display($vue) {

        // Pour chaque variable stockée dans le tableau $donnes,
        // déclare une variable avec la valeur correspondante
        foreach ($this->_donnees as $variable => $valeur){
            $$variable = $valeur;
        }

        // Appelle les partials et la vue
        require_once("view/_partials/head.php");
        require_once("view/_partials/header.php");
        include("view/" . $vue . ".php");
        require_once("view/_partials/footer.php");
    }

    // Affiche la page erreur 404 en cas de page non trouvée
    protected function _notFound() {

        // Indique à la vue les variables nécessaires
        $this->_donnees["titre"] = "La page semble ne pas exister";
        $this->_donnees["texte"] = "On a fait notre possible, mais impossible de retrouver cette page";
        $this->_donnees["image"] = "404";

        // Affiche la vue erreurs
        $this->display("main/erreurs");
    }

    // Affiche la page erreur 403 en cas de page non autorisée
    protected function _forbidden() {

        // Indique à la vue les variables nécessaires
        $this->_donnees["titre"] = "Vous n'avez pas accès à cette page";
        $this->_donnees["texte"] = "Cette page est accessible uniquement aux utilisateurs connectés";
        $this->_donnees["image"] = "403";

        // Affiche la vue erreurs
        $this->display("main/erreurs");
    }
}