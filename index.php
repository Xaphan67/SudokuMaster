<?php

    // Démarre la session si elle ne l'est pas déjà
    if (session_status() === PHP_SESSION_NONE){
		session_start();
	}

    // Autoloader de composer
    require 'vendor/autoload.php';

    // Charge DotEnv pour utiliser les fichier .env
    // Permet d'utiliser les super globales $_ENV et $_SERVER
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Détermine le controleur à appeler et son action en fonction de l'url
    $controllerCall = $_GET["controller"] ?? "main";
    $actionCall = $_GET["action"] ?? "home";

    // Détecte si c'est une requête API (préfixe "api-" dans le controller)
    // Si oui, retire le préfixe "api-" du nom du controller
    $isApi = str_starts_with($controllerCall, "api-");
    if ($isApi) {
        $controllerCall = substr($controllerCall, 4);
    }

    // Création du chemin vers le controller
    $controllerName = "Xaphan67\\SudokuMaster\\" . ($isApi ? "Api" : "Controllers") . "\\" . ucfirst($controllerCall) . ($isApi ? "Api" : "Controller");

    // Test sur l'existence du controller
    if (class_exists($controllerName)) {

        // Instanciation du controller
        $controller = new $controllerName();

        // Test sur la présence de la méthode dans le controller
        if (method_exists($controller, $actionCall)) {

            // Appel à la méthode
            $controller->$actionCall();
        }
    }
?>