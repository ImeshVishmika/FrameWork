<?php

#[Attribute(Attribute::TARGET_METHOD)]
class PathParam{

    function __construct(
        public String $param
    )
    {}

}