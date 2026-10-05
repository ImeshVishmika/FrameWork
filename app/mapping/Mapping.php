<?php

class Mapping
{

    private static $controller = "controllers";

    public static function config() {
        self::definePackages();
        self::regControllers();
    }

    
    private static function definePackages()
    {
        define("controllers", self::$controller);
    }

    private static function regControllers(){

        $output = shell_exec('git -C '.BASE."/app/".self::$controller.' status --short');
        echo $output;

        $controllerList = new RecursiveDirectoryIterator(BASE."/app/".self::$controller,RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($controllerList);

        $paths = [];

        foreach($iterator as $file){
            $fileName = str_replace(".php","",$file->getFilename());
            $paths[$fileName]=$file->getPathname();
        }

        file_put_contents("../app/core/controllerList.json",
        json_encode($paths,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),
        LOCK_EX);

    }

    public static function setController(String $controller)
    {
        self::$controller = $controller;
    }

}
