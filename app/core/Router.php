<?php

require_once BASE . "/app/middleware/auth.php";
require_once BASE . "/app/mapping/Route.php";

class Router
{

    public static function reRoute()
    {
        $reqUri = $_SERVER["REQUEST_URI"];
        $reqMethod = $_SERVER["REQUEST_METHOD"];

        $explodedUri = (array_values(array_filter(explode("/", $reqUri))));

        if (!isset(ROUTES[$reqUri])) {
            if (isset(ROUTES["/" . $explodedUri[0]]) && ROUTES["/" . $explodedUri[0]]["param"]) {
                $reqUri="/".$explodedUri[0];
                $_GET[ROUTES["/" . $explodedUri[0]]["param"]]=$explodedUri[1];
            } else {
                require_once redirectPath;
                exit();
            }
        }

        if (isset(ROUTES[$reqUri]) && ROUTES[$reqUri]["httpMethod"] != $reqMethod) {
            http_response_code(405);
            exit();
        }

        $route = ROUTES[$reqUri];
        require_once $route["Filepath"];

        $controllerReflectionClass = new ReflectionClass($route["class"]);

        $controllerMethod = $controllerReflectionClass->getMethod($route["method"]);
        $controllerInstance = $controllerReflectionClass->newInstance();
        $controllerMethod->invoke($controllerInstance);
    }
}
