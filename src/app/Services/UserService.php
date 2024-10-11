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

    public function getPage($page, $perPage)
    {
        $users = $this->userRepository->getPage($page, $perPage);

        // code..

        return $users;
    }

    public function getById(int $id)
    {
        $user = $this->userRepository->getPage($id);

        // code..

        return $user;
    }
}