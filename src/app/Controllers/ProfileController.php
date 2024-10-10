<?php

namespace App\Controllers;

class ProfileController
{
    public function index(): string
    {
        return "profile:index";
    }

    public function edit(): string
    {
        return "profile:edit";
    }
}