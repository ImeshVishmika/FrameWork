<?php
require_once BASE . "/app/mapping/Route.php";

class Mapping
{

    private static String $controllerPath = BASE . "/app/controllers";
    private static String $redirectPath = BASE . "/app/views/User/invliadUrl.php";
    private static String $routesJsonPath =BASE."/app/core/routes.json" ;
    

    public static function config()
    {
        define("redirectPath",self::$redirectPath);
        define("routesJsonPath",self::$routesJsonPath);
        // $output = shell_exec('git status -u '.self::$controllerPath);
        $output = shell_exec('git status ');

        if ($output == null) {
            define("ROUTES",json_decode(file_get_contents(routesJsonPath), true));
            return;
        }

        $controllerPathList = new RecursiveDirectoryIterator(self::$controllerPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($controllerPathList);

        $paths = [];

        foreach ($iterator as $file) {
            // $fileName = str_replace(".php", "", $file->getFilename());
            $fileName = $file->getBasename(".php");

            require_once $file->getPathname();

            $reflectionClass = new ReflectionClass($fileName);
            $classAttributes = $reflectionClass->getAttributes(Route::class);
            $classRouteInstance = $classAttributes !=null
            ? $classAttributes[0]->newInstance()
            : new Route("");

            $classMethods = $reflectionClass->getMethods();

            foreach($classMethods as $classMethod){
                $methodAttributes = $classMethod->getAttributes(Route::class);
                echo json_encode($methodAttributes);

                if($methodAttributes==null){
                    continue;
                }

                $methodRouteInstance = $methodAttributes[0]->newInstance();
                $paths[$classRouteInstance->path.$methodRouteInstance->path] =[
                    "class"=>$file->getBasename(".php"),
                    "method"=>$classMethod->getName(),
                    "httpMethod"=>$methodRouteInstance->httpMethod,
                    "path"=>$file->getPathname()
                ];
            } 
        }

        file_put_contents(
            routesJsonPath,
            json_encode($paths, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            LOCK_EX
        );

        define("ROUTES",$paths);
        
    }


    public static function setController(String $controllerPath)
    {
        self::$controllerPath = $controllerPath;
    }

    public static function setInvalidPathRedirect(String $redirectPath){
        self::$redirectPath = $redirectPath;
    }

    public static function setRouteJsonPath(String $routesJsonPath){
        self::$routesJsonPath = $routesJsonPath;
    }
}
