<?php
require_once BASE."/app/mapping/Route.php";


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

    #[Route('/ViewProduct')]
    public function viewProduct()
    {
        session_start();
        require_once(BASE . "/app/views/User/viewProduct.php");
    }

    #[Route('/Profile')]
    public function profile()
    {
        require_once(BASE . "/app/views/User/profile.php");
    }

    #[Route('/Checkout')]
    public function checkout()
    {
        require_once(BASE . "/app/views/User/checkout.php");
    }

    #[Route('/Search')]
    public function search()
    {
        require_once(BASE . "/app/views/User/search.php");
    }

}
