<?php
require_once(BASE."/app/model/product.php");
require_once(BASE."/app/attributes/Route.php");

#[Route('/api/model')]
class ModelController
{
    private product $product;

    function __construct()
    {
        $this->product = new product();
    }

    #[Route('/load','POST')]
    public  function loadModels()
    {
        $this->product->models();
    }
}
