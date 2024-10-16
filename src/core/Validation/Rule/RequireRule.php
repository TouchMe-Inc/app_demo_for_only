<?php

namespace Core\Validation\Rule;

class RequireRule implements Rule
{

    public function validate(mixed $value): bool
    {
        return !empty($value);
    }
}