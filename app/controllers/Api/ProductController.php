<?php

require_once(BASE."/app/model/product.php");
require_once(BASE."/app/mapping/Route.php");


#[Route('/product')]
class productController
{
    private product $product;

    public  function __construct() {
        $this->product = new product();
    }
 
    #[Route('/add')]
    public function addProduct()
    {
        $this->product->add($_POST,$_FILES);
    }

    #[Route('/update')]
    public  function updateProduct()
    {
        $this->product->update($_POST,$_FILES);
    }

    #[Route('/load')]
    public  function loadProducts()
    {
        $this->product->load($_POST);
    }


    public  function loadModels()
    {
        $this->product->models($_POST);
    }

    public function revenueData()
    {
        $revenueData=$this->product->revenueData($_POST);
        echo json_encode($revenueData);
    }
}
