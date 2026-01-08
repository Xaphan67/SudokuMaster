<?php

    // Démarre la session si elle ne l'est pas déjà
    if (session_status() === PHP_SESSION_NONE){
		session_start();
	}

    // Autoloader de composer
    require 'vendor/autoload.php';

    // Détermine le controleur à appeler et son action en fonction de l'url
    $controllerCall = $_GET["controller"] ?? "main";
    $actionCall = $_GET["action"] ?? "home";

    // Flag sur la présence de la page
    $bool404 = false;
    
    // Création du chemin vers le controller
    $controllerName = 'Xaphan67\\SudokuMaster\\Controllers\\' . ucfirst($controllerCall).'Controller';

    // Test sur l'existence du controller
    if (class_exists($controllerName)) {

        // Instanciation du controller
        $controller = new $controllerName();


        // Test sur la présence de la méthode dans le controller
        if (method_exists($controller, $actionCall)) {

            // Appel à la méthode
            $controller->$actionCall();

        }else{
            $bool404 = true;
        }

    }else{
        $bool404 = true;
    }
    
    // si un des éléments non trouvé => redirection vers page 404
    /*if ($bool404) {
        header("Location:index.php?controller=errors&action=error_404");
        exit();
    }*/
?>