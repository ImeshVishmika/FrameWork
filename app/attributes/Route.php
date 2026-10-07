<?php

#[Attribute(Attribute::TARGET_METHOD|Attribute::TARGET_CLASS)]
class Route{

    public function __construct(
        public String $path,
        public String $httpMethod = "GET"
    )
    {}


//=======================Method Overloading is not allowed in PHP============================================
    // public function __construct(String $path)
    // {
    //     $this->path = $path;
    //     $this->httpMethod = "GET";
    // }

    // public function __construct(String $path , String $httpMethod)
    // {
    //     $this->path = $path;
    //     $this->httpMethod = $httpMethod;
    // }

}

?>