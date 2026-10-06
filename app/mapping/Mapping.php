<?php
require_once BASE . "/app/mapping/Route.php";

class Mapping
{

    private static String $controllerPath = BASE . "/app/controllers";

    public static function config()
    {
        $output = shell_exec('git status-u '.self::$controllerPath);

        if ($output == null) {
            return;
        }

        $controllerPathList = new RecursiveDirectoryIterator(self::$controllerPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($controllerPathList);

        $paths = [];

        foreach ($iterator as $file) {
            $fileName = str_replace(".php", "", $file->getFilename());

            require_once $file->getPathname();

            $reflectionClass = new ReflectionClass($fileName);
            $classAttributes = $reflectionClass->getAttributes(Route::class);
            $classRouteInstance = $classAttributes !=null
            ? $classAttributes[0]->newInstance()
            : new Route("");

            $classMethods = $reflectionClass->getMethods();

            foreach($classMethods as $classMethod){
                $methodAttributes = $classMethod->getAttributes(Route::class);

                if($methodAttributes==null){
                    continue;
                }

                $methodRouteInstance = $methodAttributes[0]->newInstance();
                $paths[$classRouteInstance->path.$methodRouteInstance->path] = $file->getPathname();
            }
            
        }

        file_put_contents(
            "../app/core/routes.json",
            json_encode($paths, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            LOCK_EX
        );
    }


    public static function setController(String $controllerPath)
    {
        self::$controllerPath = $controllerPath;
    }
}
