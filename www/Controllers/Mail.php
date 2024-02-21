<?php
namespace App\Controllers;

use App\Core\View;

class Mail{

    public function sendMail(): void
    {
        new View("Mail/send", "base");
    }

}