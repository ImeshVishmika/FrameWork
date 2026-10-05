<?php
define("BASE", dirname(__DIR__));

require_once BASE.'/app/core/Router.php';
require_once BASE.'/app/mapping/Mapping.php';
require_once BASE."/app/mapping/Route.php";

require_once BASE."/app/controllers/Api/ProductController.php";


Mapping::config();
Router::reRoute();

// $reflectionClass = new ReflectionClass(productController::class);
// $class = $reflectionClass->getAttributes()[0]->newInstance();
// $methods = $reflectionClass->getMethods();


// echo"</br> Class : ". $class->path."</br>";


// foreach($methods as $method){
//     echo"-----------------";
//     echo"</br> Method : ". $method,"</br>";

//     $attributes = $method->getAttributes(Route::class);
//     foreach($attributes as $attribute){
//         $routeInstance = $attribute->newInstance();
//         echo "</br>Method Attribute:".$attribute."</br>";
//         echo "</br>Method Attribute:".$routeInstance->path."</br>";
//     }
//     echo"-----------------";
//}


