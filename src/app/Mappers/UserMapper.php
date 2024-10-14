<?php

namespace App\Mappers;

use App\Models\User;

class UserMapper extends Mapper
{

    protected static function model(): string
    {
        return User::class;
    }
}