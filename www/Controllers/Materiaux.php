<?php
namespace App\Controllers;

use App\Core\View;

class Materiaux{

    public function Calculatrice(): void
    {
        new View("Materiaux/calculatrice", "base");
    }

}