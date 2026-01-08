<?php

namespace app\Models;

class RoleModel extends Model {
    function getAll() {
        $query = "SELECT * FROM role";
        $roles = $this->connect()->query($query)->fetchAll();
        return $roles;
    }
}