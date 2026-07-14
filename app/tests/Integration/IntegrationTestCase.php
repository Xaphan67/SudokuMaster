<?php

namespace Xaphan67\SudokuMaster\Tests\Integration;

use PDO;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase {

    protected PDO $_db;
    
    protected function setUp() : void {

        $this->_db = new PDO(
            "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_NAME"],
            $_ENV["DB_USER"],
            $_ENV["DB_PASS"],
            array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
        );
        $this->_db->exec("SET CHARACTER SET utf8");
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Démarre une transaction avant chaque test
        $this->_db->beginTransaction();
    }

    protected function tearDown(): void {

        // Annule les modifications faites pendant le test
        $this->_db->rollBack();
    }
}