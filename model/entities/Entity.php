<?php

   class Entity {

        protected string $_strPrefix;

        // Hydrate l'entité en appelant les setters correspondant au tableau $data s'ils existent
        public function hydrate($arrData){
            foreach($arrData as $key=>$value){
                // Si $key contient _$strPrefix, on le supprime. Ex: id_utilisateur devient id.
                if (str_contains($key, "_" . $this->_strPrefix)) {
                    $key = str_replace("_" . $this->_strPrefix, "", $key);
                }

                $strSetterName = "set".ucfirst(str_replace($this->_strPrefix."_", "", $key));
                if (method_exists($this, $strSetterName)){
                    $this->$strSetterName($value);
                }
            }
        }
    }