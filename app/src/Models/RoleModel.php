<?php

namespace Xaphan67\SudokuMaster\Models;

class RoleModel extends Model {
    function getAll() {
        $query = "SELECT * FROM role";
        $roles = $this->_db->query($query)->fetchAll();
        return $roles;
    }
}