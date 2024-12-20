<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Views\View;

class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function signIn(): string
    {
        print_r(request()->getPost());

        return View::layout("base", [
            "slot" => View::page("auth/signin")
        ]);
    }

    public function signUp(): string
    {
        return View::layout("base", [
            "slot" => View::page("auth/signup")
        ]);
    }

    public function signOut(): string
    {
        return $this->authService->signOut();
    }
}