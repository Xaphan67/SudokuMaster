<?php

 require_once "entity.php";

 class ModeDeJeu extends Entity {
    private string $id;
    private string $libelle;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "mode_de_jeu";
    }

    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
 }