<?php

namespace Xaphan67\SudokuMaster\Api;

class Controller {

    // Renvoie une réponse HTTP signifiant une erreur au format JSON
    public function jsonErrorResponse(int $codeHTTP, string $message) {

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($codeHTTP);

        $json = json_encode([
            'success' => false,
            'message' => $message,
        ]);

        return $json;
    }
}