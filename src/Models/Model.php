<?php

namespace Xaphan67\SudokuMaster\Models;

use PDO;
use PDOException;

abstract class Model {

    protected object $_db;
    private static ?PDO $_dbInstance = null;

    const HOST = "localhost";
    const DB = "sudoku_master";
    const USER = "root";
    const PASS = "";

    public function __construct(){

        // Récupère ou crée la connexion (singleton)
        if (self::$_dbInstance === null) {
            try{
                self::$_dbInstance = new PDO(
                    "mysql:host=" . Model::HOST . ";dbname=" . Model::DB . "",
                    Model::USER,
                    Model::PASS,
                    array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
                );
                self::$_dbInstance->exec("SET CHARACTER SET utf8");
                self::$_dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Échec : " . $e->getMessage();
            }
        }

        // Assigne la connexion
        $this->_db = self::$_dbInstance;
    }
}