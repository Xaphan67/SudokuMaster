<?php

    require("model/ClasserModel.php");
    require("model/entities/Classer.php");

    class MainController {

        // Affiche la page d'accueil
        public function home() {
            require_once("view/partials/header.php");
            include("view/main/accueil.php");
            require_once("view/partials/footer.php");
        }

        // Affiche la page des classements
        public function leaderboard() {

            // Déclare un tableau vide $classement qui contiendra une entrée par mode de jeu
            $classements = [];

            // Pour chaque mode de jeu...
            for ($mode = 1; $mode <= 3; $mode++) {

                // Crée une instance du modèle Classer et appelle la méthode
                // pour récupérer les statistiques du mode en base de donnée
                $classerModel = new ClasserModel;
                $donneesClasser = $classerModel->findAllByMode($mode, 10);

                // Ajoute les statistiques du mode dans le tableau $classement
                $classements[$mode] = $donneesClasser;
            }

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