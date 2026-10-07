<?php
require_once(BASE."/app/attributes/Route.php");
require_once BASE . "/app/attributes/PathParam.php";

class Mapping
{

    private static String $controllerDir = BASE . "/app/controllers";
    private static String $redirectDir = BASE . "/app/views/error";
    private static String $mappDir = BASE . "/app/mapping/";


    public static function config()
    {
        $output = shell_exec('git status ');

        if ($output == null) {
            define("ROUTES", json_decode(file_get_contents(self::$mappDir."/routes.json"), true));
            return;
        }

        $controllerDirList = new RecursiveDirectoryIterator(self::$controllerDir, RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($controllerDirList);

        $routes = [];

        foreach ($iterator as $file) {
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
                    }
                    $route["class"]=$file->getBasename(".php");
                    $route["method"]=$classMethod->getName();
                    $route["Filepath"]= $file->getPathname();
                }
                $routes[$classRouteInstance->path.$route["path"]]= $route;
            }
        }
        define("ROUTES", $routes);
        self::StoreJson("routes.json",$routes);
        
        $errorPathList = new RecursiveDirectoryIterator(self::$redirectDir,RecursiveDirectoryIterator::SKIP_DOTS);
        $errorPathIterator = new RecursiveIteratorIterator($errorPathList);

        $errorRoutes = [];
        foreach($errorPathIterator as $file){
            $baseName= $file->getBasename(".php");
            $errorRoutes[$baseName]=$file->getPathname();
        }
        self::StoreJson("errorRoutes.json",$errorRoutes);
    }

    private static function StoreJson(String $fileName , array $routesArray){
        file_put_contents(
            self::$mappDir.$fileName,
            json_encode($routesArray, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES,
            LOCK_EX)
        );
    }


    public static function setController(String $controllerDir)
    {
        self::$controllerDir = $controllerDir;
    }

    public static function setRedirectDir(String $redirectDir)
    {
        self::$redirectDir = $redirectDir;
    }

    public static function setMappingDir(String $mappDir)
    {
        self::$mappDir = $mappDir;
    }
}
