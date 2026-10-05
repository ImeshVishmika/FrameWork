<?php

class Mapping
{
    private static $app = "app";

    private static $controller = "controllers";
    private static $controllerList;

    private static $service = "model";
    private static $middleware = "middleware";
    private static $core = "core";
    private static $media = "media";
    private static $views = "views";

    public static function config() {
        self::definePackages();
        self::regControllers();
    }

    private static function reflect(){
        
    }

    private static function definePackages()
    {
        define("controllers", self::$controller);
        define("service", self::$service);
        define("middleware", self::$middleware);
        define("core", self::$core);
        define("media", self::$media);
        define("views", self::$views);
        define("app", self::$app);
    }

    private static function regControllers(){

        $controllerList = new RecursiveDirectoryIterator(BASE."/app/".self::$controller);
        $iterator = new RecursiveIteratorIterator($controllerList);

        $paths = [];

        foreach($iterator as $file){
            $paths[]=$file->getPathname();
        }

        file_put_contents("../app/core/controllerList.json",
        json_encode($paths,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES),
        LOCK_EX);

    }

    public static function setController(String $controller)
    {
        self::$controller = $controller;
    }

    public static function setService(String $service)
    {
        self::$service = $service;
    }

    public static function setMiddleware(String $middleware)
    {
        self::$middleware = $middleware;
    }

    public static function setCore(String $core)
    {
        self::$core = $core;
    }

    public static function setMedia(String $media)
    {
        self::$media = $media;
    }

    public static function serViews(String $views)
    {
        self::$views = $views;
    }
}
