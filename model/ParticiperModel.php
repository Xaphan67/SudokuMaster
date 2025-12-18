<?php

    require_once "model.php";

    class ParticiperModel extends Model {
        function getAll() {
            $query = "SELECT * FROM participer";
            $participers = $this->connect()->query($query)->fetchAll();
            return $participers;
        }
    }

?>