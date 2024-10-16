<?php

namespace Core\Validation\interface;

interface Validator
{

    /**
     * Check data compliance with validation rules.
     *
     * @param array $data
     * @param array $rules
     * @return bool
     */
    public function validate(array $data, array $rules): bool;

    /**
     * Get all the validation error messages.
     *
     * @return array
     */
    public function errors(): array;
}