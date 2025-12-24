<?php

    // Détermine le controleur à appeler et son action en fonction de l'url
    $controller = $_GET["controller"] ?? "main";
    $action = $_GET["action"] ?? "home";

    $controllerPath = "controller/" . $controller . "Controller.php";

    // Si le controleur existe, on l'appelle
    if (file_exists($controllerPath)) {
        require_once($controllerPath);
        $controllerName = $controller . "Controller";

        // Si la méthode qui correspond à l'action existe, on l'appelle
        if (class_exists($controllerName)) {
            $newController = new $controllerName();
            if (method_exists($newController, $action)) {
                $newController->$action();
            }
        }
    }
?>