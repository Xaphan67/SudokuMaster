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
        require_once("view/partials/head.php");
        require_once("view/partials/header.php");
        include("view/" . $vue . ".php");
        require_once("view/partials/footer.php");
    }

    // Redirection vers la page erreur 404 en cas de page non trouvée
    protected function _notFound() {

        // Indique à la vue les variables nécessaires
        $this->_donnees["titre"] = "La page semble ne pas exister";
        $this->_donnees["texte"] = "On a fait notre possible, mais impossible de retrouver cette page";
        $this->_donnees["image"] = "404";

        // Affiche la vue erreurs
        $this->display("erreur/erreurs");
    }
}