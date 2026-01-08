<?php

namespace Xaphan67\SudokuMaster\Entities;

class Difficulte extends Entity {

    private string $id;
    private string $libelle;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "difficulte";
    }

    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
}