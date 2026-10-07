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

    #[Route('/Profile')]
    #[Allowed('user,admin')]
    public function profile()
    {
        require_once(BASE . "/app/views/User/profile.php");
    }

    #[Route('/Checkout')]
    public function checkout()
    {
        require_once(BASE . "/app/views/User/checkout.php");
    }

    #[Route('/search')]
    public function search()
    {
        require_once(BASE . "/app/views/User/search.php");
    }

    #[Route('/InvalidUrl')]
    public function invlidUrl(){
        require_once(BASE."/app/views/User/invlidUrl.php");
    }

}
