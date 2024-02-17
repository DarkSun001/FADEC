<?php
namespace App\Controllers;

use App\Core\View;

class Back
{
    public function home(): void
    {
        new View("BackOffice/home", "base");
    }
}