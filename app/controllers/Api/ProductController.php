<?php

require_once(BASE."/app/model/product.php");
require_once(BASE."/app/attributes/Route.php");
require_once(BASE."/app/attributes/Allowed.php");


#[Route('/api/product')]
class productController
{
    private product $product;

    public  function __construct() {
        $this->product = new product();
    }
 
    #[Route('/load','POST')]
    public  function loadProducts()
    {
        $this->product->load();
    }


    public  function loadModels()
    {
        $this->product->models();
    }

}
