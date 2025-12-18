<?php

 require_once "entity.php";

 class Participer extends Entity {
    private string $id;
    private string $numeroSalle;
    private array $utilisateurs;
    private Partie $partie;


    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getNumeroSalle() : string {
        return $this->numeroSalle;
    }

    public function getUtilisateurs() : array {
        return $this->utilisateurs;
    }

    public function getPartie() : Partie {
        return $this->partie;
    }


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setNumeroSalle($numeroSalle) {
        $this->numeroSalle = $numeroSalle;
    }

    public function setUtilisateurs($utilisateurs) {
        $this->utilisateurs = $utilisateurs;
    }

    public function setPartie($partie) {
        $this->partie = $partie;
    }
    
 }