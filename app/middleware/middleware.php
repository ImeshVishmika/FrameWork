<?php

class middleware
{

    public static function auth(String $uri)
    {
        $route = ROUTES[$uri];

        if (!isset($route["allowed"])) return;
        if (!isset($_SESSION["u"])) exit(http_response_code(401));

        $allowed = explode(",", $route["allowed"]);

        if (!in_array($_SESSION["u"]["role"], $allowed))exit(http_response_code(403));
    }
}


    // function __construct()
    // {
    //     if (!isset($_SESSION)) {
    //         session_start();
    //     }
    // }

    // function isCsrf()
    // {
    //     return ((isset($_POST["csrf_token"], $_SESSION["u"]["csrf_token"]) && hash_equals($_POST["csrf_token"], $_SESSION["u"]["csrf_token"])));
    // }

    // function isLoggedIn()
    // {
    //     return isset($_SESSION["u"]);
    // }

    // function role(array $role)
    // {
    //     if (!isset($_SESSION["u"]["role"]) || !in_array($_SESSION["u"]["role"], $role)) {
    //         http_response_code(403);
    //         exit;
    //     }
    // }

    // function isUser()
    // {
    //     if (!$this->isLoggedIn() || !$this->role(["user"])) {
    //         http_response_code(403);
    //         exit;
    //     }
    // }

    // function isAdmin()
    // {
    //     if (!$this->isLoggedIn() || !$this->role(["admin"])) {
    //         http_response_code(403);
    //         exit;
    //     }
    // }
