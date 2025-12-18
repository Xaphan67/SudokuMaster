<?php

    require_once "model.php";

    class ClasserModel extends Model {
        function getAll() {
            $query = "SELECT * FROM classer";
            $classers = $this->connect()->query($query)->fetchAll();
            return $classers;
        }
    }

?>