<?php

require_once BASE."/app/middleware/auth.php";
require_once BASE."/app/mapping/Route.php";

class Router
{

    public static function reRoute()
    {
        $reqUri = $_SERVER["REQUEST_URI"];
        $reqMethod = $_SERVER["REQUEST_METHOD"];

        // $routes = json_decode(file_get_contents(routeJsonPath), true);

        if (!isset(ROUTES[$reqUri])) {
            require_once redirectPath;
            exit();
        }

        if(isset(ROUTES[$reqUri]) && ROUTES[$reqUri]["httpMethod"]!=$reqMethod){
            http_response_code(405);
            exit();
        }

        $route = ROUTES[$reqUri];
        require_once $route["path"];

        $controllerReflectionClass = new ReflectionClass($route["class"]);

        $controllerMethod = $controllerReflectionClass->getMethod($route["method"]);
        $controllerInstance = $controllerReflectionClass->newInstance();
        //$controllerMethod->invoke($controllerInstance);
        
    }
}
