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
        $page = 1;
        $perPage = 10;

        return View::layout("base", [
            "slot" => View::page("users/index", ['users' => $this->userService->getPage($page, $perPage)])
        ]);
    }

    public function view(int $id): string
    {
        return View::layout("base", [
            "slot" => View::page("users/view", ['user' => $this->userService->getById($id)])
        ]);
    }
}