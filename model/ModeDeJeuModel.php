<?php

    require_once "model.php";

    class ModeDeJeuModel extends Model {
        function getAll() {
            $query = "SELECT * FROM mode";
            $modes = $this->connect()->query($query)->fetchAll();
            return $modes;
        }
    }

?>