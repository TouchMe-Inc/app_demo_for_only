<?php

namespace App\Http\Controllers;

use App\Views\View;

class HomeController
{

    public function index(): string
    {
        return View::layout("base", [
            "slot" => View::page("home", ["customString" => "Is my custom string"])
        ]);
    }
}