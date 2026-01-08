<?php

 require_once "entity.php";

 class Partie extends Entity {
    private string $id;
    private int $mode_de_jeu;
    private int $difficulte;
    private ?string $duree;
    private ?int $gagnant = null;
    private ?int $co_gagnant;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "partie";
    }

    // Getters

    public function getId() : string {
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

    public function getGagnant() : ?int {
        return $this->gagnant;
    }

    public function getCo_gagnant() : ?int {
        return $this->co_gagnant;
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

    public function setGagnant($gagnant) {
        $this->gagnant = $gagnant;
    }

    public function setCo_gagnant($co_gagnant) {
        $this->co_gagnant = $co_gagnant;
    }

 }