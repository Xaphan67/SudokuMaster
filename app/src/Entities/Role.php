<?php

namespace Xaphan67\SudokuMaster\Entities;

class Role extends Entity {

    private int $id;
    private string $libelle;

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