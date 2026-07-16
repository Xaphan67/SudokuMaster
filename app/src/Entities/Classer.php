<?php

namespace Xaphan67\SudokuMaster\Entities;

class Classer extends Entity {

    private int $id;
    private int $utilisateur;
    private int $mode_de_jeu;
    private int $grilles_jouees;
    private int $grilles_resolues;
    private string $temps_moyen;
    private string $meilleur_temps;
    private int $serie_victoires;
    private int $score_global;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "classer";
    }

    // Getters

    public function getId() : int {
        return $this->id;
    }

    public function getUtilisateur() : int {
        return $this->utilisateur;
    }

    public function getMode_de_jeu() : int {
        return $this->mode_de_jeu;
    }

    public function getGrilles_jouees() : int {
        return $this->grilles_jouees;
    }

    public function getGrilles_resolues() : int {
        return $this->grilles_resolues;
    }

    public function getTemps_moyen() : string {
        return $this->temps_moyen;
    }

    public function getMeilleur_temps() : string {
        return $this->meilleur_temps;
    }

    public function getSerie_victoires() : int {
        return $this->serie_victoires;
    }

    public function getScore_global() : int {
        return $this->score_global;
    }


    // Setters

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setUtilisateur(int $utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function setMode_de_jeu(int $mode_de_jeu) {
        $this->mode_de_jeu = $mode_de_jeu;
    }

    public function setGrilles_jouees(int $grilles_jouees) {
        $this->grilles_jouees = $grilles_jouees;
    }

    public function setGrilles_resolues(int $grilles_resolues) {
        $this->grilles_resolues = $grilles_resolues;
    }

    public function setTemps_moyen(string $temps_moyen) {
        $this->temps_moyen = $temps_moyen;
    }

    public function setMeilleur_temps(string $meilleur_temps) {
        $this->meilleur_temps = $meilleur_temps;
    }

    public function setSerie_victoires(int $serie_victoires) {
        $this->serie_victoires = $serie_victoires;
    }

    public function setScore_global(int $score_global) {
        $this->score_global = $score_global;
    }
}