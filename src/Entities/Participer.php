<?php

namespace Xaphan67\SudokuMaster\Entities;

class Participer extends Entity {

    private int $id;
    private ?int $utilisateur;
    private int $partie;
    private int $gagnant;
    private int $score;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "participer";
    }

    // Getters

    public function getId() : int {
        return $this->id;
    }

    public function getUtilisateur() : ?int {
        return $this->utilisateur;
    }

    public function getPartie() : int {
        return $this->partie;
    }

    public function getGagnant() : int {
        return $this->gagnant;
    }

    public function getScore() : int {
        return $this->score;
    }

    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function setPartie($partie) {
        $this->partie = $partie;
    }

    public function setGagnant($gagnant) {
        $this->gagnant = $gagnant;
    }

    public function setScore($score) {
        $this->score = $score;
    }
}