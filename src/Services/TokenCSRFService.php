<?php

namespace Xaphan67\SudokuMaster\Services;

class TokenCSRFService {

    // Génère un token CSRF
    public function generateCSRFToken() : string {

        // Génère un token aléatoire
        $tokenGenere = bin2hex(random_bytes(16));
        $tokenExpiration = time() + 60 * 60; // Heure actuelle + 60 minutes (60 * 60 secondes)

        // Stocke le token en session
        $_SESSION["tokenCSRF"]["token"] = $tokenGenere;
        $_SESSION["tokenCSRF"]["expiration"] = $tokenExpiration;

        return $tokenGenere;
    }

    // Vérifie la validité d'un token CSRF
    public function checkCSRFToken($tokenAVerifier) : bool {

        // Vérifie que le token existe en session
        if (!isset($_SESSION["tokenCSRF"]["token"])) {
            return false;
        }

        // Si le token est identique à celui en session 
        if ($_SESSION["tokenCSRF"]["token"] == $tokenAVerifier) {

            // Vérifie que le token n'a pas expiré
            if (time() >= $_SESSION["tokenCSRF"]["expiration"]) {
                return false;
            }

            // Retire les données du token en session
            unset($_SESSION["tokenCSRF"]);

            return true;
        }

        return false;
    }
}