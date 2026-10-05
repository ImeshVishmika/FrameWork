<?php

#[Attribute(Attribute::TARGET_METHOD| Attribute::TARGET_CLASS)]
class Route{

    public String $path;

    public function __construct(String $path)
    {
        $this->$path = $path;
    }

}

?>