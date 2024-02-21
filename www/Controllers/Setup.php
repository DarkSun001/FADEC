<?php
namespace App\Controllers;

use App\Core\View;
Class Setup{

    public function setupDb()
    {
        new View("Setup/configure_postgres", "base");
    }

}