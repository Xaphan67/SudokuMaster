<?php

    class Model {
        const HOST = "localhost";
        const DB = "sudoku_master";
        const USER = "root";
        const PASS = "";

        // Connexion à la base de données en utilisant les informations çi dessus
        function connect() {
            try {
                return new PDO("mysql:host=" . Model::HOST . ";dbname=" . Model::DB . ";charset=utf8",
                    Model::USER,
                    Model::PASS,
                    array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
            }
            catch (PDOException $ex) {
                return $ex->getMessage(); // Retourne un message d'erreur en cas de problème
            }
        }
    }

?>