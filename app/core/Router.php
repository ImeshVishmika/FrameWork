<?php

require_once "../app/middleware/auth.php";
require_once BASE . "/app/mapping/Route.php";


class Router
{

    public static function reRoute()
    {
        $reqUri = $_SERVER["REQUEST_URI"];
        $reqMethod = $_SERVER["REQUEST_METHOD"];

        $classes = json_decode(file_get_contents(BASE . "\app\core\\routes.json"), true);

        if (!isset($classes[$reqUri])) {
            require_once BASE . "/app/views/User/invliadUrl.php";
            return;
        }

        $path = $classes[$reqUri];
        require_once $path;

        $class = pathinfo($path)['filename'];

        $controllerReflectionClass = new ReflectionClass($class);
        $controllerMethods = $controllerReflectionClass->getMethods();
        $controllerMethod = null;

        foreach ($controllerMethods as $method) {
            $attributes = $method->getAttributes(Route::class);

            foreach ($attributes as $attribute) {

                $attributeInstance = $attribute->newInstance();

                if ($attributeInstance->path == strrchr($reqUri, "/")) {
                    $controllerMethod = $method;
                    break;
                };
            }
        }

        $controllerMethod->invoke($controllerReflectionClass->newInstance());
    }
}
