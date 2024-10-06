<?php

namespace App\Http\Controllers;

use App\Services\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function signIn() {
        return $this->authService->signIn();
    }
}