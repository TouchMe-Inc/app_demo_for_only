<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index(): string
    {
        return "index";
    }

    public function view($data, $id): string
    {
        return "view id = " . $id . ' with data = ' . $data;
    }
}