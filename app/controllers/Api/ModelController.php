<?php
require_once(BASE."/app/model/product.php");
require_once(BASE."/app/mapping/Route.php");

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
        $this->product->models($_POST);
    }

    public function revenueData()
    {
        $revenueData = $this->product->revenueData($_POST);
        echo json_encode($revenueData);
    }
}
