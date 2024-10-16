<?php

namespace Core\Validation\Rule;

use Core\Validation\interface\Rule;

class EmailRule implements Rule
{

    public function validate(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}