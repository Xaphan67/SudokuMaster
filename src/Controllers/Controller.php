<?php

namespace Xaphan67\SudokuMaster\Controllers;

abstract class Controller {

    protected array $_donnees = [];

    // Appelle la vue demandée
    public function display($vue) {

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
}