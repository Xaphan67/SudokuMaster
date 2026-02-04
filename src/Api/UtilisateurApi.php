<?php

namespace Xaphan67\SudokuMaster\Api;

use Xaphan67\SudokuMaster\Entities\Utilisateur;
use Xaphan67\SudokuMaster\Models\UtilisateurModel;

class UtilisateurApi {

    function delete() {

        // Récupération des données envoyées par JS
        $json_data = file_get_contents('php://input'); // Lit le corps brut de la requête
        $dataJS = json_decode($json_data, true); // Décode le JSON en tableau associatif

        // Crée une instance du modèle Utilisateur
        $utilisateurModel = new UtilisateurModel;

        // Crée un nouvel objet Utilisateur et l'hydrate avec les données présentes en base de donnée
        $utilisateur = new Utilisateur;
        $utilisateur->hydrate($utilisateurModel->findById($dataJS["id"]));

        // Supprime l'utilisateur en base de données
        $utilisateurSupprime = $utilisateurModel->delete($utilisateur);
    }
}