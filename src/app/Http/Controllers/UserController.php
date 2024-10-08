<?php

namespace App\Http\Controllers;

use App\Views\View;

class UserController
{
    public function index(): string
    {
        return View::render("layouts/base", [
            "slot" => View::render("pages/users")
        ]);
    }
}