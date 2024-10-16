<?php

namespace Core\Validation\Interface;

interface Rule
{
    public function validate(mixed $value): bool;
}