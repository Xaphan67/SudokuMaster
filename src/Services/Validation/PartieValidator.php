<?php

namespace Xaphan67\SudokuMaster\Services\Validation;

class PartieValidator {

    public function validateSalle($salle) : ?string {

        if (empty($salle)) {
            return "Ce champ est obligatire";
        }
        else if (preg_match("/([^0-9])/",($salle))) {
            return "L'ID de la salle ne peut contenir que des chiffres";
        }
        return null;
    }
}