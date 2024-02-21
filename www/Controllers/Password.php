<?php
namespace App\Controllers;

use App\Core\View;
class Password{

    public function reset(): void
    {
        new View("password/reset_password", "base");
    }

    public function forgot(): void
    {
        new View("password/forgot_password", "base");
    }
}