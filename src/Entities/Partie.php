<?php

namespace Xaphan67\SudokuMaster\Entities;

class Partie extends Entity {

    private int $id;
    private int $mode_de_jeu;
    private int $difficulte;
    private ?string $duree;
    private ?string $solution;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "partie";
    }

    // Getters

    public function getId() : int {
        return $this->id;
    }

    public function getMode_de_jeu() : int {
        return $this->mode_de_jeu;
    }

    public function getDifficulte() : int {
        return $this->difficulte;
    }

    public function getDuree() : ?string {
        return $this->duree;
    }

    public function getSolution() : ?string {
        return $this->solution;
    }

    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setMode_de_jeu($mode_de_jeu) {
        $this->mode_de_jeu = $mode_de_jeu;
    }

    public function setDifficulte($difficulte) {
        $this->difficulte = $difficulte;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
    }

    public function setSolution($solution) {
        $this->solution = $solution;
    }
}