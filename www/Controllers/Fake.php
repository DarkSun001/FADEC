<?php
namespace App\Controllers;

use App\Core\View;

class Fake{

    public function fakeToken(): void
    {
        new View("Password/token", "base");
    }

}