<?php

 require_once "entity.php";

 class Partie extends Entity {
    private string $id;
    private ModeDeJeu $modeDeJeu;
    private Difficulte $difficulte;
    private int $duree;
    private Utilisateur $utilisateurGagnant = null;
    

    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getModeDeJeu() : ModeDeJeu {
        return $this->modeDeJeu;
    }

    public function getDifficulte() : Difficulte {
        return $this->difficulte;
    }

    public function getDuree() : int {
        return $this->duree;
    }

    public function getUtilisateurGagnant() : Utilisateur {
        return $this->utilisateurGagnant;
    }


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setModeDeJeu($modeDeJeu) {
        $this->modeDeJeu = $modeDeJeu;
    }

    public function setDifficulte($difficulte) {
        $this->difficulte = $difficulte;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
    }

    public function setUtilisateurGagnant($utilisateurGagnant) {
        $this->utilisateurGagnant = $utilisateurGagnant;
    }
    
 }