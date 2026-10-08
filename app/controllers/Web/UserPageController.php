<?php
require_once(BASE."/app/attributes/Route.php");


class UserPageController
{
    
    #[Route('/')]
    public function index()
    {
        require_once(BASE . "/app/views/User/index.php");
    }

    #[Route('/logIn')]
    public function logIn()
    {
        require_once(BASE . "/app/views/User/signin.php");
    }

    #[Route('/viewProduct')]
    #[PathParam('id')]
    public function viewProduct()
    {
        session_start();
        require_once(BASE . "/app/views/User/viewProduct.php");
    }

}
