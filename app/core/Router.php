<?php

require_once BASE . "/app/middleware/middleware.php";
require_once(BASE."/app/attributes/Route.php");

class Router
{

    public static function reRoute()
    {
        $reqUri = $_SERVER["REQUEST_URI"];
        $reqMethod = $_SERVER["REQUEST_METHOD"];

        $explodedUri = (array_values(array_filter(explode("/", $reqUri))));

        if (!isset(ROUTES[$reqUri])) {
            if (isset(ROUTES["/" . $explodedUri[0]]) && ROUTES["/" . $explodedUri[0]]["param"]) {
                $reqUri = "/" . $explodedUri[0];
                $_GET[ROUTES["/" . $explodedUri[0]]["param"]] = $explodedUri[1];
            } else {
                $errorRoutes = json_decode(file_get_contents(BASE . "/app/mapping/errorRoutes.json"),true);
                require_once $errorRoutes["NotFound"];
                http_response_code(404);
                exit();
            }
        }

        if (isset(ROUTES[$reqUri]) && ROUTES[$reqUri]["httpMethod"] != $reqMethod) {
            $errorRoutes = json_decode(file_get_contents(BASE . "/app/mapping/errorRoutes.json"),true);
            require_once $errorRoutes["Method_Not_Allowed"];
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
