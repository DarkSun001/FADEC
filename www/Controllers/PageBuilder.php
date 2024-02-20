<?php

namespace App\Controllers;

use  App\Core\View;

class PageBuilder
{

    public function showPageBuilder(): void
    {
        new View("PageBuilder/page_builder", "grapesjs_base");
    }
   
}
