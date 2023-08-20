<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $controllerName = 'dynamicToken';

    $controllerFile = "controllers/{$controllerName}.php";

    if (file_exists($controllerFile)) {

        require_once $controllerFile;

        $controller = new $controllerName();

        $controller->post();
    }
}