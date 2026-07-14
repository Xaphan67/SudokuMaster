<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Charge les variables d'environnement de test
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env.test');
$dotenv->load();