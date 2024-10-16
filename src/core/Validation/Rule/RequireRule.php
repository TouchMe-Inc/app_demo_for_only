<?php

namespace Core\Validation\Rule;

use Core\Validation\Interface\Rule;

class RequireRule implements Rule
{

    public function validate(mixed $value): bool
    {
        return !empty($value);
    }
}