<?php

require_once BASE . "/app/middleware/middleware.php";
require_once(BASE . "/app/attributes/Route.php");


class Router
{
    private static String $reqUri;
    private static String $reqMethod;

    public static function reRoute()
    {
        self::$reqUri = $_SERVER["REQUEST_URI"];
        self::$reqMethod = $_SERVER["REQUEST_METHOD"];

        self::IsParamSet();
        self::IsMethodAllowed();
        middleware::auth(self::$reqUri);   

        $route = ROUTES[self::$reqUri];

        require_once $route["Filepath"];

        $controllerReflectionClass = new ReflectionClass($route["class"]);

        $controllerMethod = $controllerReflectionClass->getMethod($route["method"]);
        $controllerInstance = $controllerReflectionClass->newInstance();
        $controllerMethod->invoke($controllerInstance);
    }

    public static function IsParamSet()
    {

        if (isset(ROUTES[self::$reqUri])) {
            return;
        }

        $explodedUri = (array_values(array_filter(explode("/", self::$reqUri))));

        if (!isset(ROUTES["/" . $explodedUri[0]]) || !isset(ROUTES["/" . $explodedUri[0]]["param"])) {

            http_response_code(404);

            $errorRoutes = json_decode(file_get_contents(BASE . "/app/mapping/errorRoutes.json"), true);
            require_once $errorRoutes["NotFound"];
            exit();
        }

        self::$reqUri = "/" . $explodedUri[0];
        $_GET[ROUTES["/" . $explodedUri[0]]["param"]] = $explodedUri[1];
    }

    private static function IsMethodAllowed()
    {
        if (isset(ROUTES[self::$reqUri]) && ROUTES[self::$reqUri]["httpMethod"] === self::$reqMethod) {
            return;
        }
        http_response_code(405);
        $errorRoutes = json_decode(file_get_contents(BASE . "/app/mapping/errorRoutes.json"), true);
        require_once $errorRoutes["Method_Not_Allowed"];

        exit();
    }
}
