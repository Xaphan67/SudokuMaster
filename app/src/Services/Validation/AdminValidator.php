<?php

namespace Xaphan67\SudokuMaster\Services\Validation;

class AdminValidator {

    public function validateDate(string $date, string $maintenant) : ?string {

        if (!empty($date) && $date < $maintenant) {
            return "La date de fin ne peut pas déjà être passée";
        }
        return null;
    }

    public function validateRaison(string $raison) : ?string {

        if (!empty($raison)) {
            return "Ce champ est obligatoire";
        }
        return null;
    }
}