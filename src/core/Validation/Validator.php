<?php

namespace Core\Validation;

use Core\Validation\interface\Validator as ValidatorInterface;

class Validator implements ValidatorInterface
{

    private array $errors = [];

    /**
     * @inheritDoc
     */
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        // TODO: Implement validate() method.

        return true;
    }

    /**
     * @inheritDoc
     */
    public function errors(): array
    {
        return $this->errors;
    }
}