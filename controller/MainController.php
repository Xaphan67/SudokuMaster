<?php

    class MainController {

        // Affiche la page d'accueil
        public function home() {
            require_once("view/partials/header.php");
            include("view/main/accueil.php");
            require_once("view/partials/footer.php");
        }

        // Affiche la page des classements
        public function leaderboard() {
            require_once("view/partials/header.php");
            include("view/main/classements.php");
            require_once("view/partials/footer.php");
        }

        // Affiche la page des règles
        public function rules() {
            require_once("view/partials/header.php");
            include("view/main/regles.php");
            require_once("view/partials/footer.php");
        }

        // Affiche la page des mentions légales
        public function legals() {
            require_once("view/partials/header.php");
            include("view/main/mentions.php");
            require_once("view/partials/footer.php");
        }

        // Affiche la page des conditions générales d'utilisation
        public function gcu() {
            require_once("view/partials/header.php");
            include("view/main/cgu.php");
            require_once("view/partials/footer.php");
        }
    }