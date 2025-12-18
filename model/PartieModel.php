<?php

    require_once "model.php";

    class PartieModel extends Model {
        function getAll() {
            $query = "SELECT * FROM partie";
            $parties = $this->connect()->query($query)->fetchAll();
            return $parties;
        }
    }

?>