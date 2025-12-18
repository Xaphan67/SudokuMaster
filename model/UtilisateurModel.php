<?php

    require_once "model.php";

    class UtilisateurModel extends Model {
        function getAll() {
            $query = "SELECT * FROM utilisateur";
            $utilisateurs = $this->connect()->query($query)->fetchAll();
            return $utilisateurs;
        }
    }

?>