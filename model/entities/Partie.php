<?php

 require_once "entity.php";

 class Partie extends Entity {
    private string $id;
    private ModeDeJeu $mode_de_jeu;
    private Difficulte $difficulte;
    private int $duree;
    private ?Utilisateur $gagnant = null;
    private string $numero_salle;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "partie";
    }


    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getMode_de_jeu() : ModeDeJeu {
        return $this->mode_de_jeu;
    }

    public function getDifficulte() : Difficulte {
        return $this->difficulte;
    }

    public function getDuree() : int {
        return $this->duree;
    }

    public function getGagnant() : ?Utilisateur {
        return $this->gagnant;
    }

    public function getNumero_salle() : string {
        return $this->numero_salle;
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

    public function setNumero_salle($numero_salle) {
        $this->numero_salle = $numero_salle;
    }

 }