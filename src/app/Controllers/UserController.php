<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Views\View;

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): string
    {
        return View::layout("base", [
            "slot" => View::page("users/index", ['users' => $this->userService->all()])
        ]);
    }

    public function view(int $id): string
    {
        return View::layout("base", [
            "slot" => View::page("users/view", ['user' => $this->userService->getById($id)])
        ]);
    }
}