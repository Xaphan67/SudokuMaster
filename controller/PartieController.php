<?php

    class PartieController {

        // Afficher l'écran de partie solo
        public function soloBoard() {
            require_once("view/partials/header.php");
            include("view/partie/jeuSolo.php");
            require_once("view/partials/footer.php");
        }
    }