<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        $users = $this->userRepository->all();

        // code..

        return $users;
    }

    public function getById(int $id)
    {
        $user = $this->userRepository->getById($id);

        // code..

        return $user;
    }
}