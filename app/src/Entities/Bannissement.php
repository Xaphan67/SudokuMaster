<?php

namespace Xaphan67\SudokuMaster\Entities;

class Bannissement extends Entity {

    private int $id;
    private int $utilisateur;
    private string $date_debut;
    private ?string $date_fin;
    private string $raison;
    private ?string $date_annulation;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "bannissement";
    }

    // Getters

    public function getId() : int {
        return $this->id;
    }

    public function getUtilisateur() : int {
        return $this->utilisateur;
    }

    public function getDate_debut() : string {
        return $this->date_debut;
    }

    public function getDate_fin() : string {
        return $this->date_fin;
    }

    public function getRaison() : string {
        return $this->raison;
    }

    public function getDate_annulation() : string {
        return $this->date_annulation;
    }

    // Setters

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setUtilisateur(int $utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function setDate_debut(string $date_debut) {
        $this->date_debut = $date_debut;
    }

    public function setDate_fin(?string $date_fin) {
        $this->date_fin = $date_fin;
    }

    public function setRaison(string $raison) {
        $this->raison = $raison;
    }

    public function setDate_annulation(?string $date_annulation) {
        $this->date_annulation = $date_annulation;
    }
}