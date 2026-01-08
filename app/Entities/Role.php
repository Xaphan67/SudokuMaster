<?php

namespace app\Entities;

class Role extends Entity {

    private string $id;
    private string $libelle;

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