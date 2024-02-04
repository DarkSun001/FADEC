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
        echo "Logout";
    }
    public function register(): void
    {
        new View("Security/register", "base");
    }

    public function PgAdmin(): void
    {
        new View("Security/PgAdmin", "base");
    }


}