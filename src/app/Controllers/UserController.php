<?php

namespace App\Controllers;

use App\Views\View;

class UserController
{
    public function index(): string
    {
        return View::layout("base", [
            "slot" => View::page("users")
        ]);
    }
}