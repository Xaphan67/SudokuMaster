<?php

namespace app\Entities;

class Participer extends Entity {

    private string $id;
    private ?int $utilisateur;
    private int $partie;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "participer";
    }

    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getUtilisateur() : ?int {
        return $this->utilisateur;
    }

    public function getPartie() : int {
        return $this->partie;
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
}