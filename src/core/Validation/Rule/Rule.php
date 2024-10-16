<?php

namespace Core\Validation\Rule;

interface Rule
{
    public function validate(mixed $value): bool;
}