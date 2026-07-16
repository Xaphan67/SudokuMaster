<?php

namespace Xaphan67\SudokuMaster\Entities;

class Difficulte extends Entity {

    private int $id;
    private string $libelle;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "difficulte";
    }

    // Getters

    public function getId() : int {
        return $this->id;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }


    // Setters

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setLibelle(string $libelle) {
        $this->libelle = $libelle;
    }
}