<?php

 require_once "entity.php";

 class Participer extends Entity {
    private string $id;
    private ?Utilisateur $utilisateur;
    private Partie $partie;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "participer";
    }

    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getUtilisateur() : ?Utilisateur {
        return $this->utilisateur;
    }

    public function getPartie() : Partie {
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