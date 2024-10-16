<?php

namespace Core\Validation\Rule;

use Core\Validation\interface\Rule;

class RequireRule implements Rule
{

    public function validate(mixed $value): bool
    {
        return !empty($value);
    }
}