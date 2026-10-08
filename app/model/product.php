<?php
require_once(BASE . "/config/connection.php");

class product
{
    public function load()
    {
        echo json_encode([
            "success" => true,
            "data" => json_decode(file_get_contents(BASE . "/app/cache/product.json")),
            "error" => null
        ]);
    }

    public function models()
    {
        echo json_encode([
            "success" => true,
            "models"=>json_decode(file_get_contents(BASE . "/app/cache/model.json")),
            "error" => null
        ]);
    }
}
