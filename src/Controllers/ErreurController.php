<?php

namespace Xaphan67\SudokuMaster\Controllers;

class ErreurController extends Controller {

    // Affiche une erreur 404
    public function erreur404() {

        // Appèle la fonction _notFound() du controller mère
        $this->_notFound();
    }
}