<?php
namespace App\Controllers;

use App\Core\View;
class Dash{

    public function dash(): void
    {
        new View("dashboard/board", "base");
    }
}