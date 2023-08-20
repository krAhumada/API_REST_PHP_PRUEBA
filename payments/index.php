<?php

$requestMethod = $_SERVER["REQUEST_METHOD"];

$requestPath = $_SERVER["REQUEST_URI"];

$parametersBody = file_get_contents("php://input");

$parserPath = "/".explode('/', $requestPath)[3];

$routes = [
    "/processPayment" => 'processPayment',
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

    if($parametersBody){

        $controller->$requestMethod($parametersBody);

    }else{

        $controller->$requestMethod();
    }


}else{

    echo json_encode($status_error);

    return;

}