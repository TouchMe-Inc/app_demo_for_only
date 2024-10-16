<?php

namespace Core\Validation\Interface;

interface Rule
{
    /**
     * Run the validation rule.
     *
     * @param mixed $value
     * @return bool
     */
    public function validate(mixed $value): bool;
}