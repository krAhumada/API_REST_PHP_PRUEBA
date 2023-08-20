<?php

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestPath = $_SERVER["REQUEST_URI"];

$tokenStatic = $_SERVER["HTTP_TOKEN"];

$parserPath = "/".explode('/', $requestPath)[3];

$routes = [
    "/generateToken" => 'generateToken',
    "/validateToken" => 'validateToken',
];

$status_error = array(
    "status" => "error",
    "code" => "404",
    "message" => "recurso no encontrado"
);

if (array_key_exists($parserPath, $routes)){

    $controllerName = $routes[$parserPath];

    $controllerFile = "controllers/{$controllerName}.php";

    if (!file_exists($controllerFile)){

        echo json_encode($status_error);

        return;
    }

    require_once $controllerFile;

    $controller = new $controllerName();

    $controller->$requestMethod($tokenStatic);

}else{

    echo json_encode($status_error);

    return;

}
