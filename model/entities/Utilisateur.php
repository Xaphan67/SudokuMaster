<?php

 require_once "entity.php";

 class Utilisateur extends Entity {
    private string $id;
    private string $pseudo;
    private string $email;
    private string $mdp;
    private Role $role;


    // Getters

    public function getId() : string {
        return $this->id;
    }

    public function getPseudo() : string {
        return $this->pseudo;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getMdp() : string {
        return $this->mdp;
    }

    public function getRole() : Role {
        return $this->role;
    }


    // Setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }

    public function setRole($role) {
        $this->role = $role;
    }


    // Autres méthodes

    public function supprimerCompte() {
        
    }

 }