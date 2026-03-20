<?php

namespace Xaphan67\SudokuMaster\Services;

class ResponseService {

    // Redirection vers une url précise
    public function redirect(string $url): void
    {
        header("Location:" . $url);
        exit();
    }
}