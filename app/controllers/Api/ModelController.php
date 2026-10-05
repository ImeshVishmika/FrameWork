<?php
require_once(BASE."/app/model/product.php");
require_once(BASE."/app/mapping/Route.php");

class ModelController
{
    private product $product;

    function __construct()
    {
        $this->product = new product();
    }

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
