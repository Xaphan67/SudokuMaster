<?php

 require_once "entity.php";

 class Classer extends Entity {
    private string $id;
    private Utilisateur $utilisateur;
    private ModeDeJeu $modeDeJeu;
    private array $statistiques;
    private int $scoreGlobal;
    

    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getUtilisateur() : Utilisateur {
        return $this->utilisateur;
    }

    public function getModeDeJeu() : ModeDeJeu {
        return $this->modeDeJeu;
    }

    public function getStatistiques() : array {
        return $this->statistiques;
    }

    public function getScoreGlobal() : int {
        return $this->scoreGlobal;
    }
   

    // Setters

    public function setId($id) {
        $this->id = $id;
    }

     public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function setModeDeJeu($modeDeJeu) {
        $this->modeDeJeu = $modeDeJeu;
    }

    public function setStatistiques($statistiques) {
        $this->statistiques = $statistiques;
    }

    public function setScoreGlobal($scoreGlobal) {
        $this->scoreGlobal = $scoreGlobal;
    }
    
 }