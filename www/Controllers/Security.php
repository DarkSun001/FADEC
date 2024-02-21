<?php
namespace App\Controllers;

use App\Core\View;
class Security{

    public function login(): void
    {
        new View("Security/login", "base");
    }
    public function logout(): void
    {
        new View("Home/home", "base");
    }
    public function register(): void
    {
        new View("Security/register", "base");
    }


}