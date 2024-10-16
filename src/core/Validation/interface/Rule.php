<?php

namespace Core\Validation\interface;

interface Rule
{
    public function validate(mixed $value): bool;
}