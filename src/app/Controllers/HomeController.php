<?php

namespace App\Controllers;

use App\Views\View;

class HomeController
{

    public function index(): string
    {
        return View::layout("base", [
            "slot" => View::page("home/index", ["customString" => "Is my custom string"])
        ]);
    }
}