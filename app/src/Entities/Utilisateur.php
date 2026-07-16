<?php

namespace Xaphan67\SudokuMaster\Entities;

class Utilisateur extends Entity {

    private int $id;
    private string $pseudo;
    private string $email;
    private string $mdp;
    private int $role;

    // Constructeur

    function __construct()
    {
        $this->_strPrefix = "utilisateur";
    }

    // Getters

    public function getId() : int {
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

    public function getRole() : int {
        return $this->role;
    }

    // Setters

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setPseudo(string $pseudo) {
        $this->pseudo = $pseudo;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function setMdp(string $mdp) {
        $this->mdp = $mdp;
    }

    public function setRole(int $role) {
        $this->role = $role;
    }
}