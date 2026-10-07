<?php
#[Attribute(Attribute::TARGET_METHOD)]
class Allowed{

    function __construct(public String $allowed)
    {}
}