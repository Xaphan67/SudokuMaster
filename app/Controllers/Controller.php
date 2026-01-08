<?php

namespace app\Controllers;

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
        require_once("app/view/partials/head.php");
        require_once("app/view/partials/header.php");
        include("app/view/" . $vue . ".php");
        require_once("app/view/partials/footer.php");
    }
}