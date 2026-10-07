<?php
require_once BASE . "/app/mapping/Route.php";
require_once BASE . "/app/mapping/PathParam.php";

class Mapping
{

    private static String $controllerPath = BASE . "/app/controllers";
    private static String $redirectPath = BASE . "/app/views/error/404.php";
    private static String $routesJsonPath = BASE . "/app/core/routes.json";


    public static function config()
    {
        define("redirectPath", self::$redirectPath);
        define("routesJsonPath", self::$routesJsonPath);
        // $output = shell_exec('git status -u '.self::$controllerPath);
        $output = shell_exec('git status ');

        if ($output == null) {
            define("ROUTES", json_decode(file_get_contents(routesJsonPath), true));
            return;
        }

        $controllerPathList = new RecursiveDirectoryIterator(self::$controllerPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($controllerPathList);

        $routes = [];

        foreach ($iterator as $file) {
            // $fileName = str_replace(".php", "", $file->getFilename());
            $fileName = $file->getBasename(".php");
            require_once $file;

            $reflectionClass = new ReflectionClass($fileName);
            $classAttributes = $reflectionClass->getAttributes(Route::class);
            $classRouteInstance = $classAttributes != null
                ? $classAttributes[0]->newInstance()
                : new Route("");

            $classMethods = $reflectionClass->getMethods();

            foreach ($classMethods as $classMethod) {

                if ($classMethod->getAttributes() == []) {
                    continue;
                }

                $route = [];
                foreach ($classMethod->getAttributes() as $methodAttribute) {

                    $methodAttributeInstance = $methodAttribute->newInstance();
                    $attributeReflectionclass = new ReflectionClass($methodAttribute->getName());


                    foreach ($attributeReflectionclass->getProperties() as $propertie) {
                        $propertieName = $propertie->getName();
                        $route[$propertieName] = $methodAttributeInstance->$propertieName;
                        //echo $methodAttributeInstance->$propertieName;
                    }
                    $route["class"]=$file->getBasename(".php");
                    $route["method"]=$classMethod->getName();
                    $route["Filepath"]= $file->getPathname();
                }

                $routes[$classRouteInstance->path.$route["path"]]= $route;
            }

        }

        file_put_contents(
            routesJsonPath,
            json_encode($routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            LOCK_EX
        );

        define("ROUTES", $routes);
    }


    public static function setController(String $controllerPath)
    {
        self::$controllerPath = $controllerPath;
    }

    public static function setInvalidPathRedirect(String $redirectPath)
    {
        self::$redirectPath = $redirectPath;
    }

    public static function setRouteJsonPath(String $routesJsonPath)
    {
        self::$routesJsonPath = $routesJsonPath;
    }
}
