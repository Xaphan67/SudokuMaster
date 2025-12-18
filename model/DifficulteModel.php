<?php

    require_once "model.php";

    class DifficulteModel extends Model {
        function getAll() {
            $query = "SELECT * FROM difficulte";
            $difficultes = $this->connect()->query($query)->fetchAll();
            return $difficultes;
        }
    }

?>