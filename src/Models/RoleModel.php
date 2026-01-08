<?php

namespace Xaphan67\SudokuMaster\Models;

class RoleModel extends Model {
    function getAll() {
        $query = "SELECT * FROM role";
        $roles = $this->connect()->query($query)->fetchAll();
        return $roles;
    }
}