<?php

namespace App\Http\Controllers;

use App\Views\View;

class HomeController
{

    public function index(): string
    {
        return View::render("layouts/base", [
            "slot" => View::render("pages/home", ["customString" => "Is my custom string"])
        ]);
    }
}