<?php

namespace Xaphan67\SudokuMaster\Entities;

abstract class Entity {

    protected string $_strPrefix;

    // Hydrate l'entité en appelant les setters correspondant au tableau $data s'ils existent
    public function hydrate(array $arrData){
        foreach($arrData as $key=>$value){
            $strSetterName = "set".ucfirst(str_replace("_" . $this->_strPrefix, "", $key));
            if (method_exists($this, $strSetterName)){
                $this->$strSetterName($value);
            }
        }
    }
}