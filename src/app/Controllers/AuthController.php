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
        return View::layout("base", [
            "slot" => View::page("auth/signin",)
        ]);
    }

    public function signUp(): string
    {
        return $this->authService->signUp();
    }

    public function signOut(): string
    {
        return $this->authService->signOut();
    }
}